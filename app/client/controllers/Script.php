<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 15.03.16
 * Time: 12:54
 */

namespace app\client\controllers;


use core\Controller;

class Script extends Controller
{
    public function index()
    {
        echo 'is script';
    }

    public function Get()
    {
        $name=md5($_SERVER['HTTP_REFERER']);
        $model = new \app\client\models\script();
        $data =$model->Get($name);
        $data = str_replace('{host}',HOST_NAME,$data);
        $data = str_replace('{name}',$name,$data);
        $this->response->js($data);
    }



}