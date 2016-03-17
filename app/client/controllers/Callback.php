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

    public function Recall()
    {
        $rest['md5'] = '966128519f610498a7df19b1aa045b6f';  //= $this->request;
        $rest['name'] = 'name_val';  //= $this->request;
        $rest['phone'] = 'phone_val';  //= $this->request;
        $rest['email'] = 'email_val';  //= $this->request;
        $model = new \app\client\models\callback();
        $this->response->json($model->Recall($rest));
    }
    public function Query()
    {
        $rest = $this->request;
        $model = new \app\client\models\callback();
        $this->response->json($model->Query($rest));
    }
}