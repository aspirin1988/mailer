<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 23.02.2016
 * Time: 10:06
 */

namespace app\helper\models;


use core\Models;

/**
 * Class SiteType
 * @package app\helper\models
 */
class SiteType extends Models
{
    /**
     * @return array
     */
    public function getSiteType()
    {
        $data = $this->db->select('site_type','*',['ORDER'=>'site_type']);

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
    public function getSiteTypeId($id)
    {
        return $this->db->select('site_type','*',['id'=>$id]);
    }
}