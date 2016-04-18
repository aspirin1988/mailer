<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 16.04.16
 * Time: 9:54
 */

namespace app\auth\controllers;


use core\Controller;

class Registration extends Controller
{

    public function Reg($email)
    {
        $model = new \app\auth\models\registration();
        $this->response->json($model->Reg($email));

    }
    public function Confirm()
    {
        $model = new \app\auth\models\registration();
        $value=$this->request->rest();
        $this->response->json($model->Confirm($value));

    }

}