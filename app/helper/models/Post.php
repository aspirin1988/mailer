<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 22.02.2016
 * Time: 17:27
 */

namespace app\helper\models;


use core\Models;

/**
 * Class Post
 * @package app\helper\models
 */
class Post extends Models
{

    /**
     * @return array
     */
    public function getPost()
    {
        $list = $this->db->select('post_categorias', '*', ["ORDER" => "name"]);

        $result = [];

        foreach ($list as $item) {
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
    public function selectPost($id)
    {
        $item = $this->db->select('post_categorias', '*', ['id' => $id]);

        return $item;

    }
}