<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 28.04.16
 * Time: 15:25
 */

namespace app\telegram;


class Bot
{

    public function SendMessage($token,$chat_id,$message)
    {
        $Peremenaya="https://api.telegram.org/bot{$token}/forwardMessage?chat_id={$chat_id}&from_chat_id={$message['chat']['id']}&message_id={$message['message_id']}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "{$Peremenaya}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
    }

}