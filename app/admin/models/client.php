<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 18.03.16
 * Time: 16:58
 */

namespace app\admin\models;


use core\Models;

class client extends Models
{

/*--------------Client----------------*/

    public function GetAllClient($page,$user)
    {
        $limit = PAGE_SIZE;
        $countSite = $this->db->count('company',
            [
                "[>]permission_c" => ["id" => "company"]
            ],
            [
                'company.id'
            ],

            [
                "permission_c.user"=>$user['id'],
            ]
        );
        $countPage = ceil($countSite / $limit);
        $offset = (int)$page * $limit;
        $siteData = $this->db->select('company',
            [
                "[>]permission_c" => ["id" => "company"]
            ],
            [
                'company.id','name','legal_address','ph_address'
            ],

            [
                "permission_c.user"=>$user['id'],
                'LIMIT' => [$offset, $limit],
                'ORDER' => ['id ASC']
            ]
        );

        return [
            'data' => $siteData,
            'count' => $countPage
        ];
    }

    public function GetClient($id)
    {
        $siteData = $this->db->select('company',
            [
                'company.*',
            ]
            ,
            [
                'company.id'=>$id
            ]
        );

        return [
            'data' => $siteData,
        ];

    }

    public function EditClient($id,$value)
    {
        $result = $this->db->update('company',$value,[
            'id'=>$id
        ]);

        return [
            'data'=>$result
        ];
    }

    public function AddClient ($value)
    {
        $result  = $this->db->insert('company',$value);

        return [
            'data'=>$result
        ];
    }

}