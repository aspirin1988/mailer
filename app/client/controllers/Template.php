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
        $name=$this->get_name();
        $model = new \app\client\models\template();
        //print_r($_SERVER);
        header('Access-Control-Allow-Origin: *');
        $this->response->html($model->Get($name,$style));
    }

    function get_name()
    {
        $name = explode('//',$_SERVER['HTTP_REFERER']);
        $name=explode('/',$name[1])[0];
        return md5($name);
    }

}