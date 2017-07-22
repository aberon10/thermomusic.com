<?php

namespace App\Libs;

use UploadFileException;

/**
 * Permite validar y subir multiples archivos al servidor.
 *
 * - Tipo Mime
 * - Nombre del archivo
 * - Tamaño
 * 
 * @author [abzerox]
 * @version 1.0.0
 */
class UploadFile
{
	public static $mimes = null;
	public static $destination = null;
	private static $upload_max_filesize = '2M';

	/**
	 * upload 
	 * @return true
	 */
	public static function upload($index) {
		if (!isset($index) || !is_string($index)) {
			throw new \Exception('[ ERROR ] No se indico un indice valido del array $_FILES.');			
		}
		
		if (isset($_FILES[$index]) && isset($_FILES[$index]['name'][0])) {
			if ($_FILES[$index]['error'][0] === UPLOAD_ERR_OK) {
				UploadFile::_validateDestination();

				for ($i = 0; $i < count($_FILES[$index]['name']); $i++) { 
					if (!UploadFile::_validateFileType($_FILES[$index]['type'][$i]) && isset(UploadFile::$mimes)) {
						throw new \Exception('[ ERROR ] El archivo '.$_FILES[$index]['name'][$i]. 
							' no es de un tipo valido.');
					} else if (!UploadFile::_validateFileSize($_FILES[$index]['size'][$i])) {
						throw new \Exception('[ ERROR ] El archivo '.$_FILES[$index]['name'][$i]. 
							' supera el tamaño admitido.');
					} else if (!UploadFile::_validateFilename($_FILES[$index]['name'][$i])) {
						throw new \Exception('[ ERROR ] El nombre '.$_FILES[$index]['name'][$i]. 
							' no es un nombre valido.');
					} 

					if (!move_uploaded_file($_FILES[$index]['tmp_name'][$i], 
						UploadFile::$destination.'/'.$_FILES[$index]['name'][$i])) {
						throw new \Exception('[ ERROR ] Al subir el archivo '.$_FILES[$index]['name'][$i]);
					}
				}

				return true;
			} else {
				throw new UploadFileException($_FILES[$index]['error'][0]);
			}
		} else {
	        throw new \Exception('No se pudo subir el/los archivo/s.');
		}
	}

	/**
	 * setUploadMaxFileSize
	 * @param string $size
	 */
	public static function setUploadMaxFileSize($size) {
		if (preg_match('/^[0-9]+[GgKkMm]{1}$/', $size)) {
			if (UploadFile::_convertToBytes($size) > UploadFile::_convertToBytes(ini_get('upload_max_filesize'))) {
				throw new \Exception('[ ERROR ] El valor de size debe ser menor igual a '.ini_get('upload_max_filesize'));
			}
			UploadFile::$upload_max_filesize = UploadFile::_convertToBytes($size); 
		} else {
			throw new \Exception('[ ERROR ] El valor de size no es valido.');
		}
	}

	/**
	 * _validateDestination
	 * @return void
	 */
	private static function _validateDestination() {
		if (isset(UploadFile::$destination) && (is_string(UploadFile::$destination) || 
			is_int(UploadFile::$destination))) {
			if (!file_exists(UploadFile::$destination)) {
				@mkdir((string) UploadFile::$destination, 0777);
			}
		} else {
			throw new \Exception('[ ERROR ] No se indico un destino valido.');
		}
	}	

	/**
     * _convertToBytes
     * Convierte de Gigas, Megas y Kilobytes a los Bytes equivalentes.
     * @param  string $size
     * @return int
     */
    public static function _convertToBytes($size) {
        switch (substr($size, -1)) {
            case 'M': case 'm': return (int) $size * 1048576;
            case 'K': case 'k': return (int) $size * 1024;
            case 'G': case 'g': return (int) $size * 1073741824;
            default: return $size;
        }
    }

    /**
     * _validateFilename
     * @param  string $filename
     * @return true|false
     */
    private static function _validateFilename($filename) {
        return preg_match('/^[\w\dÁÉÍÓÚÑáéíóúñ\.\-\s]{1,255}$/', $filename);
    }

    /**
     * _validateFileSize
     * @param  string $filesize
     * @return true|false
     */
    private static function _validateFileSize($filesize) {
        return UploadFile::$upload_max_filesize > $filesize;
    }

    /**
     * _validateFileType 
     * @param  string $filetype
     * @return true|false           
     */
    private static function _validateFileType($filetype) {
        if (is_array(UploadFile::$mimes)) {
			for ($i = 0; $i < count(UploadFile::$mimes); $i++) { 
				if (in_array($filetype, UploadFile::$mimes)) {
					return true;
				}
			}
		} else if (is_string(UploadFile::$mimes)) {
            return $filetype == UploadFile::$mimes;
        }
        return false;
    }
}