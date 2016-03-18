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
    public function GetAllSite($page)
    {
        $limit = PAGE_SIZE;
        $countSite = $this->db->count('site');
        $countPage = ceil($countSite / $limit);
        $offset = (int)$page * $limit;
        $siteData = $this->db->select('site',
            [
                'site.*',
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

    public function GetSite($id)
    {
        $siteData = $this->db->select('site',
            [
                "[>]email" => ["email" => "id"]
            ],
            [
                'site.*',
                'email.login',
                'email.password',
            ]
            ,
            [
                'site.id'=>$id
            ]
        );

        return [
            'data' => $siteData,
        ];

    }

    public function EditSite($id,$value)
    {
        $value['md5']=md5($value['name']);
        $result = $this->db->update('site',$value,[
            'id'=>$id
        ]);

        return [
            'data'=>$result
        ];
    }

    public function AddSite ($value)
    {
        $value['md5']=md5($value['name']);
        $result  = $this->db->insert('site',$value);

        return [
            'data'=>$result
        ];
    }

/*--------------Gateway----------------*/

    public function GetAllGateway($page)
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

    public function GetGateway($id)
    {
        $siteData = $this->db->select('email',
            [
                'email.*',
            ]
            ,
            [
                'email.id'=>$id
            ]
        );

        return [
            'data' => $siteData,
        ];

    }

    public function EditGateway($id,$value)
    {
        $result = $this->db->update('email',$value,[
            'id'=>$id
        ]);

        return [
            'data'=>$result
        ];
    }

    public function AddGateway ($value)
    {
        $result  = $this->db->insert('email',$value);

        return [
            'data'=>$result
        ];
    }


}