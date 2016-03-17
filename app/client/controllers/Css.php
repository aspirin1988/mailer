<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 17.03.16
 * Time: 14:23
 */

namespace app\client\controllers;


use core\Controller;

class Css extends Controller
{
    public function index()
    {
        echo 'is CSS';
    }

    public function Get($name,$style)
    {
        $user =$this->session->getUser();
        $model = new \app\client\models\css();
        $data =$model->Get($name,$style);
        $data = str_replace('{host}',HOST_NAME,$data);
        $this->response->css($data);
    }
}