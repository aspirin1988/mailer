<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 15.03.16
 * Time: 12:53
 */

namespace app\client\controllers;


use core\Controller;

class Template extends Controller
{
    public function Get($name,$style)
    {
        $model = new \app\client\models\template();
        //print_r($_SERVER);
        echo  $model->Get($name,$style);
    }

}