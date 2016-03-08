<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 16.02.2016
 * Time: 13:38
 */
error_reporting(E_ALL);

if (version_compare(phpversion(), '5.5.0', '<') == true) {
    exit('PHP5.5+ Required');
}

if (!ini_get('date.timezone')) {
    date_default_timezone_set('UTC');
}

function autoload($className){
    $file = BASE_PATH . DS . str_replace('\\', '/', $className) . '.php';

    if (is_file($file)) {
        require $file;
        return true;
    } else {
        return false;
    }
}


spl_autoload_register('autoload');
spl_autoload_extensions('.php');