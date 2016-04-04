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
        $user =$this->session->getUser();
        $model = new \app\client\models\css();
        $data =$model->Get($name,$style);
        $data = str_replace('{host}','http'.HOST_NAME,$data);
        $this->response->css($data);
    }
}