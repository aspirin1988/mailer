<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 19.02.2016
 * Time: 17:37
 */

namespace app\programmer\models;


use core\Models;

class Company extends Models
{
    public function getCompanyById($companyId)
    {
        $data = $this->db->select('company','*',['id'=>$companyId]);
        return [
          'data'=>$data
        ];
    }

    public function isMyCompany($companyId,$developer)
    {
        return $this->db->has('project', [
            "AND" => [
                'id' => $companyId,
                'manager' => $developer
            ]
        ]);
    }

}