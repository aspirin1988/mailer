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
            'user' => $UserId
        ];

        $this->db->insert('temp_user',$new_session);
        return $new_session;
    }
}