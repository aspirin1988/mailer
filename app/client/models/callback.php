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
            $str=file_get_contents(BASE_PATH.DS.'app'.DS.'client'.DS.'views'.DS.'recall.html'); //$this->db->insert('email_massage',$rest);
            //$str=str_replace('{host}',HOST_NAME,$str);
            //$image = file_get_contents(PUBLIC_PATH.DS.'resources'.DS.'callback'.DS.'images'.DS.'mail'.DS.'001.png');

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
            //$str=str_replace('{001}','src="data:image/png;base64,'.base64_encode($image).'"',$str);
            foreach ($rest as $key=>$value) {
                if ($key!='md5') $str=str_replace('{'.$key.'}',$value,$str);
            }
            $result =$this->send_smtp_html($str,[$siteData[0]['cc_mail']], 'TEST', $siteData[0],$image);
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
            $str=file_get_contents(BASE_PATH.DS.'app'.DS.'client'.DS.'views'.DS.'recall.html'); //$this->db->insert('email_massage',$rest);
            //$str=str_replace('{host}',HOST_NAME,$str);
            //$image = file_get_contents(PUBLIC_PATH.DS.'resources'.DS.'callback'.DS.'images'.DS.'mail'.DS.'001.png');

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
            //$str=str_replace('{001}','src="data:image/png;base64,'.base64_encode($image).'"',$str);
            foreach ($rest as $key=>$value) {
                if ($key!='md5') $str=str_replace('{'.$key.'}',$value,$str);
            }
            $result =$this->send_smtp_html($str,[$siteData[0]['cc_mail']], 'TEST', $siteData[0],$image);
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

    function save_message($data)
    {
        return $this->db->insert('email_massage',$data);
    }

}