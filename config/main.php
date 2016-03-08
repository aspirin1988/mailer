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
define("PUBLIC_PATH", BASE_PATH . DS . 'public');
define("LOG_PATH", BASE_PATH . DS . 'logs');
define("APP_PATH", BASE_PATH . DS . 'app');
define("TEMPLATE_PATH", BASE_PATH . DS . 'template');
define("TEMP_PATH", BASE_PATH . DS . '/temp');

//Route
define("DEFAULT_CONTROLLER", 'Main');
define("DEFAULT_ACTION", 'index');
define("DEFAULT_TEMPLATE", 'default');

define("PAGE_SIZE", 15);
define('DEFAULT_SESSION_LIFE_TIME', 300000);

//Template
define("TEMPLATE_HEADER_FILE", TEMPLATE_PATH . DS . DEFAULT_TEMPLATE . DS . 'header.php');
define("TEMPLATE_FOOTER_FILE", TEMPLATE_PATH . DS . DEFAULT_TEMPLATE . DS . 'footer.php');

// DB config
define('DATABASE_TYPE', 'pgsql');
define('DATABASE_NAME', 'mailer');
define('DATABASE_SERVER', '127.0.0.1');
define('DATABASE_USERNAME', 'crm');
define('DATABASE_PASSWORD', 'crm_user');
define('DATABASE_CHARSET', 'utf8');