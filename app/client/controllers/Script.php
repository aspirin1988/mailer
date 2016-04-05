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
        $name=$this->get_name();
        $model = new \app\client\models\script();
        $data =$model->Get($name);
        $data = str_replace('{host}','https'.HOST_NAME,$data);
        $data = str_replace('{name}',$name,$data);

//        $this->response->json( $name );
        $this->response->js($data);
    }


 function get_name()
 {
     $name = explode('//',$_SERVER['HTTP_REFERER']);
     $name=explode('/',$name[1])[0];
     return md5($name);
 }

}