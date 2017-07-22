<?php

namespace App\Libs;

class UploadFileException extends \Exception
{

    public function __construct($code) {
        $message = $this->codeToMessage($code);
        parent::__construct($message, $code);
    }

    private function codeToMessage($code) {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                // El fichero subido excede la directiva upload_max_filesize de php.ini.
                $message = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
                break;
            case UPLOAD_ERR_FORM_SIZE:
                // El fichero subido excede la directiva MAX_FILE_SIZE especificada en el formulario HTML.
                $message = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
                break;
            case UPLOAD_ERR_PARTIAL:
                // El fichero fue sólo parcialmente subido.
                $message = 'The uploaded file was only partially uploaded';
                break;
            case UPLOAD_ERR_NO_FILE:
                // No se subió ningún fichero.
                $message = 'No file was uploaded';
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                // Falta la carpeta temporal.
                $message = 'Missing a temporary folder';
                break;
            case UPLOAD_ERR_CANT_WRITE:
                // No se pudo escribir el fichero en el disco.
                $message = 'Failed to write file to disk';
                break;
            case UPLOAD_ERR_EXTENSION:
                // Una extensión de PHP detuvo la subida de ficheros. PHP no proporciona una forma de determinar la extensión
                // que causó la parada de la subida de ficheros
                $message = 'File upload stopped by extension';
                break;
            default:
                // Error desconocido
                $message = 'Unknown upload error';
                break;
        }
        return $message;
    }
}