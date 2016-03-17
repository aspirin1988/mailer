<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 16.02.2016
 * Time: 15:23
 */

namespace core;


use YASF;

/**
 * Class Router
 * @package core
 */
class Router
{
    private $folder;
    private $controller;
    private $action;
    private $params = [];

    /**
     * Запуск
     */
    public function run()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        $route = explode('/', $url);

        /** @var Response $response */
        $response = YASF::$app->get('Response');
        /** @var Session $session */
        $session = YASF::$app->get('Session');

        //Список роутов пока добавляется в ручную!!!
        $permissions = [
            'programmer',
            'auth',
            'designer',
            'callcenter',
            'helper',
            'site',
            'client',
        ];


        if (!$session->User() && $route[0] != 'auth' && $route[0] != 'client') {
            $response->redirect('/auth');
            exit;
        }



        if (isset($route[0]) && !empty($route[0])) {
            $this->folder = $route[0];

            if (in_array($this->folder,$permissions)) {
                $this->controller = isset($route[1]) ? $route[1] : DEFAULT_CONTROLLER;
                $this->action = isset($route[2]) ? $route[2] : DEFAULT_ACTION;
                $this->params = isset($route[3]) ? array_slice($route, 3) : [];

                $controller = '\app\\' . $this->folder . '\controllers\\' . ucfirst(strtolower($this->controller));

                if (class_exists($controller)) {
                    $object = new $controller();
                    if (method_exists($object, $this->action)) {
                        call_user_func_array([$object, $this->action], $this->params);
                    } else {
                        YASF::$app->get('Response')->notFound();
                    }
                } else {
                    YASF::$app->get('Response')->notFound();
                }
            } else {
                $response->notFound();
                exit;
            }
        } else {
            $url = $session->User('template');
            $response->redirect($url);
            exit;
        }
    }

    public function getFolder()
    {
        return $this->folder;
    }
}