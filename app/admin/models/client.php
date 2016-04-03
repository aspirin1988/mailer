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

    public function GetAllClient($page)
    {
        $limit = PAGE_SIZE;
        $countSite = $this->db->count('company');
        $countPage = ceil($countSite / $limit);
        $offset = (int)$page * $limit;
        $siteData = $this->db->select('company',
            [
                'id','name','legal_address','ph_address'
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



/*--------------Site----------------*/

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
        if($result = $this->db->update('email',$value,['id'=>$id])) {return ['data'=>$id];} else {return ['data'=>false];}

    }

    public function AddGateway ($value)
    {
        $result  = $this->db->insert('email',$value);

        return [
            'data'=>$result
        ];
    }


}