<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 28.04.16
 * Time: 15:21
 */

namespace app\client\controllers;


use core\Controller;

class Bot extends Controller
{
    public function sendMessage()
    {
        $rest=$this->rest();
        $model = new \app\client\models\bot();
        $model->sendMessage($rest);
        $this->response->json($rest);
    }

    public function getMessage()
    {
        $name=$this->get_name();
        $rest=$this->request->rest();
        $model = new \app\client\models\bot();
        $this->response->json($model->getMessage($rest,$name));
    }

    public function sendMessageSite()
    {
        $name=$this->get_name();
        $data=[
            'token'=>$_POST['token'],
            'text'=>$_POST['text'],
        ];

        $model = new \app\client\models\bot();
        $this->response->json($model->sendMessageSite($data,$name));
    }



    //--Спец-функции--//
    function get_name()
    {
        $name = explode('//',$_SERVER['HTTP_REFERER']);
        $name=explode('/',$name[1])[0];
        return $name;
    }

    function rest()
    {
        return json_decode(file_get_contents('php://input'),true);
    }
}

