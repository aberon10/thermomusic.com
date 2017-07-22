<?php

namespace App\Libs;

/**
 * Clase útil para realizar algunas operaciones básicas sobre
 * archivos y directorios.
 * 
 * - Copiar archivos
 * - Mover
 * - Borrar directorios
 * - Borrar archivos
 * - Encontrar archivos por extensión/expresión regular
 * 
 * @author [abzerox]
 * @version 1.0.0
 */
class File
{
	/**
	 * $results
	 * Guarda los archivos encontrados por el método find.
	 * @var array
	 */
	public static $results = array();

	/**
	 * fullCopy
	 * Copia el contenido de un directorios a otro.
	 * En caso de que el archivo no exista, o que exista un archivo 
	 * con el nombre del directorio destino lanza una Excepción.
	 * @param string $source
	 * @param string $target
	 */
	public static function fullCopy($source, $target) {
		if (!file_exists($target)) {
			@mkdir($target);
		} else if (!is_dir($target)) {
			throw new \Exception('El nombre «'.basename($target).'» ya se está usando en el directorio destino. Por favor use un nombre distinto.');
		}

		if (is_dir($source)) {
			$directory = opendir($source);
			while (false !== ($entry = readdir($directory))) {
				if ($entry != '.' && $entry != '..') {
					$tmp_entry = $source.'/'.$entry;
					(is_dir($tmp_entry)) ? self::fullCopy($tmp_entry, $target.'/'.$entry) : copy($tmp_entry, $target.'/'.$entry);
				}
			}
			closedir($directory);
			clearstatcache();
		} else {
			if (file_exists($source)) {
				copy($source, $target.'/'.basename($source));
			} else {
				throw new \Exception('No existe el archivo de nombre '.$source);
			}
		}
	}

	/**
	 * move
	 * @param  string $source
	 * @param  string $target
	 * @return bool
	 */
	public static function move($source, $target) {
		self::fullCopy($source, $target);
		return self::remove($source);
	}

	/**
	 * removeDir
	 * Elimina un directorio.
	 * En caso de que el directorio no exista, lanza una Excepción.
	 * De lo contrario retorna true si se pudo eliminar.
	 * @param  string $dir
	 * @return bool
	 */
	public static function removeDir($dir) {
		if (!is_dir($dir)) {
			throw new \Exception($dir.' no es un directorio');
		}

		$files = array_diff(scandir($dir), array('.', '..'));
		foreach ($files as $file) {
			(is_dir($dir.'/'.$file)) ? self::removeDir($dir.'/'.$file) : unlink($dir.'/'.$file);
		}

		clearstatcache();
		return rmdir($dir);
	}

	/**
	 * removeFiles
	 * Recibe un array con el nombre de ficheros.
	 * En caso de que el fichero a eliminar no exista lanza una Excepción.
	 * @param  array $files
	 * @return bool
	 */
	public static function removeFiles(array $files) {
		foreach ($files as $file) {
			if (is_file((string) $file)) {
				if (file_exists((string) $file)) {
					unlink($file);
				} else {
					throw new \Exception('No existe el archivo de nombre '.$file);
				}
			} else {
					throw new \Exception($file.' no es un archivo.');
			}
		}
	}

	/**
	 * remove
	 * Elimina un fichero/directorio.
	 * Recibe un string con el nombre de un fichero/directorio.
	 * Lanza una Excepción si no existe dicho archivo/directorio.
	 * @param  string $entry
	 * @return bool
	 */
	public static function remove($entry) {
		if (file_exists($entry)) {
			return (is_dir($entry)) ? self::removeDir($entry) : self::removeFiles([$entry]);
		} else {
			throw new \Exception('No existe el fichero/directorio de nombre '.$entry);
		}
	}

	/**
	 * find
	 * Busca archivos dentro de un directorio, por extensión o
	 * que su nombre cumpla con una determinada expresión regular
	 * en caso de que el parámetro $regx sea TRUE.
	 *
	 * Los archivos se guardan en el array File::$resultado.
	 *
	 * @param string $directory
	 * @param string $entry
	 * @param bool $regx
	 */
	public static function find($directory, $entry, $regx) {
		if (!is_dir($directory)) {
			throw new \Exception('No existe el directorio de nombre '.$directory);
		}

		if (file_exists($directory)) {
			$dir = opendir($directory);
			while (false !== ($e = readdir($dir))) {
				if ($e != '.' && $e != '..') {
					if (is_file($directory.'/'.$e)) {
						// Comparo por extensión
						if (!$regx) {
							$ext = explode('.', $e);
							$ext = $ext[count($ext) - 1];
							// Si la extensión del archivo coinciden, guardo el archivo
							if ($ext == $entry) {
								array_push(self::$results, $directory.'/'.$e);
							}
						} else {
							// Comparo con la expresión regular
							if (preg_match($entry, $e)) {
								array_push(self::$results, $directory.'/'.$e);
							}
						}
					} else {
						self::find($directory.'/'.$e, $entry, $regx);
					}
				}
			}
			closedir($dir);
		} else {
			throw new \Exception('No existe el directorio de nombre '.$directory);
		}
	}
}
