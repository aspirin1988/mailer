<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 15.03.16
 * Time: 12:55
 */

namespace app\client\models;


use core\Models;

class callback extends Models
{
    public function Recall ($rest,$name)
    {
        $siteData = $this->db->select('site', [
            "[>]email" => ["email" => "id"]
        ],
            [
                'site.*',
                'email.login',
                'email.password',
                'email.port',
                'email.host',
            ],
            [
                'md5'=>$name
            ]
        );
        $this->save_message($rest);
        if ($siteData) {
            $Content= $this->db->select('site_options',
                [
                    'site_options.*',
                ],
                [
                    'site'=>$siteData[0]['id']
                ]
            );
            $Content=json_decode($Content[0]['text'],true);
            $suc_text=$Content['recall']['data']['suc_res_txt'];
            $err_text=$Content['recall']['data']['err_res_txt'];
            $str=file_get_contents(BASE_PATH.DS.'app'.DS.'client'.DS.'views'.DS.'recall.html'); //$this->db->insert('email_massage',$rest);
            $res=$this->image_replace($str);
            $image=$res['image'];
            $str=$res['str'];
            foreach ($rest as $key=>$value) {
                if ($key!='md5') $str=str_replace('{'.$key.'}',$value,$str);
            }
            $result =$this->send_smtp_html($str,[$siteData[0]['cc_mail']], 'TEST', $siteData[0],$image);
            if ($result[0]['code']){

                $result[0]['text']=$suc_text;
                $this->sendToOperatorRecall($siteData,$rest);
            }
            else
            {
                $result[0]['text']=$err_text;
            }
            return $result;
        }
        else
        {
            return [];
        }

    }

    public function Query ($rest,$name)
    {
        $siteData = $this->db->select('site', [
            "[>]email" => ["email" => "id"]
        ],
            [
                'site.*',
                'email.login',
                'email.password',
                'email.port',
                'email.host',
            ],
            [
                'md5'=>$name
            ]
        );
        $this->save_message($rest);
        if ($siteData) {
            $Content= $this->db->select('site_options',
                [
                    'site_options.*',
                ],
                [
                    'site'=>$siteData[0]['id']
                ]
            );
            $Content=json_decode($Content[0]['text'],true);
            $suc_text=$Content['message']['suc_res_txt'];
            $err_text=$Content['message']['err_res_txt'];
            $mail_c=file_get_contents(BASE_PATH.DS.'app'.DS.'client'.DS.'views'.DS.'mail_c.html'); //$this->db->insert('email_massage',$rest);
            //$mail_cc=file_get_contents(BASE_PATH.DS.'app'.DS.'client'.DS.'views'.DS.'mail_c.html'); //$this->db->insert('email_massage',$rest);
            $res=$this->image_replace($mail_c);
            $image=$res['image'];
            $mail_c=$res['str'];
            foreach ($rest as $key=>$value) {
                if ($key!='md5') $mail_c=str_replace('{'.$key.'}',$value,$mail_c);
            }
            $result1 =$this->send_smtp_html($mail_c,[$siteData[0]['cc_mail']], 'TEST', $siteData[0],$image);

            $mail_c=file_get_contents(BASE_PATH.DS.'app'.DS.'client'.DS.'views'.DS.'mail_cc.html'); //$this->db->insert('email_massage',$rest);
            //$mail_cc=file_get_contents(BASE_PATH.DS.'app'.DS.'client'.DS.'views'.DS.'mail_c.html'); //$this->db->insert('email_massage',$rest);
            $res=$this->image_replace($mail_c);
            $image=$res['image'];
            $mail_c=$res['str'];
            foreach ($rest as $key=>$value) {
                if ($key!='md5') $mail_c=str_replace('{'.$key.'}',$value,$mail_c);
            }
            $result2 =$this->send_smtp_html($mail_c,[$rest['email']], 'TEST', $siteData[0],$image);
            $result = array_merge($result1,$result2);
            if ($result[0]['code']){

                $result[0]['text']=$suc_text;
                $this->sendToOperatorQuery($siteData,$rest);
            }
            else
            {
                $result[0]['text']=$err_text;
            }
            return $result;
        }
        else
        {
            return [];
        }
    }

