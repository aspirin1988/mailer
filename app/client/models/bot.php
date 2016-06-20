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
    public function sendMessage($data)
    {
        //file_put_contents(PUBLIC_PATH.'/css/cache/text.txt',json_encode($data,true));

        $user_name=$data['message']['from']['first_name'].' '.$data['message']['from']['last_name'];

            $bot = new \app\telegram\Bot();
            $token = '146927044:AAHz2gw_UGcJdzdb4Eh-NoW2PMhYS7oBbrU';
            $chat_id = $data['message']['from']['id'];
            $site_chat_id = $data['message']['chat']['id'];
            $site_chat_title=$data['message']['chat']['title'];
            $message=$data['message']['text'];
//            $chat_id = -149637232;
            $command = [
                '/operator' => 'string',
                '/chat' => 'string',
                '/start' => 'string',
                '/help' => 'string',
                'Ⓜ️Меню' => 'string',
                '👁Текущий чат' => 'string',
                '/select' => 'integer',
                '🔚Закрыть чат' => 'integer',
                '🔁Передать' => 'integer',

            ];
            $is_bot_command = false;
            $argument = false;
            $id = false;

            foreach ($command as $key => $value) {
                if (stristr($message,$key)) {
                    $argument = explode($key, $message);
                    $command = $key;
                    $is_bot_command = true;
                    if (isset($argument[1]))
                    {
                        $argument=ltrim($argument[1]);
                    }
                    file_put_contents(PUBLIC_PATH.'/css/cache/text.txt',json_encode($data));

                    break;
                }
            }

            if ($is_bot_command) {
                //file_put_contents(PUBLIC_PATH.'/css/cache/text.txt',json_encode($data,true));
                switch ($command) {
                    case '/start':
                        $bot->SendMessage($token, $site_chat_id, ['text' =>
                            'Здравствуйте я бот компании Business link.
    Я помогу вам наладить связи между вами и вашими клиентами!'
                        ], $this->CreateKeyboard($command));
                        break;
                    case '/chat':

                        $site=$this->permission(md5($argument));
                        if ($site['data']) {
                            $site=$site['data'][0]['id'];
                            if($this->editSiteChar($site_chat_id,$site)) {
                                $bot->SendMessage($token, $chat_id, ['text' =>
                                    'Здравствуйте я бот компании Business link.
    Чат вашего сайта был в @'.$site_chat_title  .' '
                                ], $this->CreateKeyboard($command));
                            }
                        }
                        break;
                    case '/operator':
                        $site=$this->permission(md5($argument));
                        if ($site['data']) {
                            $site=$site['data'][0]['id'];
                            $addOperator=$this->addOperator($chat_id,$user_name,$site);
                            if ($addOperator) {
                                $bot->SendMessage($token, $chat_id, ['text' =>
                                    'Здравствуйте ' . $user_name . '! Вы добавлены как оператор для сайта ' . $argument
                                ], $this->CreateKeyboard($command));
                            }
                            else
                            {
                                $bot->SendMessage($token, $chat_id, ['text' =>
                                    'Здравствуйте ' . $user_name . '! Вы уже являетесь оператором сайта ' . $argument
                                ], $this->CreateKeyboard($command));
                            }
                        }
                        else
                        {
                            $bot->SendMessage($token, $chat_id, ['text' =>
                                'Здравствуйте ' . $user_name . '! Сайста с именем ' . $argument . ' не сеществует в нашей базе!'
                            ], $this->CreateKeyboard($command));
                        }
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
                        $bot->SendMessage($token, $chat_id, ['text' => json_encode($this->GetChatList($chat_id))
                        ], $this->CreateKeyboard($command));
                        break;
                    case '🔁Передать':

                        if ($argument <> 1) {
                            $bot->SendMessage($token, $chat_id, ['text' => $argument
                            ], $this->CreateKeyboard($command));
                            $current_chat = $this->GetChatList($chat_id);
                            if (isset($current_chat['current_chat'])) {
                                $current_chat = $current_chat['current_chat'];
                                $this->TransferChat($current_chat['id'], $argument);
                            }
                        } else {
                            $bot->SendMessage($token, $chat_id, ['text' => $argument
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
        else
        {
            $this->SaveMessage(6, $data['message']['from']['id'], json_encode($data));
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
                    $this->sendMessageText(['id' => $site['data'][0]['chat_id'], 'text' => $data['text']]);
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

    function editSiteChar($chat_id,$site)
    {
        $ins=array(
            'chat_id'=>$chat_id,
        );
            return $this->db->update('site', $ins,[ 'id'=>$site]);
    }

    function addOperator($chat_id,$user_name,$site)
    {
        $ins=array(
                    'telegramm_id'=>$chat_id,
                    'display_name'=>$user_name,
                    'site_id'=>$site
        );
        $find_site=$this->findOperator($chat_id,$user_name,$site);
        if (!$find_site['data']) {
            return $this->db->insert('operators', $ins);
        }
        return false;
    }

    function findOperator($chat_id,$user_name,$site)
    {
        $siteData = $this->db->select('operators',
            [
                'operators.*',
            ]
            ,
            [
                'AND'=>[
                'telegramm_id'=>$chat_id,
                'display_name'=>$user_name,
                'site_id'=>$site
                ]
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