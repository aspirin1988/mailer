<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 28.04.16
 * Time: 15:25
 */

namespace app\telegram;


class MessageBot
{
    var $token = '220112300:AAFhjlexf0E9t2wh5x-C1EgdNvs-vdyKr9M';

    public function SendForwardMessage($chat_id,$message)
    {
        $Peremenaya="https://api.telegram.org/bot{$this->token}/forwardMessage?chat_id={$chat_id}&from_chat_id={$message['chat']['id']}&message_id={$message['message_id']} ";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "{$Peremenaya}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
    }

    public function SendMessage1($chat_id,$message)
    {
        $Peremenaya="https://api.telegram.org/bot{$this->token}/sendMessage?chat_id={$chat_id}&text={$message['text']}";
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

    public function jsonSendMessage($chat_id,$message)
    {
        $Peremenaya="https://api.telegram.org/bot{$this->token}/sendMessage?chat_id={$chat_id}&text=".json_encode($message);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "{$Peremenaya}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
    }

    public function SendMessage($chat_id=-149637232,$message,$keyboard=false)
    {
        $url = "https://api.telegram.org/bot{$this->token}/sendMessage";
        $content = array(
            'chat_id' => $chat_id,
            'text' => $message['text'],
            'parse_mode' => 'html',
        );
        if ($keyboard){
            $replyMarkup = [
                'inline_keyboard' => array(array(array('text' => 'Обработано', 'callback_data' => 'approve=true'),array('text' => 'Отказ', 'callback_data' => 'approve=false'))),
                //'keyboard' => $keyboard,
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
        $return=curl_exec ($ch);
        curl_close ($ch);
        return json_decode($return,true);
    }

    public function EditMessage($chat_id,$message_id,$message,$add_text){
        $url = "https://api.telegram.org/bot{$this->token}/editMessageText";
        $content = array(
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => $message.'
            '.$add_text,
            'parse_mode' => 'html',
        );
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($content));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  //fix http://unitstep.net/blog/2009/05/05/using-curl-in-php-to-access-https-ssltls-protected-sites/
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $return=curl_exec ($ch);
        curl_close ($ch);
        return json_decode($return,true);
    }

}