<?php

if (!function_exists('uploadImage')) {
    function uploadImage($file, $path = 'assets/images/events/')
    {
        // Ruta de subida completa
        $uploadPath = ROOTPATH . 'public/' . $path;

        // Verificar si la ruta existe, si no, crearla
        if (!is_dir($uploadPath)) {
            if (!mkdir($uploadPath, 0777, true)) {
                log_message('error', 'Error creating directory: ' . $uploadPath);
                return false;
            }
        }
        
        // Siempre intentar establecer permisos 777
        @chmod($uploadPath, 0777);
        
        // Verificar nuevamente si es escribible después del chmod
        clearstatcache(); // Limpiar cache de estado de archivos

        try {
            // Validar que el archivo es válido y no se ha movido
            if ($file->isValid() && !$file->hasMoved()) {
                // Verificar que el directorio tiene permisos de escritura
                if (!is_writable($uploadPath)) {
                    log_message('error', 'Directory is not writable: ' . $uploadPath);
                    return false;
                }

                // Generar un nombre aleatorio para la imagen
                $newName = $file->getRandomName();
                
                // Verificar que el archivo no existe
                if (file_exists($uploadPath . $newName)) {
                    $newName = $file->getRandomName(); // Generar otro nombre
                }
                
                // Mover la imagen al destino
                if ($file->move($uploadPath, $newName)) {
                    // Retornar la ruta de la imagen excluyendo "public"
                    return $path . $newName;
                } else {
                    log_message('error', 'Failed to move file to: ' . $uploadPath . $newName);
                    return false;
                }
            } else {
                $error = $file->getErrorString();
                log_message('error', 'Invalid file or already moved. Error: ' . $error);
                return false;
            }
        } catch (\Exception $e) {
            log_message('error', 'Error uploading image: ' . $e->getMessage());
            return false;
        }
    }
}