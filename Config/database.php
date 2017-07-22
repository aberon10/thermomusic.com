<?php

$config = parse_ini_file(PROJECT_PATH.'.db_config.ini');

define('DB_HOST', $config['db_host']);
define('DB_PORT', $config['db_port']);
define('DB_DATABASE', $config['db_database']);
define('DB_USER', $config['db_user']);
define('DB_PASSWORD', $config['db_password']);
define('DB_CHARSET', $config['db_charset']);