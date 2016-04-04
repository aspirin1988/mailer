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
        $name='';
        //print_r($_SERVER);
        if ($_SERVER['HTTP_REFERER'])
        {
            $name=md5($_SERVER['HTTP_REFERER']);
        }
        else
        {
            $name=md5($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/');
        }
        //$name=md5($name);
        $model = new \app\client\models\script();
        $data =$model->Get($name);
        $data = str_replace('{host}','http'.HOST_NAME,$data);
        $data = str_replace('{name}',$name,$data);
        $this->response->js($data);
    }



}