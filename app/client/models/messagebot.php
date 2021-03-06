<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 28.04.16
 * Time: 15:09
 */

namespace app\client\models;


use core\Models;
use  core\Response;


class messagebot extends  Models
{
    public function sendMessage($data)
    {
        $response = new Response();
        if ($data['callback_query']){
            $this->FindMessage($data['callback_query']);
        }
        $user_name=$data['message']['from']['first_name'].' '.$data['message']['from']['last_name'];

            $bot = new \app\telegram\MessageBot();
            $chat_id = $data['message']['from']['id'];
            $site_chat_id = $data['message']['chat']['id'];
            $site_chat_title=$data['message']['chat']['title'];
            $message=$data['message']['text'];
            $command = [
                '/start' => 'string',
                '/operator' => 'string',
                '/help' => 'string',
                '/statistic' => 'string',
                'я оператор' => 'string',
                'статистика' => 'string',
                'помощь' => 'string',
                '/screen all' => 'string',
                '/screen' => 'string',

            ];
            $is_bot_command = false;
            $argument = false;
            $id = false;

            foreach ($command as $key => $value) {

                if (stristr($message,$key)) {
                    /*$bot->SendMessage($chat_id, ['text' =>
                        'Здравствуйте я бот компании Business link.
    Я помогу вам наладить связи между вами и вашими клиентами!' .stristr($message,$key)
                    ]);*/
                    $argument = explode($key, $message);
                    //$argument=$argument[1];
                    file_put_contents(PUBLIC_PATH.'/css/cache/text.txt',json_encode($argument,true));
                    $command = $key;
                    $is_bot_command = true;
                    if (isset($argument[1]))
                    {
                        $argument=ltrim($argument[1]);
                        $argument=explode(' ',$argument);
                    }
//                    file_put_contents(PUBLIC_PATH.'/css/cache/text.txt',json_encode($data));

                    break;
                }
            }

            if ($is_bot_command) {
                switch ($command) {

                    case '/screen':
                        $url=$this->screen($argument[0],"1920x1080", "1920", "jpeg",$argument[0]);
                        if($url) {
                            $bot->SendImage($chat_id, $url,$argument[0]);
                        }
                        else{
                            $bot->SendMessage($chat_id, ['text' =>
                                'К сожалению невозможно сделать снимок данного сайта "'.$argument[0].'"!'
                            ]);
                        }
                        break;
                    case '/screen all':
                        $data=$this->db->select('site',['name']);
                        $image=[];
                        for ($i=0; $i<=count($data)-1; $i++){
                            $value=$data[$i];
                            $url=$this->screen($value['name'],"1920x1080", "1920", "jpeg",$value['name']);
                            if($url) {
                                $image[$i]['url']=$url;
                                $image[$i]['name']=$value['name'];
                            }
                            else{
                                $bot->SendMessage($chat_id, ['text' =>
                                    'К сожалению невозможно сделать снимок данного сайта "'.$value['name'].'"!'
                                ]);
                            }
                        }

                        if ($image) {
                            foreach ($image as $value) {
                                $bot->SendImage($chat_id, $value['url'],$value['name']);
                            }
                        }
                        return $response->json(true);
                        break;

                    case '/start':
                        $bot->SendMessage($site_chat_id, ['text' =>
                            'Здравствуйте я бот компании Business link.
    Я помогу вам наладить связи между вами и вашими клиентами!'
                        ]);
                        break;

                    case '/statistic':
                        $site=$this->permission(md5($argument[0]));
                        $operator=$this->findOperator($chat_id,$user_name,$site['data'][0]['id']);
                        if ($site['data']) {
                            if ($operator) {
                                $date=$argument;
                                unset($date[0]);
                                $SiteInfo=$this->GetSiteInfo($site,$date);
                                $text='<strong>Статисти по сайту '.$site['data'][0]['name'].' на '.date('Y.m.d').'</strong>
    ';
                                foreach ($SiteInfo['MessageData'] as $value){
                                $text.='<b>'.$value['title'].' '.$value['count'].'</b>
    ';
                                }
                                $timestamp = strtotime($date[1]);
                                $bot->SendMessage($site_chat_id, ['text' =>$text
                                ]);
                            }
                        }
                        break;

                    case 'статистика':
                        $site=$this->permission(md5($argument[0]));
                        $operator=$this->findOperator($chat_id,$user_name,$site['data'][0]['id']);
                        if ($site['data']) {
                            if ($operator) {
                                $date=$argument;
                                unset($date[0]);
                                $SiteInfo=$this->GetSiteInfo($site,$date);
                                $text='<strong>Статисти по сайту '.$site['data'][0]['name'].' на '.date('Y.m.d').'</strong>
    ';
                                foreach ($SiteInfo['MessageData'] as $value){
                                    $text.='<b>'.$value['title'].' '.$value['count'].'</b>
    ';
                                }
                                $timestamp = strtotime($date[1]);
                                $bot->SendMessage($site_chat_id, ['text' =>$text
                                ]);
                            }
                        }
                        break;

                    case '/operator':
                        $site=$this->permission(md5($argument[0]));
                        if ($site['data']) {
                            $site=$site['data'][0]['id'];
                            $addOperator=$this->addOperator($chat_id,$user_name,$site);
                            if ($addOperator) {
                                $bot->SendMessage($chat_id, ['text' =>
                                    'Здравствуйте ' . $user_name . '! Вы добавлены как оператор для сайта ' . $argument[0]. ', ожидайте подтверждения от администратора!'
                                ]);
                            }
                            else
                            {
                                $bot->SendMessage($chat_id, ['text' =>
                                    'Здравствуйте ' . $user_name . '! Вы уже являетесь оператором сайта ' . $argument[0]
                                ]);
                            }
                        }
                        else
                        {
                            $bot->SendMessage($chat_id, ['text' =>
                                'Здравствуйте ' . $user_name . '! Сайта с именем ' . $argument[0] . ' не существует в нашей базе!'
                            ]);
                        }
                        break;

                    case 'я оператор':
                        $site=$this->permission(md5($argument[0]));
                        if ($site['data']) {
                            $site=$site['data'][0]['id'];
                            $addOperator=$this->addOperator($chat_id,$user_name,$site);
                            if ($addOperator) {
                                $bot->SendMessage($chat_id, ['text' =>
                                    'Здравствуйте ' . $user_name . '! Вы добавлены как оператор для сайта ' . $argument[0]. ', ожидайте подтверждения от администратора!'
                                ]);
                            }
                            else
                            {
                                $bot->SendMessage($chat_id, ['text' =>
                                    'Здравствуйте ' . $user_name . '! Вы уже являетесь оператором сайта ' . $argument[0]
                                ]);
                            }
                        }
                        else
                        {
                            $bot->SendMessage($chat_id, ['text' =>
                                'Здравствуйте ' . $user_name . '! Сайта с именем ' . $argument[0] . ' не существует в нашей базе!'
                            ]);
                        }
                        break;

                    case 'помощь':
                        $bot->SendMessage($chat_id, ['text' =>
                            'Здравствуйте я бот компании Business link.
    Я помогу вам наладить связи между вами и вашими клиентами!'
                        ]);
                        break;
                    case '/help':
                        $bot->SendMessage($chat_id, ['text' =>
                            'Здравствуйте я бот компании Business link.
    Я помогу вам наладить связи между вами и вашими клиентами!'
                        ]);
                        break;
                    /*default:
                        $bot->SendMessage($chat_id, ['text' =>
                            'Здравствуйте я бот компании Business link.
    Я помогу вам наладить связи между вами и вашими клиентами!' .print_r($argument,true)
                        ]);
                        break;*/
                }

            }
        else
        {
            $this->SaveMessage(6, $data['message']['from']['id'], json_encode($data));
        }

        return false;
    }

