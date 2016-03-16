<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 16.03.16
 * Time: 9:45
 */




/*function send_smtp_html($str,$data,$email,$subject,$from){
    foreach ($data as $key=>$value) {
        $str = str_replace('{"'.$key.'"}',''.$value.'',$str);
    }
    //include_once(LIBRARY.'/mailer/PHPMailerAutoload.php');
    echo $email;
    $mail = new library\Mail();
    $to=array();

    //$mail->SMTPDebug = 3;                               // Enable verbose debug output

    $mail->smtp_hostname = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->smtp_username = 'aspirins24@gmail.com';                 // SMTP username
    $mail->smtp_password = '26091988god';                           // SMTP password
    $mail->smtp_port = 465;                                    // TCP port to connect to

    $mail->setFrom('aspirins24@gmail.com');
    $mail->setTo('aspirins24@gmail.com');
    $mail->setSender('aspirins24@gmail.com');

    $mail->setSubject ($subject);
    $mail->setHtml($str);
    $mail->setText('blalbabla');
    $mail->send();
}*/