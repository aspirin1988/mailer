<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 28.04.16
 * Time: 15:09
 */

namespace app\client\models;


use core\Models;

class bot extends  Models
{
    public function sendMessage($data,$name)
    {
        if ( $this-> permission($name)['data']) {
            $bot = new \app\telegram\Bot();
            $token='146927044:AAHz2gw_UGcJdzdb4Eh-NoW2PMhYS7oBbrU';
            $chat_id=-149637232;
            $bot->SendMessage($token,$chat_id,$data['message']);
            return $data;
        }

        return false;
    }

    public function getMessage($data,$name)
    {
        if ( $this-> permission($name)['data']) {
            return $data;
        }
        return false;
    }

    public function sendMessageSite($data,$name)
    {
        if ( $this-> permission($name)['data']) {

            return $data;
        }
        return false;

    }


    function createChat($token){
        if ($this->issetSite($token)){
            $siteData = $this->db->insert('chats',
                [
                    'token'=>$token
                ]

            );
            return [
                'data' => $siteData,
            ];
        }
        return [
            'data' => false,
        ];
    }

    //Проверка на существование данного чата
    function issetSite($token){
        $siteData = $this->db->select('chats',
            [
                'site.*',
            ]
            ,
            [
                'token'=>$token
            ]
        );

        return [
            'data' => $siteData,
        ];
    }



    //Проверка на существование данного сайта и истечение срока его подписки
    function permission($name)
    {
        $siteData = $this->db->select('site',
            [
                'site.*',
            ]
            ,
            [
                'md5'=>$name
            ]
        );

        return [
            'data' => $siteData,
        ];
    }

}