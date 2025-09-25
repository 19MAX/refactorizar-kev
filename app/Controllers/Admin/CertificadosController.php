<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CertificadosModel;
use App\Models\RegistrationsModel;
use App\Models\PaymentsModel;
use App\Models\EventsModel;
use App\Models\CertificatesSentModel;
use App\Models\ConfigModel;
use App\Services\CertificateService;
use CodeIgniter\Queue\Queue;
use App\Jobs\CertificateEmail;
use ModulosAdmin;
use PaymentStatus;

class CertificadosController extends BaseController
{

    private $certificateService;
    public function __construct()
    {
        // Cargar el servicio de certificados
        $this->certificateService = new CertificateService();
    }

    private function redirectView($validation = null, $flashMessages = null, $last_data = null, $last_action = null, $route = null)
    {
        return redirect()->to($route)->
            with('flashValidation', isset($validation) ? $validation->getErrors() : null)->
            with('flashMessages', $flashMessages)->
            with('last_data', $last_data)->
            with('last_action', $last_action);
    }

    // Listar certificados
    public function index()
    {
        $model = new CertificadosModel();
        $certificados = $model->listarCertificados();

        return view('admin/certificados/index', [
            'certificados' => $certificados
        ]);
    }

    // Formulario de subida
    public function nuevo()
    {
        return view('admin/certificados/nuevo');
    }

    // Guardar el certificado subido
    public function guardar()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nombre_certificado' => 'required|string|max_length[255]',
            'archivo_certificado' => 'uploaded[archivo_certificado]|max_size[archivo_certificado,4096]|ext_in[archivo_certificado,pdf,jpg,jpeg,png]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $file = $this->request->getFile('archivo_certificado');
        $nombreCert = $this->request->getPost('nombre_certificado');
        $userId = session('user_id') ?? 1; // ¡Ajusta esto según tu lógica de sesión!

        if ($file->isValid() && !$file->hasMoved()) {
            $newName = uniqid() . '_' . $file->getClientName();
            $file->move(ROOTPATH . 'public/uploads/certificados/', $newName);

            $model = new CertificadosModel();
            $model->insertarCertificado($nombreCert, $newName, $userId);

            return redirect()->to(base_url('admin/certificados'))->with('flashMessages', [['Certificado subido correctamente.', 'success']]);
        }

