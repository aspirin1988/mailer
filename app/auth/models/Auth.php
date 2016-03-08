<?php
/**
 * Created by PhpStorm.
 * User: dobro
 * Date: 22.02.16
 * Time: 16:13
 */

namespace app\auth\models;

use core\Models;

class Auth extends Models
{
    protected $user = [];


    public function verify($login, $password){
        $this->user = $this->db->get('users','*',['login_crm'=>$login]);
        if($this->user){
            $this->user['auth'] = true;
            $this->getUserLanguage($this->user['language']);
            return password_verify($password,$this->user['password_crm']) ? 1 : 0;
        }else{
            return -1;
        }

    }

    public function getPermissions($id){
        return($this->db->get('post_categorias','*',['id'=>$id]));
    }

    public function setUserPermission($user, $permissions){
        $user['permission'] = json_decode($user['permission'],true);
        $user['permission'] = $permissions;
        $user['is_admin'] = $user['access'] >= 999 ? true : false;

        $this->user = $user;
        return $user;
    }

    public function getUserLanguage($id)
    {
        $lang = $this->db->get('language','*',['id'=>$id]);
        if($lang){
            $this->user['language'] = $lang;
        }else{
            $this->user['language'] =  [
                                        'path'=>'russian',
                                        'name'=>'russian',
                                        'code'=>'ruz',
                                        'id'=>1
                                        ];
        }


    }

    public function getUserBy($find){
        return($this->db->get('users','*',$find));
    }


    /**
     * @param mixed $key
     * @return array
     */
    public function getUser($key = false)
    {
        return $key ? (isset($this->user[$key]) ? $this->user[$key] : false) : $this->user;
    }

    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function setUser($key,$value)
    {
        $this->user[$key] = $value;
    }


    protected function cleanUser(){

        return true;
    }


}