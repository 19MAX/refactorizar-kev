<?php

namespace App\Services;

use Config\Services;
use CodeIgniter\HTTP\ResponseInterface;

class EmailApi
{

    protected $apiUrl;
    protected $apiKey;
    protected $from;
    protected $to;

    public function __construct()
    {
        $this->apiUrl = env('EMAIL_API_URL');
        $this->apiKey = env('EMAIL_API_KEY');
        $this->from = env('FROM_EMAIL');
        $this->to = env('TO_EMAIL');
    }

    public function sendEmail($subject, $message, $attachments = [], $customTo = null)
    {
        // Validar parámetros requeridos
        if (empty($subject) || empty($message)) {
            return [
                'status' => false,
                'message' => 'Asunto y mensaje son requeridos'
            ];
        }

        // Validar configuración
        if (empty($this->apiUrl) || empty($this->apiKey) || empty($this->from)) {
            log_message('error', 'EmailApi: Configuración incompleta - revisar variables de entorno');
            return [
                'status' => false,
                'message' => 'Configuración de email incompleta'
            ];
        }

        // Usar email personalizado si se proporciona
        $sendTo = $customTo;
        if (empty($sendTo)) {
            log_message('error', 'EmailApi: No se especificó destinatario');
            return [
                'status' => false,
                'message' => 'Destinatario de email no especificado'
            ];
        }

        try {
            // Verificar si hay archivos adjuntos válidos
            $hasValidAttachments = $this->hasValidAttachments($attachments);

            if ($hasValidAttachments) {
                // Usar FormData cuando hay archivos
                log_message('debug', 'EmailApi: Enviando con FormData (archivos adjuntos)', [
                    'to' => is_array($sendTo) ? $sendTo : [$sendTo],
                    'subject' => $subject,
                    'attachments_count' => count($attachments)
                ]);

                return $this->sendWithFormData($subject, $message, $sendTo, $attachments);
            } else {
                // Usar JSON cuando no hay archivos
                log_message('debug', 'EmailApi: Enviando con JSON (sin archivos)', [
                    'to' => is_array($sendTo) ? $sendTo : [$sendTo],
                    'subject' => $subject
                ]);

                return $this->sendWithJson($subject, $message, $sendTo);
            }

        } catch (\Exception $e) {
            log_message('error', 'EmailApi: Excepción en envío de correo - ' . $e->getMessage(), [
                'url' => $this->apiUrl,
                'subject' => $subject,
                'trace' => $e->getTraceAsString()
            ]);
            return [
                'status' => false,
                'message' => 'Error de conexión con el servicio de correo: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Verifica si hay archivos adjuntos válidos
     */
    protected function hasValidAttachments($attachments)
    {
        if (empty($attachments) || !is_array($attachments)) {
            return false;
        }

        foreach ($attachments as $attachment) {
            if (is_string($attachment) && file_exists($attachment)) {
                return true;
            }
            if (is_array($attachment) && isset($attachment['path']) && file_exists($attachment['path'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Envía email usando FormData (con archivos adjuntos)
     */
    protected function sendWithFormData($subject, $message, $sendTo, $attachments)
    {
        try {
            // Crear boundary para multipart/form-data
            $boundary = '----FormBoundary' . uniqid();

            // Construir el cuerpo del formulario
            $postData = '';

            // Agregar campos básicos
            $postData .= $this->addFormField($boundary, 'from', $this->from);
            $postData .= $this->addFormField($boundary, 'subjectEmail', $subject);
            $postData .= $this->addFormField($boundary, 'message', $message);

            // Agregar destinatarios
            $recipients = is_array($sendTo) ? $sendTo : [$sendTo];
            foreach ($recipients as $email) {
                $postData .= $this->addFormField($boundary, 'sendTo[]', $email);
            }

            // Agregar archivos
            foreach ($attachments as $attachment) {
                $filePath = is_string($attachment) ? $attachment : $attachment['path'];
                $fileName = is_array($attachment) && isset($attachment['filename'])
                    ? $attachment['filename']
                    : basename($filePath);

                if (file_exists($filePath)) {
                    $fileContent = file_get_contents($filePath);
                    $mimeType = mime_content_type($filePath) ?: 'application/octet-stream';

                    $postData .= "--{$boundary}\r\n";
                    $postData .= "Content-Disposition: form-data; name=\"attachments\"; filename=\"{$fileName}\"\r\n";
                    $postData .= "Content-Type: {$mimeType}\r\n\r\n";
                    $postData .= $fileContent . "\r\n";
                }
            }

            $postData .= "--{$boundary}--\r\n";

            // Realizar petición CURL
            $ch = curl_init($this->apiUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'x-key-emitto: ' . $this->apiKey,
                'Content-Type: multipart/form-data; boundary=' . $boundary,
                'Content-Length: ' . strlen($postData)
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            return $this->processResponse($response, $httpCode, $error, $subject, $recipients);

        } catch (\Exception $e) {
            log_message('error', 'EmailApi: Error en sendWithFormData - ' . $e->getMessage());
            return [
                'status' => false,
                'message' => 'Error enviando con archivos adjuntos: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Envía email usando JSON (sin archivos adjuntos)
     */
    protected function sendWithJson($subject, $message, $sendTo)
    {
        try {
            $emailData = [
                'from' => $this->from,
                'subjectEmail' => $subject,
                'sendTo' => is_array($sendTo) ? $sendTo : [$sendTo],
                'message' => $message,
                'attachments' => []
            ];

            $ch = curl_init($this->apiUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'x-key-emitto: ' . $this->apiKey,
                'Content-Type: application/json'
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($emailData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            return $this->processResponse($response, $httpCode, $error, $subject, is_array($sendTo) ? $sendTo : [$sendTo]);

        } catch (\Exception $e) {
            log_message('error', 'EmailApi: Error en sendWithJson - ' . $e->getMessage());
            return [
                'status' => false,
                'message' => 'Error enviando sin archivos adjuntos: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Procesa la respuesta del servidor
     */
    protected function processResponse($response, $httpCode, $error, $subject, $recipients)
    {
        if ($response === false || !empty($error)) {
            log_message('error', 'EmailApi: Error CURL - ' . $error);
            return [
                'status' => false,
                'message' => 'Error CURL: ' . $error,
                'http_code' => $httpCode
            ];
        }

        if ($httpCode >= 200 && $httpCode < 300) {
            log_message('info', 'EmailApi: Correo enviado exitosamente', [
                'to' => $recipients,
                'subject' => $subject,
                'http_code' => $httpCode
            ]);
            return [
                'status' => true,
                'message' => 'Correo enviado correctamente',
                'response' => $response,
                'http_code' => $httpCode
            ];
        } else {
            log_message('warning', 'EmailApi: Error HTTP ' . $httpCode, [
                'subject' => $subject,
                'response' => substr($response, 0, 500)
            ]);
            return [
                'status' => false,
                'message' => 'Error del servidor de email (HTTP ' . $httpCode . ')',
                'details' => $response,
                'http_code' => $httpCode
            ];
        }
    }

    /**
     * Agrega un campo al formulario multipart
     */
    protected function addFormField($boundary, $name, $value)
    {
        return "--{$boundary}\r\n" .
            "Content-Disposition: form-data; name=\"{$name}\"\r\n\r\n" .
            "{$value}\r\n";
    }

    /**
     * Procesa los archivos adjuntos para el API (método mantenido para compatibilidad)
     */
    protected function processAttachments($attachments)
    {
        $processedAttachments = [];

        if (!is_array($attachments)) {
            return $processedAttachments;
        }

        foreach ($attachments as $attachment) {
            if (is_string($attachment) && file_exists($attachment)) {
                // Si es una ruta de archivo, procesarlo con el formato correcto para tu API
                $processedAttachments[] = [
                    'filename' => basename($attachment),
                    'path' => $attachment
                ];
            } elseif (is_array($attachment)) {
                if (isset($attachment['path']) && file_exists($attachment['path'])) {
                    // Si es un array con información del archivo
                    $processedAttachments[] = [
                        'filename' => $attachment['name'] ?? basename($attachment['path']),
                        'path' => $attachment['path']
                    ];
                } elseif (isset($attachment['filename']) && isset($attachment['path'])) {
                    // Si ya está en el formato correcto
                    if (file_exists($attachment['path'])) {
                        $processedAttachments[] = $attachment;
                    }
                }
            }
        }

        return $processedAttachments;
    }

    /**
     * Obtiene información del archivo para adjuntar (método mantenido para compatibilidad)
     */
    protected function getFileInfo($filePath, $customName = null)
    {
        try {
            if (!file_exists($filePath) || !is_readable($filePath)) {
                log_message('warning', 'EmailApi: Archivo no existe o no es legible: ' . $filePath);
                return null;
            }

            $fileName = $customName ?: basename($filePath);
            $fileSize = filesize($filePath);

            // Verificar tamaño del archivo (límite de 10MB por ejemplo)
            $maxSize = 10 * 1024 * 1024; // 10MB
            if ($fileSize > $maxSize) {
                log_message('warning', 'EmailApi: Archivo demasiado grande: ' . $filePath . ' (' . $fileSize . ' bytes)');
                return null;
            }

            return [
                'filename' => $fileName,
                'path' => $filePath
            ];

        } catch (\Exception $e) {
            log_message('error', 'EmailApi: Error procesando archivo adjunto: ' . $e->getMessage(), [
                'file' => $filePath
            ]);
            return null;
        }
    }

    /**
     * Envía un email simple sin archivos adjuntos
     */
    public function sendSimpleEmail($to, $subject, $message)
    {
        return $this->sendEmail($subject, $message, [], $to);
    }

    /**
     * Envía un email con un solo archivo adjunto
     */
    public function sendEmailWithAttachment($to, $subject, $message, $attachmentPath, $attachmentName = null)
    {
        $attachment = $attachmentName ? ['path' => $attachmentPath, 'name' => $attachmentName] : $attachmentPath;
        return $this->sendEmail($subject, $message, [$attachment], $to);
    }

    /**
     * Verifica la configuración del servicio
     */
    public function checkConfiguration()
    {
        $config = [
            'api_url' => !empty($this->apiUrl),
            'api_key' => !empty($this->apiKey),
            'from_email' => !empty($this->from)
        ];

        $isValid = array_reduce($config, function ($carry, $item) {
            return $carry && $item;
        }, true);

        return [
            'valid' => $isValid,
            'config' => $config
        ];
    }
}