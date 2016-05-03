<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 26.04.16
 * Time: 18:09
 */

namespace app\client\controllers;


use core\Controller;

class Main extends Controller
{

    public function bot()
    {
        //$f_name=PUBLIC_PATH.'/css/cache/text.txt';
        //file_put_contents($f_name,print_r($_POST,true));
        $token='146927044:AAHz2gw_UGcJdzdb4Eh-NoW2PMhYS7oBbrU';
        //$last=$this->getLastMessage($token);
        //echo json_encode($last);
        $this->SendMessage($token,169105432,'blabalbal');

    }

    public function SendMessage($token,$chat_id,$message)
    {
        $Peremenaya = "https://api.telegram.org/bot{$token}/sendMessage?disable_web_page_preview=true&chat_id={$chat_id}&text=Сообщение от:@".$message['from']['username']." ".$message['text'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$Peremenaya");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
    }

    public function getLastMessage($token)
    {
        $Peremenaya = "https://api.telegram.org/bot{$token}/getUpdates";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$Peremenaya");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $message=curl_exec($ch);
        $message=json_decode($message,true);
        $chat_id=$message['result'][count($message['result'])-1]['message']['chat']['id'];
        $message=$message['result'][count($message['result'])-1]['message'];
        curl_close($ch);
        return $message;
    }

}