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
                'company.id','name','legal_address','ph_address','permission_c.permission'
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

    public function GetAllSiteClient($id,$page,$user)
    {
        $limit = PAGE_SIZE;
        if ($this->permission_c($id,$user)) {
            $countSite = $this->db->count('site',
                [
                    "[>]permission_s" => ["id" => "site"]
                ],
                [
                    'site.id'
                ],

                [
                   'AND'=>["permission_s.user" => $user['id'],'site.company'=>$id]
                ]
            );
            $countPage = ceil($countSite / $limit);
            $offset = (int)$page * $limit;
            $siteData = $this->db->select('site',
                [
                    "[>]permission_s" => ["id" => "site"]
                ],
                [
                    'site.*'
                ],

                [
                    'AND'=>["permission_s.user" => $user['id'],'site.company'=>$id],
                    'LIMIT' => [$offset, $limit],
                    'ORDER' => ['id ASC']
                ]
            );


            return [
                'data' => $siteData,
                'count' => $countPage
            ];
        }
        else
        {
            return false;
        }
    }

    public function GetClient($id,$user)
    {
        $siteData = $this->db->select('company',
            [
                "[>]permission_c" => ["id" => "company"]
            ],
            [
                'company.*','permission_c.permission'
            ]
            ,
            [
                'AND'=>['company.id'=>$id,
                "permission_c.user"=>$user['id'],]
            ]
        );
        if (!$siteData)
        {
            $siteData[0]=false;
        }
        return [
            'data' => $siteData[0],
        ];

    }

    public function EditClient($id,$value,$user)
    {
        if ($this->permission_c($id, $user)) {
            $result = $this->db->update('company', $value, [
                'id' => $id
            ]);
        } else {
            $result = false;
        }

        return [
            'data' => $result
        ];
    }

    public function AddClient ($value,$user)
    {
        $result  = $this->db->insert('company',$value);

        return [
            'data'=>$result
        ];
    }


    /*---Проверка доступа к клиенту---*/
    function permission_c ($id,$user)
    {
        $countSite = $this->db->count('company',
            [
                "[>]permission_c" => ["id" => "company"]
            ],
            [
                'company.id'
            ],

            [
                'AND'=>['company.id'=>$id,
                    "permission_c.user"=>$user['id'],]
            ]
        );
        return $countSite;
    }

}