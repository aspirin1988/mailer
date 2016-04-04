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
    public function index()
    {
        echo 'is template';
    }

    public function Get($style)
    {
        $name='';
        if ($_SERVER['HTTP_REFERER'])
        {
            $name=md5($_SERVER['HTTP_REFERER']);
        }
        else
        {
            $name=md5($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/');
        }
        $model = new \app\client\models\template();
        //print_r($_SERVER);
        header('Access-Control-Allow-Origin: *');
        $this->response->html($model->Get($name,$style));
    }

}