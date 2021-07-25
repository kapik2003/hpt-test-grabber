<?php

declare(strict_types=1);

class Autoloader {

    /** @var array */
    private $map_files;

    /** @var Autoloader */
    private static $instance;

    private function __construct() {
        spl_autoload_register(null, false);
        spl_autoload_extensions(CLASS_EXT);
        spl_autoload_register([$this, 'loadSystem']);
        $this->map_files = [];

        $iterator = new RecursiveDirectoryIterator(SYSTEM_DIR);
        foreach (new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST) as $obj) {
            if ($obj->getBasename() != '.' && $obj->isFile()) {
                $parse = explode('.', $obj->getFilename());
                if (isset($parse[0])) {
                    $this->map_files[ucwords($parse[0])] = $obj->getPathName();
                }
            }
        }
    }

    public static function init() {
        if (!isset(self::$instance)) {
            $class_name = __CLASS__;
            self::$instance = new $class_name();
        }

        return self::$instance;
    }

    public function loadSystem(string $class_name) {
        $parse = explode('\\', $class_name);
        if (isset($parse[count($parse) - 1])) {
            $class_name = $parse[count($parse) - 1];

            if (isset($this->map_files[$class_name])) {
                if (is_file($this->map_files[$class_name])) {
                    require_once $this->map_files[$class_name];
                }
            }
        }
    }
}