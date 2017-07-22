<?php

// Ruta raiz del proyecto
define('PROJECT_PATH', dirname(__DIR__).'/');

// Directorio App
define('APP_PATH', PROJECT_PATH . 'App/');

// Directorio de Vistas
define('VIEWS_PATH', PROJECT_PATH.'resources/views/');

// Directorio de Controladores
define('CONTROLLERS_PATH', APP_PATH.'Controllers/');

// Ficheros necesarios para el inicio de la app
require_once PROJECT_PATH.'/Config/config.php';
require_once PROJECT_PATH.'/Config/config_app.php';
require_once PROJECT_PATH.'/Config/autoload.php';
require_once PROJECT_PATH.'/Config/database.php';
require_once PROJECT_PATH.'/Core/App.php';

spl_autoload_register('autoload_classes');

Core\App::init();