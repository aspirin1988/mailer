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
        $name=$this->get_name();
        $user =$this->session->getUser();
        $model = new \app\client\models\css();
        $data =$model->Get($name,$style);
        $data = str_replace('{host}','https'.HOST_NAME,$data);
        $this->response->css($data);
    }

    function get_name()
    {
        $name = explode('//',$_SERVER['HTTP_REFERER']);
        $name=explode('/',$name[1])[0];
        return md5($name);
    }
}