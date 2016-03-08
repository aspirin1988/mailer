<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 22.02.2016
 * Time: 17:18
 */

namespace app\helper\models;


use core\Models;

/**
 * Class Education
 * @package app\helper\models
 */
class Education extends Models
{
    /**
     * @return array
     */
    public function getEducation()
    {
        $list = $this->db->select('level_education', '*');

        $result = [];

        foreach ($list as $item) {
            $result[$item['id']] = $item;
        }

        return [
            'data' => $result
        ];

    }

    /**
     * @param $val
     * @return array|bool
     */
    public function selectEducation($val)
    {
        $item = $this->db->select('level_education', '*', ['id' => $val]);

        return $item;
    }
}