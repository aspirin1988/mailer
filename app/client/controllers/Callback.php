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
        $this->GetLocation();
        $name=$this->get_name();
        $rest='';
        $rest['fullname']=$_POST['fullname'];  //= $this->request;
        $rest['phone'] = $_POST['phone'];  //= $this->request;
        $model = new \app\client\models\callback();
        $this->response->json($model->Recall($rest,$name));
    }

    public function Query()
    {
        $name=$this->get_name();
        $rest='';
        $rest['fullname']=$_POST['fullname'];  //= $this->request;
        $rest['phone'] = $_POST['phone'];  //= $this->request;
        $rest['email'] = $_POST['email'];  //= $this->request;
        $rest['mess'] = $_POST['mess'];  //= $this->request;
        $model = new \app\client\models\callback();
        $this->response->json($model->Query($rest,$name));

    }

    public function Chat()
    {
        $name=$this->get_name();
        $data=[
            'token'=>$_POST['token'],
            'text'=>$_POST['text'],
        ];

        $model = new \app\client\models\bot();
        $this->response->json($model->sendMessageSite($data,$name));
    }

    public function GetChat()
    {
        $name=$this->get_name();
        $data=[
            'token'=>$_POST['token'],
        ];

        $model = new \app\client\models\bot();
        $this->response->json($model->GetChatData($data,$name));
    }

    public function SendForm()
    {
        $name=$this->get_name();
        $rest='';
        $rest=$_POST;  //= $this->request;
        $model = new \app\client\models\callback();
        $rest['URL']=$_SERVER['HTTP_REFERER'];
        $this->response->json($model->SendForm($rest,$name));
    }

    public function SendFormTo($value)
    {
        $name=$this->get_name();
        $rest='';
        //$rest=$_POST;  //= $this->request;
        $rest=$value;
        $model = new \app\client\models\callback();
        return $model->SendFormTo($rest,$name);
    }

    function get_name()
    {
        $name = explode('//',$_SERVER['HTTP_REFERER']);
        $name=explode('/',$name[1])[0];
        return md5($name);
    }

    function GetLocation()
    {

        //$model = new \app\geolocation\models\IP2Location(BASE_PATH."/app/geolocation/model/databases/IP2LOCATION-LITE-DB1.BIN",\app\geolocation\models\IP2Location()::FILE_IO);

        //$db = new \IP2Location\IP2Location('./databases/IP2LOCATION-LITE-DB1.BIN', \IP2Location\IP2Location::FILE_IO);

        //$records = $model->lookup('8.8.8.8', $model::ALL);

        //print_r($records);

    }

}