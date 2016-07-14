<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 07.04.16
 * Time: 10:59
 */

namespace app\admin\models;


use core\Models;

class callback extends Models
{

    /*--------------Site----------------*/

    public function GetAllSite($page,$user)
    {
        $limit = PAGE_SIZE;
        if ($user['access']!=999) {
            $countSite = $this->db->count('site', [
                "[>]permission_s" => ["id" => "site"]
            ],
                [
                    'site.id'
                ],
                [
                    "permission_s.user" => $user['id'],
                ]);
            $countPage = ceil($countSite / $limit);
            $offset = (int)$page * $limit;
            $siteData = $this->db->select('site',
                [
                    "[>]permission_s" => ["id" => "site"],
                    "[>]company" => ["company" => "id"]
                ],
                [
                    'site.*', 'permission_s.permission', 'company.name(c_name)'
                ],
                [
                    "permission_s.user" => $user['id'],
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
            $countSite = $this->db->count('site');
            $countPage = ceil($countSite / $limit);
            $offset = (int)$page * $limit;
            $siteData = $this->db->select('site',
                [
                    "[>]company" => ["company" => "id"]
                ],
                [
                    'site.*', 'company.name(c_name)'
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
        unset($value['id']);
        $value['md5']=md5($value['name']);
        $result = $this->db->update('site',$value,[
            'id'=>$id
        ]);

        return [
            'data'=>$result
        ];
    }

    public function AddSite ($value,$user,$company=0)
    {
        $value['md5']=md5($value['name']);
        $value['company']=$company;
        if (!$this->ChecksSite($value['md5'])) {
            $result = $this->db->insert('site', $value);

            if ($result) {
                $this->CratePermission_s($result, $user);
                $this->CrateOptions_s($result);
                $countSite = $this->db->count('site',
                    [
                        'site.id'
                    ],
                    [
                        'site.company' => $company
                    ]
                );

                $siteData = $this->db->select('site',
                    [
                        'site.*'
                    ],

                    [
                        'site.company' => $company,
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
        else
        {
            return [
                'data' => false,
                'error'=> 'Site isset',
            ];
        }
    }

    public function OperatorEdit ($id,$approve,$sitename,$user)
        {
            $model = new \app\client\models\messagebot();
            $bot = new \app\telegram\MessageBot();
            $operator=$model->getOperatorByID($id);
            if ($approve=='true') {
                $bot->SendMessage($operator[0]['telegramm_id'], ['text' =>
                    'Здравствуйте <strong>' . $operator[0]['display_name'] . '</strong>! 
                    Ваш аккаунт активирован для сайта <b>' . $sitename.'</b> ✔️'
                ]);
            }
            else
            {
                $bot->SendMessage($operator[0]['telegramm_id'], ['text' =>
                    'Здравствуйте <strong>' . $operator[0]['display_name'] . '</strong>! 
                    Ваш аккаунт деактивирован сайта <b>' . $sitename .'</b> 🚫'
                ]);
            }
            $data=$this->db->update('operators',['approve'=>$approve],['id'=>$id]);
            return $operator;
        }

    public function OperatorDel ($id,$siteID,$sitename,$user)
    {
        if ($this->permission_s($siteID,$user)||$user['access']==999) {
            $model = new \app\client\models\messagebot();
            $bot = new \app\telegram\MessageBot();
            $operator = $model->getOperatorByID($id);
            $model->DelOperatorByID($id);
            $bot->SendMessage($operator[0]['telegramm_id'], ['text' =>
                'Здравствуйте <strong>' . $operator[0]['display_name'] . '</strong>! 
                    Ваш аккаунт был удален для сайта <b>' . $sitename . '</b> 🚫️'
            ]);

            return $user;
        }
        return false;
    }


    public function DelSite ($value)
    {
        $result  = $this->db->delete('site',['id'=>$value['id']]);
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
        if ($result = $this->db->update('email', $value, ['id' => $id])) {
            return ['data' => $this->db->select('email',
                [
                    'email.*',
                ])];
        } else {
            return ['data' => false];
        }

    }

    public function AddGateway ($value)
    {
        if (!$this->ChecksGateway($value['login'])) {
             $this->db->insert('email', $value);
            $result = $this->db->select('email',
                [
                    'email.*',
                ]);
            return [
                'data' => $result
            ];
        }
        else
        {
            return [
                'data' => false,
                'error'=> 'Gateway isset',
            ];
        }
    }

    /*-----Create-New-CSS-----*/
    function NewCSS ($name)
    {
        $data = file_get_contents($path = PUBLIC_PATH . DS . 'resources' . DS . 'callback' . DS . 'css' . DS . 'blink-sb-style.css');
        $data = str_replace('{host}', 'http' . HOST_NAME, $data);
        file_put_contents($path = PUBLIC_PATH . DS . 'resources' . DS . 'callback' . DS . 'css' . DS .$name.'blink-sb-style.css',$data);
    }

    /*--Checks--*/

    function permission_s ($id,$user)
    {
        $countSite = $this->db->count('site',
            [
                "[>]permission_s" => ["id" => "site"]
            ],
            [
                'site.id'
            ],

            [
                'AND'=>['site.id'=>$id,
                    "permission_s.user"=>$user['id'],]
            ]
        );
        return $countSite;
    }

    function ChecksSite($name)
    {
        $count=$this->db->count('site',['site.md5'=>$name]);
        if ($count)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function ChecksGateway($name)
    {
        $count=$this->db->count('email',['email.login'=>$name]);
        if ($count)
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    /*--Create-Permission-&-Config--*/

    function CratePermission_s($id,$user)
    {
        $value =array();

        $value['site']=$id;
        $value['user']=$user['id'];
        $value['permission']=3;
        $result  = $this->db->insert('permission_s',$value);

        return $result;
    }

    function CrateOptions_s($id)
    {
        $value =array();
        $value['site']=$id;
        $result  = $this->db->insert('site_options',$value);
        return $result;
    }


}