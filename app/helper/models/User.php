<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 23.02.2016
 * Time: 10:16
 */

namespace app\helper\models;


use core\Models;

/**
 * Class User
 * @package app\helper\models
 */
class User extends Models
{
    /**
     * @param $id
     * @return array|bool
     */
    public function getUserById($id)
    {
        return $this->db->select('users','*',['id'=>$id,"ORDER"=>'last_name']);
    }
}