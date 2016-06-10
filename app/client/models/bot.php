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

        if ($this->permission($name)['data']) {
            $bot = new \app\telegram\Bot();
            $token = '146927044:AAHz2gw_UGcJdzdb4Eh-NoW2PMhYS7oBbrU';
            $chat_id = $data['message']['from']['id'];
//            $chat_id = -149637232;
            $this->SaveMessage(6, $data['message']['from']['id'], json_encode($data));

            $command = [
                '/start'=>'string',
                '/help'=>'string',
                'Ⓜ️Меню'=>'string',
                '👁Текущий чат'=>'string',
                '/select'=>'integer',
                '🔚Закрыть чат'=>'integer',
                '🔁Передать'=>'integer',

            ];
            $argument=false;
            $id = false;

            foreach ($command as $key=>$value) {
                if ($key == $data['message']['text']) {
                    $command = $key;
                    break;
                }
                $argument = explode($key, $data['message']['text']);
                file_put_contents(PUBLIC_PATH.'/css/cache/text.txt',(int)$argument);
                if (isset($argument[1]))
                {
                    $command=$key;
                    $argument=settype($argument[1],$value);


                }
                /*if ((int)$id[1]) {
                    $id[1]=(int)$id[1];
                    $command = $value;
                    switch ($command) {
                        case '/select':
                            $bot->jsonSendMessage($token, $chat_id, $id[1] . ' ' . $data['message']['from']['id']);
                            break;
                        case '🔁Передать':
                            $current_chat=$this->GetChatList($chat_id);
                            if (isset($current_chat['current_chat']))
                            {
                                $current_chat=$current_chat['current_chat'];
                                $this->TransferChat($current_chat['id'],$id[1]);
                            }
                            break;
                    }
                    break;
                }*/
            }

//            file_put_contents(PUBLIC_PATH.'/css/cache/text.txt',$data['message']['text']);
            switch ($command) {
                case '/start':
                    $bot->SendMessage($token, $chat_id, ['text' =>
                        'Здравствуйте я бот компании Business link.
    Я помогу вам наладить связи между вами и вашими клиентами!'
                    ], $this->CreateKeyboard($command));
                    break;
                case '/help':
                    $bot->SendMessage($token, $chat_id, ['text' =>
                        'Здравствуйте я бот компании Business link.
    Я помогу вам наладить связи между вами и вашими клиентами!'
                    ], $this->CreateKeyboard($command));
                    break;
                case 'Ⓜ️Меню':
                    $bot->SendMessage($token, $chat_id, ['text' =>
                        'Здравствуйте я бот компании Business link.
    Я помогу вам наладить связи между вами и вашими клиентами!'
                    ], $this->CreateKeyboard($command));
                    break;
                case '👁Текущий чат':
                    $bot->SendMessage($token, $chat_id, ['text' =>json_encode($this->GetChatList($chat_id))
                    ], $this->CreateKeyboard($command));
                    break;
                case '🔁Передать':

                    if ($argument<>1){
                        $bot->SendMessage($token, $chat_id, ['text' =>$argument
                        ], $this->CreateKeyboard($command));
                        $current_chat=$this->GetChatList($chat_id);
                        if (isset($current_chat['current_chat']))
                        {
                            $current_chat=$current_chat['current_chat'];
                            $this->TransferChat($current_chat['id'],$argument);
                        }
                    }
                    else{
                        $bot->SendMessage($token, $chat_id, ['text' =>$argument
                        ], $this->CreateKeyboard($command));
                    }

                    break;

                case '/select':
                    $this->selectChat($id[1], $data['message']['from']['id']);
                    break;
                case '/close':
                    $this->deleteChat($id[1], $data['message']['from']['id']);
                    break;
            }

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
            $chat=$this->issetChat($data['token']);
            $chat_data=$this->GetChatText($chat['data'][0]['id'])['data'];
            foreach ($chat_data as $key=> $value){
                $chat_data[$key]['data']=json_decode($value['data']);
            }
            

            return $chat_data;
        }
        return false;

    }

    public function GetChatData($data,$name)
    {
        $site=$this-> permission($name)['data'];
        if ( $site ) {
            $chat = $this->issetChat($data['token']);
            $chat_data = $this->GetChatText($chat['data'][0]['id'])['data'];
            foreach ($chat_data as $key => $value) {
                $chat_data[$key]['data'] = json_decode($value['data']);
            }
        }

        return $chat_data;
    }

    //Создание и отправка клавиотур

    function CreateKeyboard ($command){
        switch ($command){

            case 'Ⓜ️Меню':
                return [
                    ['👁Текущий чат','Ⓜ️Тебю'],
                    ['👁Список чатов','Ⓜ️Тебю'],
                    ['🔁Передать','Ⓜ️Тебю'],
                    ['Ⓜ️Меню']
                ];
                break;
            case '👁Текущий чат':
                return [
                    ['🔁Передать','👁Список чатов'],
                    ['👁Список чатов','Ⓜ️Тебю'],
                    ['🔚Закрыть чат','Ⓜ️Тебю'],
                    ['Ⓜ️Меню']
                ];
                break;
            case '🔁Передать':
                return [
                    [
                        'Ⓜ️Меню'
                    ]
                ];
                break;
            default:
                return [
                    [
                        'Ⓜ️Меню'
                    ]
                ];
                break;
        }
    }

    function GetChatText($id){
        $siteData = $this->db->select('chat_data',
            [
                'chat_data.*',
            ]
            ,
            [
                'id_chat'=>(string)$id,
                'LIMIT'=>10,
                'ORDER'=> ['id DESC'],
            ]
        );

        return [
            'data' => $siteData,
        ]; 
    }

    function GetChatList ($chat_id){
        $current_chat=$this->db->select('chats',
            [
                'chats.*'
            ],
            [
                'operator'=>$chat_id
            ]
            )[0];
        $free_chat=$this->db->select('chats',
            [
                'chats.*'
            ],
            [
                'operator'=>0
            ]
        );

        return['current'=>$current_chat,'free'=>$free_chat];

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
                    'operator' => 0
                ],
                [
                    'id'=>$id
                ]
            );
        return $siteData;
    }

    function TransferChat($id,$operator)
    {
        return $this->db->update('chats',['operator'=>$operator],['id'=>$id]);
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

    function issetChatOperator($operator){
        $siteData = $this->db->select('chats',
            [
                'chats.*',
            ]
            ,
            [
                'operator'=>$operator
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