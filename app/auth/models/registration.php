<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 16.04.16
 * Time: 9:55
 */

namespace app\auth\models;


use core\Models;

class registration extends Models
{
    function Reg($name,$login,$email)
    {
        $mail_res=[];
        $mail= new \app\client\controllers\Callback();
        $new_user['first_name']= $name;
        $new_user['login_crm']= $login;
        $new_user['password_crm']=password_hash(123456,PASSWORD_DEFAULT);
        $str=$name.$new_user['password_crm'];
        $new_user['activation_string']=md5($str).time();
        $new_user['email']=json_encode([$email]);
        $this->db->insert('users',$new_user);
            $value['name'] = $name;
            $value['login'] = $login;
            $value['email'] = $email;
            $value['url'] = 'https' . HOST_NAME . '/auth/registration/confirm/' . $new_user['activation_string'];
            $mail_res=$mail->SendFormTo($value);
        return ['mail'=>$mail_res];
    }

    function Confirm($act_string,$ps1,$ps2)
    {
        $result=[];
        if (isset($ps1)&&isset($ps2)&&($ps1==$ps2)){
            $result = $this->db->update('users',
                [
                    'password_crm'=>password_hash($ps1,PASSWORD_DEFAULT),
                ],
                [
                    'users.activation_string' => $act_string
                ]
            );
        }
        else {
            $result = $this->db->select('users',
                [
                    'users.id', 'users.first_name', 'users.last_name'
                ],
                [
                    'users.activation_string' => $act_string
                ]
            );
            if (!$result) {
                $result = ['error' => 1, 'message' => 'invalid activation string'];
            }
        }
    return $result;
    }
}