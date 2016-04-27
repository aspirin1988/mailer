<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 16.02.2016
 * Time: 13:27
 */
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Origin: *');
include('../config/main.php');
include (BASE_PATH.DS.'bootstrap.php');

$container = new \core\Container();

$ignore=IGNORE_AUTH;

$database = new \core\Database([
    'database_type' => DATABASE_TYPE,
    'database_name' => DATABASE_NAME,
    'server' => DATABASE_SERVER,
    'username' => DATABASE_USERNAME,
    'password' => DATABASE_PASSWORD,
    'charset' => DATABASE_CHARSET,
]);


$container->set('Database',$database);
$container->set('Request',new \core\Request());
$container->set('Response',new \core\Response());
$container->set('Session',new \core\Session());
$container->set('Log',new \core\Log());
$container->set('Router',new \core\Router());

YASF::$app = $container;

/** @var \core\Router $router */
$router = YASF::$app->get('Router');

/** @var \core\Session $session */
$session = YASF::$app->get('Session');
$session ->start();

$router->run();