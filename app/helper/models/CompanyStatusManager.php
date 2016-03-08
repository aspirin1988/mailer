<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 23.02.2016
 * Time: 9:43
 */

namespace app\helper\models;


use core\Models;

/**
 * Class Companystatusmanager
 * @package app\helper\models
 */
class Companystatusmanager extends Models
{

    /**
     * @return array
     */
    public function getStatusManager()
    {
        $data = $this->db->select('status_type', ['id', 'name'], ['ORDER' => 'name']);

        $result = [];
        foreach ($data as $item) {
            $result[$item['id']] = $item;
        }

        return [
            'data' => $result
        ];
    }

    /**
     * @return array
     */
    public function getStatusClient()
    {
        $data = $this->db->select('status_type', ['id', 'name'], ['group' =>'client', 'ORDER' => 'name']);

        $result = [];
        foreach ($data as $item) {
            $result[$item['id']] = $item;
        }

        return [
            'data' => $result
        ];
    }

    /**
     * @return array
     */
    public function getStatusProject()
    {
        $data = $this->db->select('status_type', ['id', 'name'], ['group' =>'project', 'ORDER' => 'name']);

        $result = [];
        foreach ($data as $item) {
            $result[$item['id']] = $item;
        }

        return [
            'data' => $result
        ];
    }

    /**
     * @param $id
     * @return array|bool
     */
    public function getStatusById($id)
    {
        return $this->db->select('status_type','*',['id'=>$id]);
    }
}