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
        $this->db->insert('email_massage',$rest);
        return $this->send_smtp_html('ergjroeger',[],['aspirin_1988@mail.ru'],'TEST',['email'=>'system@jpplayer.su','name'=>'system@jpplayer.su']);
    }

    public function Query ($rest)
    {

        return $rest['md5'];
    }

    function send_smtp_html($str,$data,$email,$subject,$from){
        foreach ($data as $key=>$value) {
            $str = str_replace('{"'.$key.'"}',''.$value.'',$str);
        }
        //echo $email;
        //include_once(LIB_PATH.'/mailer/PHPMailerAutoload.php');
        //require '';

        $mail = new \library\mailer\PHPMailer();
        $to=array();

        $mail->setLanguage('ru', LIBRARY.'/mailer/language/');
        //$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.yandex.ru';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'system@jpplayer.su';                 // SMTP username
        $mail->Password = 'resident99';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        $mail->CharSet = "utf-8";
        $mail->From = $from['email'];
        $mail->FromName = $from['name'];
        $mail->addReplyTo('system@jpplayer.su', 'Jpplayer.su');
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