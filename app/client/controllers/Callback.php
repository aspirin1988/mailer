<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 15.03.16
 * Time: 17:42
 */

namespace app\client\controllers;


use core\Controller;

class Callback extends Controller
{
    public function index()
    {
        echo 'is Callback';
    }

    public function Recall($name)
    {

        $rest['fullname']=$_POST['fullname'];  //= $this->request;
        $rest['phone'] = $_POST['phone'];  //= $this->request;
        $model = new \app\client\models\callback();
        $this->response->json($model->Recall($rest,$name));
    }
    public function Query($name)
    {
        $rest['fullname']=$_POST['fullname'];  //= $this->request;
        $rest['phone'] = $_POST['phone'];  //= $this->request;
        $rest['email'] = $_POST['email'];  //= $this->request;
        $rest['messange'] = $_POST['messange'];  //= $this->request;
        $model = new \app\client\models\callback();
        $this->response->json($model->Query($rest,$name));
    }
}