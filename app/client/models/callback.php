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
    public function Recall ($rest)
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
                'md5'=>$rest['md5']
            ]
        );
        if ($siteData) {
            $str=file_get_contents(BASE_PATH.DS.'app'.DS.'client'.DS.'views'.DS.'mail.html'); //$this->db->insert('email_massage',$rest);
            $content='';
            foreach ($rest as $key=>$value) {
                if ($key!='md5') $content .='<tr style="border: 1px solid black;text-align: center;padding: 4px;"><td style="border: 1px solid black;text-align: center;padding: 4px;">'.$key.'</td><td style="border:solid 1px">'.$value.'</td></tr>';
            }

            $this->send_smtp_html($str, $content, [$siteData[0]['cc_mail']], 'TEST', ['email' => 'system@jpplayer.su', 'name' => 'system@jpplayer.su'],$siteData[0]);
        }
        else
        {
            $siteData='Error no site';
        }
        return $siteData;
    }

    public function Query ($rest)
    {

        return $rest['md5'];
    }

    function send_smtp_html($str,$data,$email,$subject,$from,$config){

        $str = str_replace('{data}',''.$data.'',$str);
        //echo $email;
        //include_once(LIB_PATH.'/mailer/PHPMailerAutoload.php');
        //require '';

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
        foreach($email as $key=>$value){
            $mail->addAddress($value);
            if(!$mail->send()) {
                $mess[$key]=(array('code'=>'0','text'=>'Message could not be sent.','email'=>$value, 'error'=>$mail->ErrorInfo,'email'=>$email)) ;
            } else {
                $mess[$key]=(array('code'=>'1','text'=>'Message has been sent','email'=>$value)) ;
            }
        }
        return $mess;
    }

}