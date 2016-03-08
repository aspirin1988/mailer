<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 17.02.2016
 * Time: 15:52
 */

namespace app\designer\models;


use core\Models;

class designer extends Models
{
    public function getCompany()
    {
        $data = $this->db->select("company", [
            "id",
            "name"
        ]);

        return $this->db->info();
    }
}