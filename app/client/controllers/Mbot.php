<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 27.06.16
 * Time: 15:02
 */

namespace app\client\controllers;


use core\Controller;

class Mbot extends Controller
{
    public function index(){
        echo 'this is MessageBot ';
    }

    public function sendMessage()
    {
        $rest=$this->rest();
        $model = new \app\client\models\messagebot();
        $model->sendMessage($rest);
        $this->response->json($rest);
    }

    function rest()
    {
        return json_decode(file_get_contents('php://input'),true);
    }
}