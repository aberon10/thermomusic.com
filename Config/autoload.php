<?php

/**
 * autoload_classes 
 * Carga los ficheros que guardan las clases.
 * @param string class_name
 */
function autoload_classes($class_name) {
    $filename = PROJECT_PATH.str_replace('\\', '/', $class_name).'.php';
    if (file_exists($filename)) {
        require_once $filename;
    }
}
