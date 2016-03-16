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
        print_r(send_smtp_html($str,[],['aspirin_1988@mail.ru'],'qqqq',['Email'=>'system@jpplayer.su']));
        //return $rest['md5'];
    }

    public function Query ($rest)
    {

        return $rest['md5'];
    }



}