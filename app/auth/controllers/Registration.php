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

    public function Reg($name,$login,$email)
    {
        $model = new \app\auth\models\registration();
        $this->response->json($model->Reg($name,$login,$email));

    }
    public function Confirm($act_string,$ps1,$ps2)
    {
        $model = new \app\auth\models\registration();
        $this->response->json($model->Confirm($act_string,$ps1,$ps2));

    }

}