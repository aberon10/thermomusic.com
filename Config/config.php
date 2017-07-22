<?php

/**
 * Configuraciones de la aplicación.
 *
 * @author Alejandro Beron <alejandroberon10@gmail.com>
 * @version 1.0
 */

// Namespace donde se guardan los controladores de la aplicación
const NAMESPACE_CONTROLLERS = '\App\Controllers\\';

// Estableze la zona horaria
date_default_timezone_set('America/Montevideo');

// Formatos de fecha y hora,
setlocale(LC_TIME, 'es_ES.UTF-8');

// Codificación en el HTTP header:
header('Content-Type: text/html; charset=UTF-8');

/**
 * IMPORTANT!!!
 * 
 * Por defecto el despliegue de errores esta habilitado,
 * es recomendado utilizarlo solo en fases de 'Desarrollo' y 'Testing'.
 * Cambiar el valor de display_errors y error_reporting a 0 en fase de 'Producción'.
 */
// Notificacion de errores y logs
//ini_set('log_errors', true);

//ini_set('error_log', '/var/log/error_log.log');

ini_set('display_errors', '1');

error_reporting(E_ALL | E_STRICT);

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