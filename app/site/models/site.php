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
        $countSite = $this->db->count('site');
        $countPage = ceil($countSite / $limit);
        $offset = (int)$page * $limit;
        $siteData = $this->db->select('site', [
            "[>]email" => ["email" => "id"]
        ],
            [
                'site.*',
                'email.login',
                'email.password',
            ],
            [
                'LIMIT' => [$offset, $limit],
                'ORDER' => ['id ASC']
            ]
        );

        return [
            'data' => $siteData,
            'count' => $countPage
        ];

    }

    public function getSite($id)
    {
        $siteData = $this->db->select('site',
            [
                'site.*',
            ]
            ,
            [
                'id'=>$id
            ]
        );

        return [
            'data' => $siteData,
        ];

    }

    public function EditSite($id,$value)
    {
        $result = $this->db->update('site',$value,[
            'id'=>$id
        ]);

        return [
            'data'=>$result
        ];
    }
}