<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 22.02.2016
 * Time: 17:05
 */

namespace app\helper\models;


use core\Models;

/**
 * Class Messager
 * @package app\helper\models
 */
class Messager extends Models
{
    /**
     * @return array
     */
    public function getMessagers()
    {
        $data = $this->db->select('massagers', '*');
        $result = [];
        foreach ($data as $value) {
            $result[$value['id']] = ['name' => $value['name'], 'icon' => $value['icon']];

        }
        return $result;
    }

    /**
     * @param $id
     * @return array|bool
     */
    public function getMessagerById($id)
    {
        return $this->db->select('massagers', '*', ['id' => $id]);
    }
}