        return redirect()->back()->with('flashMessages', [['Error al subir el archivo.', 'error']]);
    }

    /**
     * Mostrar usuarios con pagos completados para envío de certificados
     */
    public function gestionarCertificados()
    {
        $registrationsModel = new RegistrationsModel();
        $certificatesSentModel = new CertificatesSentModel();

        // Obtener usuarios con pagos completados (payment_status = 2)
        $completedPayments = $registrationsModel->getAllInscriptionsWithPaymentMethodAndStatus();

        // Filtrar solo los completados y agregar información de si ya se envió certificado
        $eligibleUsers = [];
        foreach ($completedPayments as $payment) {
            if ($payment['estado_pago'] == PaymentStatus::Completado) { // Solo pagos completados
                $payment['certificate_sent'] = $certificatesSentModel->isCertificateSent(
                    $payment['id'],
                    $this->getPaymentIdByRegistrationId($payment['id'])
                );
                $eligibleUsers[] = $payment;
            }
        }
        $modulo = ModulosAdmin::CERTIFICADOS;

        return view('admin/certificados/gestionar', [
            'users' => $eligibleUsers,
            'modulo' => $modulo
        ]);
    }

    /**
     * Enviar certificado individual
     */
    public function enviarCertificado($registrationId)
    {
        try {
            $registrationsModel = new RegistrationsModel();
            $paymentsModel = new PaymentsModel();
            $eventsModel = new EventsModel();
            $certificatesSentModel = new CertificatesSentModel();

            // Obtener información del usuario y pago
            $registration = $registrationsModel->find($registrationId);
            if (!$registration) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Registro no encontrado'
                ]);
            }

            // Verificar que el pago esté completado
            $payment = $paymentsModel->where('id_register', $registrationId)
                ->where('payment_status', 2)
                ->first();

            if (!$payment) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'No hay pago completado para este registro'
                ]);
            }

            // Verificar si ya se envió el certificado
            if ($certificatesSentModel->isCertificateSent($registrationId, $payment['id'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'El certificado ya fue enviado anteriormente'
                ]);
            }

            // Obtener información del evento
            $event = $eventsModel->find($registration['event_cod']);

            // Preparar datos para el certificado
            $certificateData = [
                'user_name' => $registration['full_name_user'],
                'event_name' => $event['event_name'] ?? $registration['event_name'],
                'event_date' => $event['event_date'] ?? null,
                'event_modality' => $event['modality'] ?? null,
                'registration_id' => $registrationId,
                'payment_id' => $payment['id']
            ];


            // $certificateData = [
            //     'user_name' => $registration['full_name_user'],
            //     'event_name' => $event['event_name'] ?? $registration['event_name'],
            //     'event_date' => $event['event_date'] ?? null,
            //     'event_modality' => $event['modality'] ?? null,
            //     // 'registration_id' => $registrationId,
            //     // 'payment_id' => $payment['id']
            // ];
            // Agregar job a la cola
            // $queue = service('queue');
            // $queueDate = [
            //     'to' => $registration['email'],
            //     'subject' => 'Certificado de Participación - ' . $certificateData['event_name'],
            //     'message' => $this->getCertificateEmailMessage($registration['full_name_user'], $certificateData['event_name']),
            //     'certificateData' => $certificateData,
            //     'registrationId' => $registrationId,
            //     'paymentId' => $payment['id'],
            //     'sentBy' => session('user_id')
            // ];

            // Usar el servicio de certificados
            $result = $this->certificateService->sendCertificate($registrationId, session('id'),$certificateData);

            // Verificar el resultado del servicio
            if ($result['success']) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Certificado enviado exitosamente'
                ]);
            } else {

                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error del servicio de certificados: ' . $result['message']
                ]);
            }


        } catch (\Exception $e) {
            log_message('error', 'Error enviando certificado: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error interno del servidor'
            ]);
        }
    }

    /**
     * Enviar certificados masivamente
     */
    public function enviarCertificadosMasivo()
    {
        try {
            $registrationsModel = new RegistrationsModel();
            $paymentsModel = new PaymentsModel();
            $eventsModel = new EventsModel();
            $certificatesSentModel = new CertificatesSentModel();

            // Obtener todos los pagos completados
            $completedPayments = $registrationsModel->getAllInscriptionsWithPaymentMethodAndStatus();

            $sentCount = 0;
            $skippedCount = 0;

            foreach ($completedPayments as $paymentInfo) {
                if ($paymentInfo['estado_pago'] != 2) {
                    continue; // Solo procesar pagos completados
                }

                $registrationId = $paymentInfo['id'];
                $payment = $paymentsModel->where('id_register', $registrationId)
                    ->where('payment_status', 2)
                    ->first();

                if (!$payment) {
                    continue;
                }

                // Verificar si ya se envió el certificado
                if ($certificatesSentModel->isCertificateSent($registrationId, $payment['id'])) {
                    $skippedCount++;
                    continue;
                }

                // Obtener información del evento
                $event = $eventsModel->find($paymentInfo['event_cod']);

                // Preparar datos para el certificado
                $certificateData = [
                    'user_name' => $paymentInfo['full_name_user'],
                    'event_name' => $event['event_name'] ?? $paymentInfo['event_name'],
                    'event_date' => $event['event_date'] ?? null,
                    'event_modality' => $event['modality'] ?? null
                ];

                // Preparar datos para la cola (igual que en el método individual)
                $queueDate = [
                    'to' => $paymentInfo['email'],
                    'subject' => 'Certificado de Participación - ' . $certificateData['event_name'],
                    'message' => $this->getCertificateEmailMessage($paymentInfo['full_name_user'], $certificateData['event_name']),
                    'certificateData' => $certificateData,
                    'registrationId' => $registrationId,
                    'paymentId' => $payment['id'],
                    'sentBy' => session('user_id')
                ];

                // Agregar job a la cola (igual que en el método individual)
                service('queue')->push('emailcertificados', 'emailcertificados', $queueDate);

                $sentCount++;
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => "Se agregaron {$sentCount} certificados a la cola de envío. {$skippedCount} certificados ya habían sido enviados."
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error enviando certificados masivamente: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error interno del servidor'
            ]);
        }
    }

    /**
     * Ver historial de certificados enviados
     */
    public function historial()
    {
        $certificatesSentModel = new CertificatesSentModel();
        $certificates = $certificatesSentModel->getAllSentCertificates();

        $modulo = ModulosAdmin::CERTIFICADOS_HISTORIAL;

        return view('admin/certificados/historial', [
            'certificates' => $certificates,
            'modulo' => $modulo
        ]);
    }

    //Reenviar certificado
    public function reenviarCertificado($registrationId)
    {
        try {
            $registrationsModel = new RegistrationsModel();
            $paymentsModel = new PaymentsModel();
            $eventsModel = new EventsModel();

            // Obtener información del usuario y pago
            $registration = $registrationsModel->find($registrationId);
            if (!$registration) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Registro no encontrado'
                ]);
            }

            // Verificar que el pago esté completado
            $payment = $paymentsModel->where('id_register', $registrationId)
                ->where('payment_status', 2)
                ->first();

            if (!$payment) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'No hay pago completado para este registro'
                ]);
            }

            // Obtener información del evento
            $event = $eventsModel->find($registration['event_cod']);

            // Preparar datos para el certificado
            $certificateData = [
                'user_name' => $registration['full_name_user'],
                'event_name' => $event['event_name'] ?? $registration['event_name'],
                'event_date' => $event['event_date'] ?? null,
                'event_modality' => $event['modality'] ?? null,
                'registration_id' => $registrationId // Agregado para el número de certificado
            ];

            // Preparar datos para el job de reenvío
            $jobData = [
                'to' => $registration['email'],
                'subject' => 'Certificado de Participación - ' . $certificateData['event_name'],
                'message' => $this->getCertificateEmailMessage($registration['full_name_user'], $certificateData['event_name']),
                'certificateData' => $certificateData
            ];

            // Usar el nuevo job SimpleEmailJob para reenvío
            service('queue')->push('simpleemail', 'simpleemail', $jobData);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Certificado agregado a la cola de reenvío'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error reenviando certificado: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error interno del servidor'
            ]);
        }
    }

    /**
     * Configuración de empresa para certificados
     */
    public function configuracion()
    {
        $configModel = new ConfigModel();
        $config = $configModel->getCompanyConfig();

        return view('admin/certificados/configuracion', [
            'config' => $config
        ]);
    }

    /**
     * Guardar configuración de empresa
     */
    public function guardarConfiguracion()
    {
        $configModel = new ConfigModel();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'company_name' => 'required|string|max_length[255]',
            'primary_color' => 'required|regex_match[/^#[0-9A-Fa-f]{6}$/]',
            'secondary_color' => 'required|regex_match[/^#[0-9A-Fa-f]{6}$/]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        try {
            $configModel->setConfigValue('company_name', $this->request->getPost('company_name'), 'Nombre de la empresa');
            $configModel->setConfigValue('primary_color', $this->request->getPost('primary_color'), 'Color primario de la empresa');
            $configModel->setConfigValue('secondary_color', $this->request->getPost('secondary_color'), 'Color secundario de la empresa');

            // Manejar logo
            $logoFile = $this->request->getFile('company_logo');
            if ($logoFile && $logoFile->isValid() && !$logoFile->hasMoved()) {
                if (!in_array($logoFile->getClientMimeType(), ['image/jpeg', 'image/png', 'image/gif'])) {
                    return redirect()->back()->withInput()->with('flashMessages', [['El logo debe ser una imagen válida (JPG, PNG, GIF)', 'danger']]);
                }
                $newName = 'logo_' . time() . '.' . $logoFile->getClientExtension();
                $logoFile->move(ROOTPATH . 'public/uploads/company/', $newName);
                $configModel->setConfigValue('company_logo', 'uploads/company/' . $newName, 'Logo de la empresa');
            }

            // Manejar firma
            $signatureFile = $this->request->getFile('signature_image');
            if ($signatureFile && $signatureFile->isValid() && !$signatureFile->hasMoved()) {
                if (!in_array($signatureFile->getClientMimeType(), ['image/jpeg', 'image/png', 'image/gif'])) {
                    return redirect()->back()->withInput()->with('flashMessages', [['La firma debe ser una imagen válida (JPG, PNG, GIF)', 'danger']]);
                }
                if (!is_dir(ROOTPATH . 'public/uploads/signatures/')) {
                    mkdir(ROOTPATH . 'public/uploads/signatures/', 0755, true);
                }
                $newName = 'signature_' . time() . '.' . $signatureFile->getClientExtension();
                $signatureFile->move(ROOTPATH . 'public/uploads/signatures/', $newName);
                $configModel->setConfigValue('signature_image', 'uploads/signatures/' . $newName, 'Firma del certificado');
            }

            // Manejar sello
            $selloFile = $this->request->getFile('sello_image');
            if ($selloFile && $selloFile->isValid() && !$selloFile->hasMoved()) {
                if (!in_array($selloFile->getClientMimeType(), ['image/jpeg', 'image/png', 'image/gif'])) {
                    return redirect()->back()->withInput()->with('flashMessages', [['El sello debe ser una imagen válida (JPG, PNG, GIF)', 'danger']]);
                }
                if (!is_dir(ROOTPATH . 'public/uploads/sellos/')) {
                    mkdir(ROOTPATH . 'public/uploads/sellos/', 0755, true);
                }
                $newName = 'sello_' . time() . '.' . $selloFile->getClientExtension();
                $selloFile->move(ROOTPATH . 'public/uploads/sellos/', $newName);
                $configModel->setConfigValue('sello_image', 'uploads/sellos/' . $newName, 'Sello del certificado');
            }

            return $this->redirectView(null, [['Configuración guardada correctamente', 'success']], null, null, "admin/certificados/configuracion");

        } catch (\Exception $e) {
            log_message('error', 'Error guardando configuración de certificado: ' . $e->getMessage());
            return $this->redirectView(null, [['Error al guardar la configuración', 'danger']], null, null, 'admin/certificados/configuracion');
        }
    }

    /**
     * Obtener mensaje del email para certificados
     */
    private function getCertificateEmailMessage($userName, $eventName)
    {
        return "
            <h2>¡Felicidades {$userName}!</h2>
            <p>Adjunto encontrarás tu certificado de participación en el evento: <strong>{$eventName}</strong></p>
            <p>Gracias por tu participación.</p>
            <p>Atentamente,<br>El equipo organizador</p>
        ";
    }

    /**
     * Obtener ID de pago por ID de registro
     */
    private function getPaymentIdByRegistrationId($registrationId)
    {
        $paymentsModel = new PaymentsModel();
        $payment = $paymentsModel->where('id_register', $registrationId)
            ->where('payment_status', 2)
            ->first();
        return $payment ? $payment['id'] : null;
    }
}