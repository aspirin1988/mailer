<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 22.02.2016
 * Time: 16:33
 */

namespace app\helper\models;


use core\Models;

class Location extends Models
{
    /**
     * @return array
     */
    public function getCountry()
    {
        $countryList = $this->db->select('location', '*', [
            'parent' => 0
        ]);

        $result = [];

        foreach ($countryList as $value) {
            $result[$value['id']] = $value;
        }

        return [
            'data' => $result
        ];
    }


    /**
     * @return array
     */
    public function getCity()
    {
        $countryList = $this->db->select('location', '*', [
            'parent[!]' => 0
        ]);

        $result = [];

        foreach ($countryList as $value) {
            $result[$value['id']] = $value;
        }

        return [
            'data' => $result
        ];
    }

    /**
     * @param $val
     * @return array|bool
     */
    public function selectCity($val)
    {
        $result = $this->db->select('location','*',[
            'parent' => $val
        ]);

        return $result;
    }
}