    function screen($url, $razr, $razm, $form, $name)
    {
        $path=PUBLIC_PATH . DS . 'css' . DS.'cache'. DS.date('Y-m-d');
        mkdir($path, 0777,true);
        $toapi="http://mini.s-shot.ru/".$razr."/".$razm."/".$form."/?http://".$url;
        $scim=file_get_contents($toapi);
        file_put_contents(PUBLIC_PATH.'/css/cache/text.txt',$toapi);
        if($scim){
            file_put_contents($path.DS.$name.'.'.$form , $scim);
            return $path.DS.$name.'.'.$form;
        }
        else{
            $toapi="http://mini.s-shot.ru/".$razr."/".$razm."/".$form."/?https://".$url;
            $scim=file_get_contents($toapi);
            if ($scim){
            file_put_contents($path.DS.$name.'.'.$form , $scim);
            return $path.DS.$name.'.'.$form;
            }
            else{
                return false;
            }

        }

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

    
    function FindMessage($data)
    {
        $bot = new \app\telegram\MessageBot();
        $chat_id=$data['from']['id'];
        $username=$data['from']['username'];
        $full_name=$data['from']['first_name'].' '.$data['from']['last_name'];
        $message_id=$data['message']['message_id'];
        $message_text=$data['message']['text'];
        $message_data=$data['data'];
        $messageData=$this->db->select('site_message',
        [
        'site_message.*'
        ],
        [
            "site_message.key[~]" => '"chat_id":'.$chat_id.',"message_id":'.$message_id
        ]);
        $operators=json_decode($messageData[0]['key'],true);
        file_put_contents(PUBLIC_PATH.'/css/cache/text.txt',json_encode($data));
        if ($message_data=='approve=true'){
        foreach ($operators as $value){
                $bot->EditMessage($value['chat_id'],$value['message_id'],$message_text,'<strong>Заявка обработана! 
    
    '.$full_name.'</strong>
    @'.$username);
            }
            $this->db->update('site_message',['status'=>'completed','time_end'=>time()],['id'=>$messageData[0]['id']]);
        }
        if ($message_data=='approve=false'){
            foreach ($operators as $value){
                $bot->EditMessage($value['chat_id'],$value['message_id'],$message_text,'<strong>Отказ!!!
    
    '.$full_name.'</strong>
    @'.$username);
            }
            $this->db->update('site_message',['status'=>'renouncement','time_end'=>time()],['id'=>$messageData[0]['id']]);
        }

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

    public function GetSiteInfo($site,$date=false)
    {
        if ($date){
            switch (count($date))
            {
                case 1:
                    $date[1]=strtotime($date[1]);
                    $infoData = $this->db->count('site_message',
                        [
                            'site_message.*'
                        ],

                        [
                           'AND'=>[
                               "site_id" => $site['data'][0]['id'],
                               'time_start[>=]'=>$date[1],
                                ]
                        ]
                    );
                    $infoMessage = $this->db->query("select site_message.status, count(site_message.status) from site_message WHERE site_id={$site['data'][0]['id']} AND time_start>={$date[1]} GROUP BY site_message.status")->fetchAll(2);
                    break;

                case 2:
                    $date[1]=strtotime($date[1]);
                    $date[2]=strtotime($date[2]);
                    $infoData = $this->db->count('site_message',
                        [
                            'site_message.*'
                        ],

                        [
                            'AND'=>[
                                "site_id" => $site['data'][0]['id'],
                                'time_start[>=]'=>$date[1],
                                'time_start[<=]'=>$date[2],
                            ]
                        ]
                    );
                    $infoMessage = $this->db->query("select site_message.status, count(site_message.status) from site_message WHERE site_id={$site['data'][0]['id']} AND time_start>={$date[1]} AND time_start<={$date[2]} GROUP BY site_message.status")->fetchAll(2);
                    break;
            }
        }
        else {
            $infoData = $this->db->count('site_message',
                [
                    'site_message.*'
                ],

                [
                    "site_id" => $site['data'][0]['id']
                ]
            );
            $infoMessage = $this->db->query("select site_message.status, count(site_message.status) from site_message WHERE site_id={$site['data'][0]['id']} GROUP BY site_message.status")->fetchAll(2);
        }
        foreach ($infoMessage as $key => $value) {
            $title = '';
            switch ($value['status']) {
                case 'renouncement':
                    $title = '🚫Отказ';
                    break;
                case 'completed':
                    $title = '✅Завершенные';
                    break;
                case 'new':
                    $title = '🆕Необработанные';
                    break;
            }
            $value['title'] = $title;
            $infoMessage[$key] = $value;
        }
        $value['title'] = 'Все';
        $value['status'] = '';
        $value['count'] = $infoData;
        $infoMessage[] = $value;
        /*foreach ($infoData as $key => $data) {
            $infoData[$key]['geodata'] = json_decode($data['geodata'], true);
        }*/
        return [
//            'data' => $infoData,
            'MessageData' => $infoMessage,
        ];

    }

    function sendMessageText($data,$operator=-149637232)
    {
            $bot = new \app\telegram\Bot();
            $chat_id=$operator;
            $bot->SendMessage($chat_id,$data);
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

    function getOperators($site){
        $siteData = $this->db->select('operators',
            [
                'operators.*',
            ]
            ,
            [
                'AND'=>['site_id'=>$site,'approve'=>'true']
            ]
        );

        return [
            'data' => $siteData,
        ];
    }

    function getOperatorByID($id){
        $siteData = $this->db->select('operators',
            [
                'operators.*',
            ]
            ,
            [
                'id'=>$id
            ]
        );

        return $siteData;
    }

    function DelOperatorByID($id){
        $siteData = $this->db->delete('operators',
            [
                'id'=>$id
            ]
        );

        return $siteData;
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