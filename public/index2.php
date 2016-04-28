<?php



function SendMessage($token,$chat_id,$message)
{
    //$Peremenaya = "https://api.telegram.org/bot{$token}/sendMessage?disable_web_page_preview=true&chat_id={$chat_id}&text=Сообщение от:@".$message['from']['username']." ".$message['text'];
    $Peremenaya="https://api.telegram.org/bot{$token}/forwardMessage?chat_id={$chat_id}&from_chat_id={$message['chat']['id']}&message_id={$message['message_id']}";
    file_put_contents('css/cache/text.txt',$Peremenaya);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "{$Peremenaya}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    curl_close($ch);
}

function getLastMessage($token)
{
    $Peremenaya = "https://api.telegram.org/bot{$token}/getUpdates";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$Peremenaya");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $message=curl_exec($ch);
    $message=json_decode($message,true);
    $chat_id=$message['result'][count($message['result'])-1]['message']['chat']['id'];
    $message=$message['result'][count($message['result'])-1]['message'];
    curl_close($ch);
    return $message;
}

function forward($message)
{
    /*$message=json_encode($message);
    if( $curl = curl_init() ) {
        curl_setopt($curl, CURLOPT_URL, 'https://callback.blink.kz/client/Main/bot');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, "{$message}");
        $out = curl_exec($curl);
        echo $out;
        curl_close($curl);
    }*/


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "callback.blink.kz/client/main/bot");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    curl_close($ch);
}

function bot()
{

    $sss='';
    $token='146927044:AAHz2gw_UGcJdzdb4Eh-NoW2PMhYS7oBbrU';
    $chat_id=-149637232;
    $sss=file_get_contents('php://input');

    $sss=json_decode($sss,true);
    //file_put_contents('text.txt', print_r($sss,true));
    SendMessage($token,$chat_id,$sss['message']);
    forward($sss);

}

bot();
