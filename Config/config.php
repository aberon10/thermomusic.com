<?php

namespace Config;

/**
 * Configuraciones de la aplicación.
 *
 * @author Alejandro Berón <alejandroberon10@gmail.com>
 * @license <https://opensource.org/licenses/GPL-3.0> GNU GPL versión 3
 * @version 1.0
 */

const PRODUCTION = false;

// Estableze la zona horaria
date_default_timezone_set('America/Montevideo');

// Formatos de fecha y hora,
setlocale(LC_TIME, 'es_ES.UTF-8');

// Codificación en el HTTP header:
header('Content-Type: text/html; charset=UTF-8');

/**
 * IMPORTANT!!!
 * Por defecto el despliegue de errores esta habilitado,
 * es recomendado utilizarlo solo en fases de 'Desarrollo' y 'Testing'.
 * Cambiar el valor de la constante PRODUCTION a `true` cuando la aplicación vaya a ser
 * desplegada en producción.
 */
if (!PRODUCTION) {
	ini_set('display_errors', '1');
	error_reporting(E_ALL);
} else {
	ini_set('display_errors', '0');
	ini_set('log_errors', true);
	ini_set('error_log', '/var/log/thermomusic.com_error_log.log');
}

// Especifico que el modulo usara cookies para almacenar el id de sesión.
ini_set('session.use_cookies', true);

// Especifico que el modulo usara SOLO cookies para almacenar el id de sesión en la parte del cliente.
ini_set('session.use_only_cookies', true);

/**
 * Marca la cookie como accesible sólo a través del protocolo HTTP.
 * Esto significa que la cookie no será accesible por lenguajes tales como JavaScript.
 */
ini_set('session.cookie_httponly', true);

// Manejo de Excepciones
/*set_exception_handler(function($exception) {
	error_log($exception, 0);
});
*/
