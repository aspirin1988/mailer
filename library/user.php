<?php
/**
 * Created by PhpStorm.
 * User: dobro
 * Date: 16.02.16
 * Time: 15:49
 */

namespace library;
use  \core;

class user
{

public $_user;

    function __construct()
    {
       $this->_user = array(
        "auth"=>false,
        "access_level"=>0,
        "boss"=>0,
        "document_number"=>0,
        "email"=>'anonymous@mailer.com',
        "first_name"=>'anonymous',
        "id"=>-1,
        "issue_date"=>'00-00-00',
        "language"=>[
            'path'=>'russian',
            'name'=>'russian',
            'code'=>'ru',
            'id'=>0
        ],
        "login_crm"=>'',
        "middle_name"=>'anonymous',
        "name"=>'anonymous',
        "photo"=>'images/users/darth-vader.jpg',
        'ip' => $_SERVER['REMOTE_ADDR'],
        'debug'=>'',
        'is_admin'=>false
    );
        $this->start();
    }

    /**
     * записывает значение в массив юзера
     * @param $key
     * @param $value
     */
    public function get($key, $value){
        $this->_user[] = $value;
    }

    /**
     * получает значение из массива user
     * @param $key
     * @return bool
     */
    public function set($key){
        return isset($this->_user[$key]) ? $this->_user[$key] : false;
    }

    public function validate(){
        $valid = true;

        //валидация


        return $valid;
    }

    /**
     *
     */
    private function start(){
        $session = \YASF::$app->get('Session');
        $this->_user = $session->get('user');

        return true;
    }



}