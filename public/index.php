<?php

define('PROJECT_PATH', dirname(__DIR__).'/');
define('APP_PATH', PROJECT_PATH . 'App/');
define('VIEWS_PATH', PROJECT_PATH.'resources/views/');
define('CONTROLLERS_PATH', APP_PATH.'Controllers/');

// Ficheros necesarios para el inicio de la app
require PROJECT_PATH.'/Config/config.php';
require PROJECT_PATH.'/Config/config_app.php';

$loader = require PROJECT_PATH . '/vendor/autoload.php';
$loader->addPsr4('App\\', PROJECT_PATH.'App');
$loader->addPsr4('Config\\', PROJECT_PATH.'Config');
$loader->addPsr4('Core\\', PROJECT_PATH.'Core');

$dotenv = new \Dotenv\Dotenv(PROJECT_PATH);
$dotenv->load();

Core\App::init();