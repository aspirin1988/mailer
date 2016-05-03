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

    public function SendMessage1($token,$chat_id,$message)
    {


            /*$replyMarkup = array(
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
            $Peremenaya="https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&text={$message['id']} {$message['text']}&reply_markup={$replyMarkup}";*/
        $Peremenaya="https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&text={$message['text']}";
        file_put_contents(PUBLIC_PATH.'/css/cache/text.txt',$Peremenaya);
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

    public function SendMessage($token,$chat_id=-149637232,$message,$keyboard=false)
    {
        $url = "https://api.telegram.org/bot{$token}/sendMessage";
        $content = array(
            'chat_id' => $chat_id,
            'text' => $message['text']
        );
        if ($keyboard){
            $replyMarkup = ['keyboard' => $keyboard,
                'resize_keyboard'=>true,
                'selective'=>true,
            ];
            $encodedMarkup = json_encode($replyMarkup);
            $content['reply_markup'] = $encodedMarkup;}
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($content));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  //fix http://unitstep.net/blog/2009/05/05/using-curl-in-php-to-access-https-ssltls-protected-sites/
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec ($ch);
        curl_close ($ch);
    }

}