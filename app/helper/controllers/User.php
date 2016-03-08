<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 23.02.2016
 * Time: 10:20
 */

namespace app\helper\controllers;


use core\Controller;

/**
 * Class User
 * @package app\helper\controllers
 */
class User extends Controller
{
    /**
     * @var \app\helper\models\User|null
     */
    private $model = null;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->model = new \app\helper\models\User();
    }

    /**
     * Получить инфу о пользователье
     * @param $id
     */
    public function getUser()
    {
        $userId = $this->session->User('id');
        $this->response->json($this->model->getUserById($userId));
    }
}