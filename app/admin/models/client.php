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
        if ($user['access']!=999) {
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
        }
        else
        {
            $countSite = $this->db->count('company',
                [
                    'company.id'
                ]
            );
        }
        $countPage = ceil($countSite / $limit);
        $offset = (int)$page * $limit;
        if ($user['access']!=999) {
            $siteData = $this->db->select('company',
                [
                    "[>]permission_c" => ["id" => "company"]
                ],
                [
                    'company.id', 'name', 'site', 'ph_address', 'date_create', 'permission_c.permission'
                ],

                [
                    "permission_c.user" => $user['id'],
                    'LIMIT' => [$offset, $limit],
                    'ORDER' => ['id ASC']
                ]
            );
        }
        else
        {
            $siteData = $this->db->select('company',
                [
                    'company.id', 'name', 'site', 'ph_address', 'date_create'
                ],

                [
                    'LIMIT' => [$offset, $limit],
                    'ORDER' => ['id ASC']
                ]
            );
        }

        return [
            'data' => $siteData,
            'count' => $countPage
        ];
    }

    public function GetAllSiteClient($id,$page,$user)
    {
        $limit = PAGE_SIZE;
        if ($user['access']!=999) {
            if ($this->permission_c($id, $user)) {
                $countSite = $this->db->count('site',
                    [
                        "[>]permission_s" => ["id" => "site"]
                    ],
                    [
                        'site.id'
                    ],

                    [
                        'AND' => ["permission_s.user" => $user['id'], 'site.company' => $id]
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
                        'AND' => ["permission_s.user" => $user['id'], 'site.company' => $id],
                        'LIMIT' => [$offset, $limit],
                        'ORDER' => ['id ASC']
                    ]
                );


                return [
                    'data' => $siteData,
                    'count' => $countPage
                ];
            } else {
                return false;
            }
        }
        else
        {
            $countSite = $this->db->count('site',
                [
                    "[>]permission_s" => ["id" => "site"]
                ],
                [
                    'site.id'
                ],
                [
                    'AND' => ["permission_s.user" => $user['id'], 'site.company' => $id]
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
                    'AND' => ["permission_s.user" => $user['id'], 'site.company' => $id],
                    'LIMIT' => [$offset, $limit],
                    'ORDER' => ['id ASC']
                ]
            );


            return [
                'data' => $siteData,
                'count' => $countPage
            ];
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
        if ($result  = $this->db->insert('company',$value)) {
          $this->CratePermission_s($result,$user);
        }

        return [
            'data'=>$value
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

    function CratePermission_s($id,$user)
    {
        $value =array();

        $value['company']=$id;
        $value['user']=$user['id'];
        $value['permission']=3;
        $result  = $this->db->insert('permission_c',$value);

        return $result;
    }

}