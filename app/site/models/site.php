<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 09.03.16
 * Time: 8:13
 */

namespace app\site\models;


use core\Models;

class site extends Models
{
    public function getAllSite($page=0)
    {
        $limit = PAGE_SIZE;
        $countData = $this->db->count('site');
        $countPage = ceil($countData / $limit);
        $offset = (int)$page * $limit;
        $companyData = $this->db->select('site', [
            "[>]email" => ["email" => "id"]
        ],
            [
                'site.*',
                'email.id',
                'email.login',
                'email.password',
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

    public function getSite($id)
    {
        return $id;
    }
}