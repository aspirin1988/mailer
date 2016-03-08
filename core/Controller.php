<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 17.02.2016
 * Time: 14:52
 */

namespace core;


abstract class Controller
{

    /**
     * @var Session $session
     */
    protected $session;

    /**
     * @var Response $response
     */
    protected $response;
    /**
     * @var Request $request
     */
    protected $request;
    /**
     * @var Router $router
     */
    protected $router;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->response = \YASF::$app->get('Response');
        $this->request = \YASF::$app->get('Request');
        $this->router = \YASF::$app->get('Router');
        $this->session = \YASF::$app->get('Session');
    }

    /**
     * @param $path
     * @param array $data
     */
    public function render($path, $data = [])
    {
        $module = $this->router->getFolder();
        $path = 'public' . DS . 'resources' . DS . $module . DS . $path;
        $this->response->render($path, $data);
    }


    protected function getLang()
    {
        $path = APP_PATH . DS . $this->router->getFolder() . DS . 'language' . DS .'russian'.'.php';
        $lang = null;
        if (is_file($path)) {
            $lang = require($path);
        }
        return $lang;
    }
}