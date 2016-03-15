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
        $model = new \app\client\models\callback();
        echo $model->Recall();
    }
    public function Query()
    {
        $model = new \app\client\models\callback();
        echo $model->Query();
    }
}