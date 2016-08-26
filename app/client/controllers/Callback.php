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
        if (isset($_POST['_mute'])&&$_POST['_mute']==true){
            $mute=true;
        }
        else{
            $mute=false;
        }
        $rest=$_POST;  //= $this->request;
        unset($rest['_mute']);
        $model = new \app\client\models\callback();
        $rest['URL']=$_SERVER['HTTP_REFERER'];
        $this->response->json($model->SendForm($rest,$name,$mute));
    }

    public function SendFormTo($value,$name=false)
    {
        if(!$name) $name=$this->get_name();
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

    function GetLocation($ip)
    {
        header('Content-Type: text/html;charset=UTF-8');
        $url = "https://www.nic.ru/whois/?query=" . $ip;
        $data = @file_get_contents($url);
        $data = explode('</div>', $data);
        foreach ($data as $value) {
            $preData = explode('<div class="b-whois-info__info">', $value);
            if (count($preData) > 1) {
                $data = $preData[1];
                break;
            }
        }
        $data = str_replace('&nbsp;', '', $data);
        $data = explode('<br>', $data);
        foreach ($data as $key => $value) {
            //echo stristr($value,'%');
            if (stristr($value, '%')) {
                unset($data[$key]);
            }

        }

        $preData = [];
        $name = ['company', 'city', 'address', 'descr'];
        $direct = 0;
        foreach ($data as $key => $value) {
            if ($value) {
                $preData1 = explode(':', $value);
                if (count($preData1) > 1) {
                    $preData2 = $preData1[0];
                    if (stristr($preData2, 'descr')) {
                        $preData2 = $name[$direct];
                        $direct++;
                    }
                    unset($preData1[0]);
                    $preData[$preData2] = $preData1;
                } else {
                    //unset($preData1[0]);
                }
            }
        }
        $data = $preData;

        return json_encode($data);
    }

}