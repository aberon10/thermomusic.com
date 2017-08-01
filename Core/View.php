<?php

namespace Core;

class View
{
    /**
     * @var array $data
     */
    protected static $data = null;

    /**
     * @var string EXTENSION_TEMPLATES
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
     * @param string - template
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
