<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 10.03.16
 * Time: 23:56
 */

namespace app\site\models;


use core\Models;

class email extends Models
{
    public function getAllEmail($page=0)
    {
        $limit = PAGE_SIZE;
        $countData = $this->db->count('email');
        $countPage = ceil($countData / $limit);
        $offset = (int)$page * $limit;
        $companyData = $this->db->select('email',
            [
                'email.*',
            ],
            [
                'LIMIT' => [$offset, $limit],
                'ORDER' => ['id ASC']
            ]
        );

        return [
            'data' => $companyData,
            'count' => $countPage
        ];

    }
}