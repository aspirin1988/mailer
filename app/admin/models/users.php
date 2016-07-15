<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 15.07.16
 * Time: 11:50
 */

namespace app\admin\models;


use core\Models;

class users extends Models
{

    public function GetAllUsers($user){
        if($user['access']==999) {
            $userData = $this->db->select('users',
                [
                    'users.id','users.last_name','users.first_name','users.middle_name','users.issue_date','users.login_crm',
                ]
            );
            foreach ($userData as $key=>$value){
                $permissionData = $this->db->select('permission_s',
                    [
                        'permission_s.*',
                    ],
                    [
                        'permission_s.user'=>$value['id']

                    ]
                );
                $clientData=$siteData = $this->db->select('permission_c',
                    [
                        "[>]company" => ["company" => "id"]
                    ],
                    [
                        'company.id', 'name', 'date_create', 'permission_c.permission'
                    ]);

                foreach ($permissionData as $key1=>$value1) {
                    $siteName = $this->db->select('site',
                        [
                            'site.*',
                        ],
                        [
                            'site.id'=>$value1['site']
                        ]
                    );
                    if ($siteName)
                    {
                        $permissionData[$key1]['name']=$siteName[0]['name'];
                    }
                    else
                    {
                        $permissionData[$key1]['name']='Не существует!';
                    }
                }

                $userData[$key]['permission_s']=$permissionData;
                $userData[$key]['company']=$clientData;
            }
            return [
                'data' => $userData,
            ];
        }
    }

}