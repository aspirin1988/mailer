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
        $countSite = $this->db->count('site',[
            "[>]permission_s" => ["id" => "site"]
            ],
            [
                'site.id'
            ],
            [
                "permission_s.user"=>$user['id'],
            ]);
        $countPage = ceil($countSite / $limit);
        $offset = (int)$page * $limit;
        $siteData = $this->db->select('site',
            [
                "[>]permission_s" => ["id" => "site"],
                "[>]company" => ["company" => "id"]
            ],
            [
                'site.*','permission_s.permission','company.name(c_name)'
            ],
            [
                "permission_s.user"=>$user['id'],
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
        $this->NewCSS( $value['md5']);
        $result  = $this->db->insert('site',$value);

        return [
            'data'=>$result
        ];
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
        if($result = $this->db->update('email',$value,['id'=>$id])) {return ['data'=>$id];} else {return ['data'=>false];}

    }

    public function AddGateway ($value)
    {
        $result  = $this->db->insert('email',$value);

        return [
            'data'=>$result
        ];
    }




    /*-----Create-New-CSS-----*/
    function NewCSS ($name)
    {
        $data = file_get_contents($path = PUBLIC_PATH . DS . 'resources' . DS . 'callback' . DS . 'css' . DS . 'blink-sb-style.css');
        $data = str_replace('{host}', 'http' . HOST_NAME, $data);
        file_put_contents($path = PUBLIC_PATH . DS . 'resources' . DS . 'callback' . DS . 'css' . DS .$name.'blink-sb-style.css',$data);
    }

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


}