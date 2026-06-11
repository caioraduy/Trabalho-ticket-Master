<?php

    define('ROOT', dirname(__DIR__));

    spl_autoload_register(function (string $class){
        $path = ROOT . '/'. str_replace(['App\\', '\\'], ['app/', '/'], $class) . '.php';
        if  (file_exists($path)){
            require_once $path;
        }
    });
?>