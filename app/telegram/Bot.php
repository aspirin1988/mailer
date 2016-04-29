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

    public function SendForwardMessage($token,$chat_id,$message)
    {
        $Peremenaya="https://api.telegram.org/bot{$token}/forwardMessage?chat_id={$chat_id}&from_chat_id={$message['chat']['id']}&message_id={$message['message_id']} ";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "{$Peremenaya}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        //$this->jsonSendMessage($token,$chat_id,$message);
    }

    public function SendMessage($token,$chat_id,$message,$command)
    {
        if ($command){
            $Peremenaya="https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&text={$command}{$message['id']}  {$message['text']}";

        }
        else
        {
            $replyMarkup = array(
                'keyboard' => [
                    ['7', '8', '9'],
                    ['4', '5', '6'],
                    ['1', '2', '3'],
                    ['0']
                ]
            );
            $encodedMarkup = json_encode($replyMarkup);
            $content = array(
                'chat_id' => 169105432,
                'reply_markup' => $encodedMarkup,
                'text' => "Test"
            );
            $replyMarkup=json_encode($replyMarkup);
            $Peremenaya="https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&text={$message['id']} {$message['text']}&reply_markup={$replyMarkup}";
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "{$Peremenaya}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
    }

    public function jsonSendMessage($token,$chat_id,$message)
    {
        $Peremenaya="https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&text=".json_encode($message);
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