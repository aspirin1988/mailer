<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 22.02.2016
 * Time: 17:42
 */

namespace app\helper\models;


use core\Models;

/**
 * Class Companycategory
 * @package app\helper\models
 */
class Companycategory extends Models
{
    /**
     * @return array
     */
    public function getCompanyCategory()
    {
        $list = $this->db->select('company_categorias', ['id', 'name'], [
            'parent' => 0,
            'ORDER' => 'name'
        ]);

        $result = [];

        foreach ($list as $item) {
            $result[$item['id']] = $item;
        }

        return [
            'data' => $item
        ];
    }

    /**
     * @param $id
     * @return array|bool
     */
    public function getCompanyCategoryById($id)
    {
        $list = $this->db->select('company_categorias', ['id', 'name'], [
            'parent' => $id,
            'ORDER' => 'name'
        ]);

        return $list;
    }
}