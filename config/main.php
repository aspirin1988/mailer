<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 16.02.2016
 * Time: 13:28
 */


//PATH

define("DS", DIRECTORY_SEPARATOR);
define("BASE_PATH", dirname(dirname(__FILE__)));
define("CORE_PATH", BASE_PATH . DS . 'core');
define("LIBRARY", BASE_PATH . DS . 'library');
define("PUBLIC_PATH", BASE_PATH . DS . 'public');
define("CALLBACK", PUBLIC_PATH.DS.'resources'.DS.'callback');
define("LOG_PATH", BASE_PATH . DS . 'logs');
define("APP_PATH", BASE_PATH . DS . 'app');
define("TEMPLATE_PATH", BASE_PATH . DS . 'template');
define("TEMP_PATH", BASE_PATH . DS . '/temp');
define("HOST_NAME", $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME']);


//Route
define("DEFAULT_CONTROLLER", 'Main');
define("DEFAULT_ACTION", 'index');
define("DEFAULT_TEMPLATE", 'default');

define("PAGE_SIZE", 15);
define('DEFAULT_SESSION_LIFE_TIME', 300000);

//Template
define("TEMPLATE_HEADER_FILE", TEMPLATE_PATH . DS . DEFAULT_TEMPLATE . DS . 'header.php');
define("TEMPLATE_FOOTER_FILE", TEMPLATE_PATH . DS . DEFAULT_TEMPLATE . DS . 'footer.php');

// Ignore auth module
define("IGNORE_AUTH",['client'=>true]);

// DB config
/*define('DATABASE_TYPE', 'pgsql');
define('DATABASE_NAME', 'mailer');
define('DATABASE_SERVER', '127.0.0.1');
define('DATABASE_USERNAME', 'crm');
define('DATABASE_PASSWORD', 'crm_user');
define('DATABASE_CHARSET', 'utf8');*/

define('DATABASE_TYPE', 'pgsql');
define('DATABASE_NAME', 'blink');
define('DATABASE_SERVER', '127.0.0.1');
define('DATABASE_USERNAME', 'mailer');
define('DATABASE_PASSWORD', 'AJXrdBjnYqHt');
define('DATABASE_CHARSET', 'utf8');