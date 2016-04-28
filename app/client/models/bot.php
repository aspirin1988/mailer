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

            if (isset($data['message']['entities'])) {
                $command=[
                    '/select',
                    '/close',
                ];
                $id=false;
                foreach($command as $value){
                    $id=explode($value,$data['message']['text']);
                    if ((int)$id[1])
                    {
                        $command=$value;
                        $bot->jsonSendMessage($token, $chat_id, $id[1].' '.$data['message']['from']['id']);
                        break;
                    }
                }
                switch ($command){
                    case '/select':$this->selectChat($id[1],$data['message']['from']['id']);
                        break;
                    case '/close':$this->deleteChat($id[1],$data['message']['from']['id']);
                        break;
                }

//                $bot->jsonSendMessage($token, $chat_id, $data['message']['from']['id']);
//                $bot->SendForwardMessage($token, $chat_id, $data['message']);
                //return $data;
                //$this->selectChat($id[1],$data['message']['from']['id']);
            }
            else
            {

            }
            return false;
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
        $site=$this-> permission($name)['data'];
        if ( $site ) {
            $chat=$this->createChat($data['token'],$site[0]);
            if (gettype($chat['data'])!='array') {
                $this->sendMessageText(['id' => $chat['data'], 'text' => $data['text']]);
            }
            else
            {
                $this->sendMessageText(['id' => $chat['data'][0]['id'], 'text' => $data['text']]);
            }
            return $chat;
        }
        return false;

    }

    function sendMessageText($data)
    {
            $bot = new \app\telegram\Bot();
            $token='146927044:AAHz2gw_UGcJdzdb4Eh-NoW2PMhYS7oBbrU';
            $chat_id=-149637232;
            $bot->SendMessage($token,$chat_id,$data);
    }

    function createChat($token,$site){
        $chat=$this->issetChat($token);
        if (!$chat['data']){
            $siteData = $this->db->insert('chats',
                [
                    'token'=>$token,
                    'site'=>$site['id']
                ]

            );
            return [
                'data' => $siteData,
            ];
        }
        return $chat;
    }

    function selectChat($id,$operator){
        $siteData=false;
        $chat=$this->issetChatId($id);
        if($chat[0]['operator'])
        {

        }
        else
        {
            $siteData = $this->db->update('chats',
                [
                    'operator'=>$operator
                ]
                ,
                [
                    'id'=>$id
                ]
            );
        }
        return $siteData;
    }

    function deleteChat($id,$operator){
            $siteData = $this->db->delete('chats',
                [
                    'id' => $id
                ]
            );
        return $siteData;
    }

    //Проверка на существование данного чата
    function issetChat($token){
        $siteData = $this->db->select('chats',
            [
                'chats.*',
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

    function issetChatId($id){
        $siteData = $this->db->select('chats',
            [
                'chats.*',
            ]
            ,
            [
                'id'=>$id
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