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
            $chat_id=169105432;
            file_put_contents(PUBLIC_PATH.'/css/cache/text.txt',print_r($data,true));
            $this->SaveMessage(5,$data['message']['from']['id'],json_encode($data));
            if (isset($data['message']['entities'])) {
                $command=[
                    '/start',
                    '/help',
                    'Ⓜ️Меню',
                    '/select',
                    '/close',

                ];
                $id=false;
                foreach($command as $value){
                    $id=explode($value,$data['message']['text']);
                    if ($value=$data['message']['text']){
                        $command=$value;
                        file_put_contents(PUBLIC_PATH.'/css/cache/text.txt',$value);
                        break;
                    }
                    if ((int)$id[1])
                    {
                        $command=$value;
                        $bot->jsonSendMessage($token, $chat_id, $id[1].' '.$data['message']['from']['id']);
                        break;
                    }
                }
                switch ($command){
                    case '/start':
                        $bot->SendMessage($token,$chat_id,['text'=>
'Здравствуйте я бот компании Business link.
    Я помогу вам наладить связи между вами и вашими клиентами!'
                        ],$this->CreateKeyboard($command));
                        break;
                    case '/help':
                        $bot->SendMessage($token,$chat_id,['text'=>
                            'Здравствуйте я бот компании Business link.
    Я помогу вам наладить связи между вами и вашими клиентами!'
                        ],$this->CreateKeyboard($command));
                        break;
                    case 'Ⓜ️Меню':
                        $bot->SendMessage($token,$chat_id,['text'=>
                            'Здравствуйте я бот компании Business link.
    Я помогу вам наладить связи между вами и вашими клиентами!'
                        ],$this->CreateKeyboard($command));
                        break;

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
    $patern=[
        'update_id' => '',
        'message' =>[
            'message_id' => '',
            'from' => [
                'id' => '',
                'first_name' => '',
                'last_name' => '',
                'username' => ''
                    ],
            'chat' => [
                'id' => '',
                'title' => '',
                'type' => '',
                        ],
            'date' => time(),
            'text' => $data['text'],
        ],
            ];
        $site=$this-> permission($name)['data'];
        if ( $site ) {
            $chat=$this->createChat($data['token'],$site[0]);
            if (gettype($chat['data'])=='array') {
                if (isset($chat['data'][0]['operator'])) {
                    $this->sendMessageText(['id' => $chat['data'][0]['id'], 'text' => $data['text']], $chat['data'][0]['operator']);
                    $this->SaveMessage($chat['data'][0]['id'], $data['token'], json_encode($patern));
                }
                else
                {
                    $this->sendMessageText(['id' => $chat['data'][0]['id'], 'text' => $data['text']]);
                    $this->SaveMessage($chat['data'][0]['id'], $data['token'], json_encode($patern));
                }

            }
            else
            {
                $this->sendMessageText(['id' => $chat['data'], 'text' => $data['text']]);
                $this->SaveMessage($chat['data'],$data['token'],json_encode($patern));
            }
            return $chat;
        }
        return false;

    }

    //Создание и отправка клавиотур

    function CreateKeyboard ($command){
        switch ($command){

            case 'Ⓜ️Меню':
                return ['Ⓜ️Тебю'];
                break;
            default:
                return ['Ⓜ️Меню'];
                break;
        }
    }

    function sendMessageText($data,$operator=-149637232)
    {
            $bot = new \app\telegram\Bot();
            $token='146927044:AAHz2gw_UGcJdzdb4Eh-NoW2PMhYS7oBbrU';
            $chat_id=$operator;

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
            $siteData = $this->db->update('chats',
                [
                    'operator' => ''
                ],
                [
                    'id'=>$id
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

    function SaveMessage($id_chat,$from,$message){
        $data=[
            'id_chat'=>$id_chat,
            'from'=>$from,
            'data'=>$message,
        ];
    $this->db->insert('chat_data',$data);
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