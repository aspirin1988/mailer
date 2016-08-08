<?php
/**
 * Created by PhpStorm.
 * User: dobro
 * Date: 08.08.16
 * Time: 14:03
 */

namespace app\api\models;


use core\Models;

class Api extends Models
{

    public  function openSession($UserId) {
        $token = bin2hex(openssl_random_pseudo_bytes(128));
        $new_session = [
            'token' => $token,
            'user' => $UserId,
            'time_stamp' => time(),
            'last_update' =>  time(),
            'client' =>  ['REMOTE_ADDR'=>$_SERVER['REMOTE_ADDR'],'HTTP_USER_AGENT'=>$_SERVER['HTTP_USER_AGENT']]
        ];

        $this->db->insert('api_sessions',$new_session);
        return $new_session;
    }
}