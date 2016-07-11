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
                ],
                [
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
            'count' => $countPage,
            'company' => $countSite
        ];
    }


    public function GetAllSiteClient($id,$user)
    {
        $limit = 999;
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
                    'count' => $countSite,
                    'pagesize' => PAGE_SIZE,
                ];
            } else {
                return false;
            }
        }
        else
        {
            $countSite = $this->db->count('site',
                [
                    'site.id'
                ],
                [
                    'site.company' => $id
                ]
            );
            $countPage = ceil($countSite / $limit);
            $offset = (int)$page * $limit;

            $siteData = $this->db->select('site',
                [
                    'site.*'
                ],

                [
                    'site.company' => $id,
                    'LIMIT' => [$offset, $limit],
                    'ORDER' => ['id ASC']
                ]
            );
            foreach ($siteData as $key => $value){
                $operators=$this->db->select('operators',
                    [
                        'operators.*',
                    ]
                    ,
                    [
                        'site_id'=>$value['id']
                    ]
                );

                $siteData[$key]['operators']=$operators;
            }

            return [
                'data' => $siteData,
                'count' => $countSite,
                'pagesize' => PAGE_SIZE,
            ];
        }
    }

    public function GetSiteInfo($id,$user)
    {
        if ($user['access']!=999) {
            if ($this->permission_c($id, $user)) {
                $infoData = $this->db->select('site_message',
                    [
                        'site_message.*'
                    ],

                    [
                        "site_id" => $id
                    ]
                );
                foreach ($infoData as $key=> $data){
                    $infoData[$key]['geodata']=json_decode($data['geodata'],true);
                }
                return [
                    'data' => $infoData,
                ];
            } else {
                return false;
            }
        }
        else
        {
            $infoData = $this->db->select('site_message',
                [
                    'site_message.*'
                ],

                [
                    "site_id" => $id
                ]
            );
            $infoMessage = $this->db->query("select site_message.status, count(site_message.status) from site_message WHERE site_id=$id GROUP BY site_message.status")->fetchAll(2);
            foreach ($infoMessage as $key=>$value)
            {
                $title='';
                switch ($value['status']){
                    case 'renouncement':
                        $title='Отказ';
                        break;
                    case 'completed':
                        $title='Завершенные';
                        break;
                    case 'new':
                        $title='Необработанные';
                        break;
                }
                $value['title']=$title;
                $infoMessage[$key]=$value;
            }
            $value['title']='Все';
            $value['status']='';
            $value['count']='';
            $infoMessage[]=$value;
            foreach ($infoData as $key=> $data){
                $infoData[$key]['geodata']=json_decode($data['geodata'],true);
            }
            return [
                'data' => $infoData,
                'MessageData' => $infoMessage,
            ];
        }
    }

    public function GetAllSiteClientNP($id,$user)
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
                    $siteData = $this->db->select('site',
                        [
                            "[>]permission_s" => ["id" => "site"]
                        ],
                        [
                            'site.*'
                        ],

                        [
                            'AND' => ["permission_s.user" => $user['id'], 'site.company' => $id],
                            'ORDER' => ['id ASC']
                        ]
                    );
                    return [
                        'data' => $siteData,
                    ];
                } else {
                    return false;
                }
            }
            else
            {
                $countSite = $this->db->count('site',
                    [
                        'site.id'
                    ],
                    [
                        'site.company' => $id
                    ]
                );
                $siteData = $this->db->select('site',
                    [
                        'site.*'
                    ],

                    [
                        'site.company' => $id,
                        'ORDER' => ['id ASC']
                    ]
                );
                foreach ($siteData as $key => $value){
                    $operators=$this->db->select('operators',
                        [
                            'operators.*',
                        ]
                        ,
                        [
                            'site_id'=>$value['id']
                        ]
                    );

                    $siteData[$key]['operators']=$operators;
                }

                return [
                    'data' => $siteData,
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

    public function AddClient ($page,$value,$user)
    {
        if ($result  = $this->db->insert('company',$value)) {
          $this->CratePermission_s($result,$user);

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
                    ],
                    [
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
                'count' => $countPage,
                'company' => $countSite
            ];
            
        }

        return [
            'data'=>$value
        ];
    }

    public function DelClient ($id)
    {
        $result  = $this->db->delete('company',['id'=>$id]);
        $this->db->delete('permission_c',['company'=>$id]);
        return [
            'data'=>$result
        ];
    }

    public function SearchClient ($value)
    {
        /*$result  = $this->db->select('company',
            [
                "[>]site" => ["id" => "company"]
            ],
            [
                'company.id', 'company.name', 'site.id(site)', 'company.ph_address', 'company.date_create',
            ],
            [
                "OR"=>['company.name[~]'=>$value,'#site.name[~]'=>$value]
            ]
            );*/
        $result = $this->db->query('SELECT DISTINCT "company"."id","company"."name" ,"company"."ph_address","company"."date_create" FROM "company" LEFT JOIN "site" ON "company"."id" = "site"."company" WHERE upper("company"."name") LIKE upper(\'%'.$value.'%\') OR upper("site"."name") LIKE upper(\'%'.$value.'%\') order by "company"."id"')->fetchAll(2);

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