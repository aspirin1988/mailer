<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 15.03.16
 * Time: 12:55
 */

namespace app\client\models;


use core\Models;

class callback extends Models
{
    public function Recall ($rest)
    {
        $str = file_get_contents(LIBRARY.DS.'registration.php');
        $path=BASE_PATH.DS.'app'.DS.'client'.DS.'models'.DS.'send.php';
        include_once ($path);
        $to = 'aspirins24@gmail.com';
        $subject = 'qqq';
        $message = 'Привет';
        // Заголовки сообщения, в них определяется кодировка сообщения, поля From, To и т.д.
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=windows-1251\r\n";
        $headers .= "To: $to\r\n";
        $headers .= "From: Имя отправителя <aspirin_1988@mail.ru>";

        // mail ($to, $subject, $message, $headers);

        MailSmtp($to, $subject, $message, $headers);





       // print_r(send_smtp_html($str,[],['aspirin_1988@mail.ru'],'qqqq',['Email'=>'system@jpplayer.su']));
        //return $rest['md5'];
    }

    public function Query ($rest)
    {

        return $rest['md5'];
    }



}