    public function SendForm ($rest,$name,$mute=false)
    {
        $approve=true;
        $siteData = $this->db->select('site', [
            "[>]email" => ["email" => "id"]
        ],
            [
                'site.*',
                'email.login',
                'email.password',
                'email.port',
                'email.host',
            ],
            [
                'md5'=>$name
            ]
        );
        $siteEmail = $this->db->select('site_approve_emails',
            [
                'site_approve_emails.*',
            ],
            [
                'site_id'=>$siteData[0]['id']
            ]
        );
        $emails=array();
        foreach ($siteEmail as $email)
        {
            $emails[]=$email['cc_mail'];
        }
        $emails[]=$siteData[0]['cc_mail'];


        if (isset($rest['cc_mail']))
        {
            if (in_array($rest['cc_mail'],$emails))
            {
                $siteData[0]['cc_mail']=$rest['cc_mail'];
                unset($rest['cc_mail']);
                $approve=true;
            }
            else
            {
                $approve=false;
            }

        }

        if ($siteData&&$approve) {
            $Content= $this->db->select('site_options',
                [
                    'site_options.*',
                ],
                [
                    'site'=>$siteData[0]['id']
                ]
            );
            $Content=json_decode($Content[0]['text'],true);
            $suc_text=$Content['recall']['data']['suc_res_txt'];
            $err_text=$Content['recall']['data']['err_res_txt'];
            $str=file_get_contents(BASE_PATH.DS.'app'.DS.'client'.DS.'views'.DS.'form.html'); //$this->db->insert('email_massage',$rest);
            $tr='';
            foreach ($rest as $key=>$value) {
              if ('title'!=$key)  {$tr.='
        <tr>
        <td style="border: 1px solid #e5e5e5; padding: 7px; font-family: \'Roboto Condensed\', sans-serif; background: #eee;" align="left">'.$key.'</td>
        <td style="border: 1px solid #e5e5e5; padding: 7px; font-family: \'Roboto Condensed\', sans-serif; background: #eee;" align="left">'.$value.'</td>
        </tr>';}

            }
            $str=str_replace('{tr}',$tr,$str);
            $result =$this->send_smtp_html($str,[$siteData[0]['cc_mail']], $rest['title'], $siteData[0],[]);
            if ($result[0]['code']){

                $result[0]['text']=$suc_text;
                if (!$mute) {
                    $this->sendToOperator($siteData, $rest);
                }

            }
            else
            {
                $result[0]['text']=$err_text;
            }
            return $result;
        }
        else
        {
            return [];
        }

    }

    public function SendFormTo ($rest,$name)
    {
        $siteData = $this->db->select('site', [
            "[>]email" => ["email" => "id"]
        ],
            [
                'site.*',
                'email.login',
                'email.password',
                'email.port',
                'email.host',
            ],
            [
                'md5'=>$name
            ]
        );
        if ($siteData) {
            $Content= $this->db->select('site_options',
                [
                    'site_options.*',
                ],
                [
                    'site'=>$siteData[0]['id']
                ]
            );
            $Content=json_decode($Content[0]['text'],true);
            $suc_text=$Content['recall']['data']['suc_res_txt'];
            $err_text=$Content['recall']['data']['err_res_txt'];
            $str=file_get_contents(BASE_PATH.DS.'app'.DS.'client'.DS.'views'.DS.'regform.html');
            //$this->db->insert('email_massage',$rest);
            $tr='';
            foreach ($rest as $key=>$value) {
                $str=str_replace('{'.$key.'}',$value,$str);

            }
            $result =$this->send_smtp_html($str,[$rest['email']], $rest['title'], $siteData[0],[]);
            if ($result[0]['code']){

                $result[0]['text']=$suc_text;
            }
            else
            {
                $result[0]['text']=$err_text;
            }
            return $result;
        }
        else
        {
            return [];
        }

    }

    function send_smtp_html($str,$email,$subject,$config,$image){
        $mail = new \library\mailer\PHPMailer();
        $to=array();

        $mail->setLanguage('ru', LIBRARY.'/mailer/language/');
        //$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $config['host'];  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $config['login'];                 // SMTP username
        $mail->Password = $config['password'];                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $config['port'];                                    // TCP port to connect to

        $mail->CharSet = "utf-8";
        $mail->From = $config['login'];
        $mail->FromName = $config['name'];
        $mail->addReplyTo($config['login'], $config['name']);
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $subject;
        $mail->Body    = $str;
        $mail->AltBody = htmlspecialchars_decode ($str);
        $mess=array();
        foreach ($image as $key => $value) {
            $mail->AddEmbeddedImage($value['url'], $value['cid'], $value['name'], 'base64', $value['mime']);
        }
        foreach($email as $key=>$value){
            $mail->addAddress($value);
            if(!$mail->send()) {
                $mess[$key]=(array('code'=>'0','text'=>'Message could not be sent.','email'=>$value, 'error'=>$mail->ErrorInfo)) ;
            } else {
                $mess[$key]=(array('code'=>'1','text'=>'Message has been sent','email'=>$value)) ;
            }
        }
        return $mess;
    }

    function sendToOperatorRecall($siteData,$rest)
    {
        $model = new \app\client\models\bot();
        $bot = new \app\telegram\MessageBot();
        $operators = $model->getOperators($siteData[0]['id']);
        $key_message=false;
        $return=[];

        $text='   Ваc просят перезвонить с сайта : <b>' . $siteData[0]['name'] . '</b>
    Клиент : '.$rest['fullname'].'
                    
        ☎️ <a href="tel:+'.$rest['phone'].'"> +'.$rest['phone'].'</a>
                    ';

        foreach ($operators['data'] as $operator){
            $return[] = $bot->SendMessage($operator['telegramm_id'],
                ['text' =>$text
                ],$model->CreateKeyboard('Ⓜ️Меню'));
        }
        foreach ($return as $message)
        {
            $key_message[]=['chat_id'=>$message['result']['chat']['id'],'message_id'=>$message['result']['message_id']];
        }

        $this->db->insert('site_message',['key'=>json_encode($key_message),'site_id'=>$siteData[0]['id'],'message'=>$text,'geodata'=>$this->GetLocation($_SERVER['REMOTE_ADDR']),'time_start'=>time()]);
    }

    function sendToOperatorQuery($siteData,$rest)
    {
        $model = new \app\client\models\bot();
        $bot = new \app\telegram\MessageBot();
        $operators = $model->getOperators($siteData[0]['id']);
        $key_message=false;
        $return=[];

        $text='   Вам пишут с вашего сайта : <b>' . $siteData[0]['name'] . '</b>
    Клиент : '.$rest['fullname'].'
    Текст сообщения: 
<strong>'. $rest['mess'].'</strong>
                    
        ☎️ <a href="tel:+'.$rest['phone'].'" > +'.$rest['phone'].'</a>
        📧️ <a href="   mailto:+'.$rest['email'].'" >'.$rest['email'].'</a>
                    ';

        foreach ($operators['data'] as $operator){
        $return[]=$bot->SendMessage($operator['telegramm_id'],
                ['text' =>$text],$model->CreateKeyboard('Ⓜ️Меню'));
        }
        foreach ($return as $message)
        {
            $key_message[]=['chat_id'=>$message['result']['chat']['id'],'message_id'=>$message['result']['message_id']];
        }
        $this->db->insert('site_message',['key'=>json_encode($key_message),'site_id'=>$siteData[0]['id'],'message'=>$text,'geodata'=>$this->GetLocation($_SERVER['REMOTE_ADDR']),'time_start'=>time()]);


    }

    function sendToOperator($siteData,$rest)
    {
        //if (!isset($rest['email'])) $rest['email']=' Не указан';
        $model = new \app\client\models\bot();
        $bot = new \app\telegram\MessageBot();
        $operators = $model->getOperators($siteData[0]['id']);
        $text='   На вашем сайте заполнена форма : <b>' . $siteData[0]['name'].'</b>
<b>Данные с формы:</b>
';

        foreach ($rest as $key=>$value)
        {   $tel=stristr($key,'телефон').stristr($key,'phone');
            if (!$tel)
            switch ($key)
            {
                case 'title':
                    $text .= 'Страница: <a href="' . $rest['URL'] . '">' . $value . '</a>
';
                    break;
                case 'URL':
                    break;
                default: $text .=$key.': '.$value.'
';
                    break;

            }
            else{

                    $text .= '☎️ <a href="tel:+'.$value.'" > +'.$value.'</a> 
';
                }
        }
        $key_message=false;
        $return=[];
        foreach ($operators['data'] as $operator){
            $return[] = $bot->SendMessage($operator['telegramm_id'],
                ['text' =>$text
                ],$model->CreateKeyboard('Ⓜ️Меню'));
        }
        foreach ($return as $message)
        {
            $key_message[]=['chat_id'=>$message['result']['chat']['id'],'message_id'=>$message['result']['message_id']];
        }
        $this->db->insert('site_message',['key'=>json_encode($key_message),'site_id'=>$siteData[0]['id'],'message'=>$text,'geodata'=>$this->GetLocation($_SERVER['REMOTE_ADDR']),'time_start'=>time()]);

    }

    function save_message($data)
    {
        return $this->db->insert('email_massage',$data);
    }

    function image_replace($str)
    {
        $url = explode('<img src="{host}',$str);
        $image='';
        unset($url[0]);
        foreach ($url as $key =>$value)
        {
            $i=stripos($value,'"');
            $src = substr($value,0,$i);
            $j=stripos($src,'.');
            $e=strripos($src,'/')+1;
            $cid = substr($src,$e,$j-$e);
            $type= substr($src,strripos($src,'.')+1,strlen($src));
            $mime= 'image/'.$type;

            $image[$key]=["url"=>PUBLIC_PATH.$src,'cid'=>$cid,'name'=>$cid.'.'.$type,'type'=>$type,'mime'=>$mime];
            $host ='{host}'.$src;
            $str=str_replace($host,'cid:'.$cid,$str);
        }
        return ['image'=>$image,'str'=>$str];
    }

    function GetLocation($ip)
    {
        header('Content-Type: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8');
        $url = 'http://ip-api.com/json/'.$ip;
        return file_get_contents($url);
    }
}