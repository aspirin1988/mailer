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
                
                $clientData=$this->db->select('permission_c',
                    [
                        "[>]company" => ["company" => "id"]
                    ],
                    [
                        'permission_c.id','company.id(company)', 'name', 'date_create', 'permission_c.permission','permission_c.user'
                    ],
                    [
                        'permission_c.user'=>$value['id']
                    ]
                );
                foreach ($clientData as $key1=>$value1) {
                    $sitesData = $this->db->select('permission_s',
                        [
                            "[>]site" => ["site" => "id"]
                        ],
                        [
                            'permission_s.id', 'site.id(site)', 'name', 'permission_s.permission', 'permission_s.user', 'site.company'
                        ],
                        [
                           'AND'=>['site.company' => $value1['company'],'permission_s.user'=>$value['id']]
                        ]
                    );
                    $clientData[$key1]['sites']=$sitesData;
                }


                $userData[$key]['company']=$clientData;
            }
            return [
                'data' => $userData,
            ];
        }
    }

    public function delPermission($id,$user){

        if($user['access']==999) {
            return $this->db->delete('permission_c', ['id' => $id]);
        }
    }
    
    public function approvePermission_c($id,$value,$user){
        if($user['access']==999) {
            if ($value)
            {
                return $this->db->update('permission_c',['permission'=>'true'],['id' => $id]);
            }
            else
            {
                return $this->db->update('permission_c',['permission'=>'false'],['id' => $id]);
            }
        }
    }

    public function approvePermission_s($id,$value,$user){
        if($user['access']==999) {
            if ($value)
            {
                return $this->db->update('permission_s',['permission'=>'true'],['id' => $id]);
            }
            else
            {
                return $this->db->update('permission_s',['permission'=>'false'],['id' => $id]);
            }
        }
    }

    public function delPermission_s($id,$user){

        if($user['access']==999) {
            return $this->db->delete('permission_s', ['id' => $id]);
        }
    }
    
    

}