<?php

namespace Core;

class View
{
    /**
     * @var array $data - Datos que serán pasados a la vista.
     */
    protected static $data = null;

    /**
     * @var string EXTENSION_TEMPLATES - Extensión de los archivos que guardan las vistas.
     */
    const EXTENSION_TEMPLATES = 'php';

    /**
     * set 
     * @param string $name  - key
     * @param mixed  $value - value
     */
    public static function setData($name, $value) {
        self::$data[$name] = $value;
    }

    /**
     * render
     * @param string - template name
     */
    public static function render($template) {
        $src = VIEWS_PATH.$template.'.'.self::EXTENSION_TEMPLATES;
        if (!file_exists($src)) {
            throw new \Exception('Error: El archivo '.$src.' no existe', 1);
        }

        if (!is_null(self::$data)) {
            extract(self::$data);
        }
        require $src;
    }
}
