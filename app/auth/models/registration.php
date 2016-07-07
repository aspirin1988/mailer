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
    function Reg($email)
    {
        $mail_res=[];
        $mail= new \app\client\controllers\Callback();
//        $new_user['first_name']= $name;
//        $new_user['login_crm']= $login;
//        $new_user['password_crm']=password_hash(123456,PASSWORD_DEFAULT);
//        $str=$name.$new_user['password_crm'];
//        $new_user['activation_string']=md5($str).time();
//
//            $value['name'] = $name;
//            $value['login'] = $login;
        $value['email'] = $email;
        $value['url'] = mt_rand(10000, 99999);
        $new_user['email']=$email;
        $new_user['code']=$value['url'];
        $this->db->insert('temp_user',$new_user);
        $mail_res=$mail->SendFormTo($value,'MainServer');
        return ['mail'=>$mail_res];
    }

    function Confirm($value)
    {

        $result=[];
        if ($this->db->count('temp_user',['temp_user.id'],['temp_user.code'=>$value['confirmCode']])) {
            $this->db->delete('temp_user',['temp_user.code'=>$value['confirmCode']]);
            $val['first_name']=$value['data']['first_name'];
            $val['login_crm']=$value['data']['email'];
            $val['email']=json_encode([$value['data']['email']]);
            $val['password_crm']=password_hash($value['data']['password'], PASSWORD_DEFAULT);
            $this->db->insert('users',$val);
            return true;
            }
        else
        {
            return false;
        }
    }
}