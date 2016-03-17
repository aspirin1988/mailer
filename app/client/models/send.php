<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 16.03.16
 * Time: 9:45
 */

// Если нужно показать лог SMTP-сессии, то можно раскомментировать следующую строчку.
//$_SERVER['debug'] = true;

function MailSmtp($reciever, $subject, $content, $headers, $debug = 0) {

    $smtp_server = 'smtp.gmail.com'; // адрес SMTP-сервера
    $smtp_port = 465; // порт SMTP-сервера
    $smtp_user = 'aspirins24@gmail.com'; // Имя пользователя для авторизации на SMTP-сервере
    $smtp_password = '26091988god'; // Пароль для авторизации на SMTP-сервере
    $mail_from = 'aspirins24@gmail.com'; // Ящик, с которого отправляется письмо

    $sock = fsockopen($smtp_server,$smtp_port,$errno,$errstr,30);

    $str = fgets($sock,512);
    if (!$sock) {
        printf("Socket is not created\n");
        exit(1);
    }

    smtp_msg($sock, "HELO " . $_SERVER['SERVER_NAME']);
    smtp_msg($sock, "AUTH LOGIN");
    smtp_msg($sock, base64_encode($smtp_user));
    smtp_msg($sock, base64_encode($smtp_password));
    smtp_msg($sock, "MAIL FROM: <" . $mail_from . ">");
    smtp_msg($sock, "RCPT TO: <" . $reciever . ">");
    smtp_msg($sock, "DATA");

    $headers = "Subject: " . $subject . "\r\n" . $headers;

    $data = $headers . "\r\n\r\n" . $content . "\r\n.";

    smtp_msg($sock, $data);
    smtp_msg($sock, "QUIT");

    fclose($sock);
}


function smtp_msg($sock, $msg) {

    if (!$sock) {
        printf("Broken socket!\n");
        exit(1);
    }

    if (isset($_SERVER['debug']) && $_SERVER['debug']) {
        printf("Send from us: %s<BR>", nl2br(htmlspecialchars($msg)));
    }
    fputs($sock, "$msg\r\n");
    $str = fgets($sock, 512);
    if (!$sock) {
        printf("Socket is down\n");
        exit(1);
    }
    else {
        if (isset($_SERVER['debug']) && $_SERVER['debug']) {
            printf("Got from server: %s<BR>", nl2br(htmlspecialchars($str)));
        }

        $e = explode(" ", $str);
        $code = array_shift($e);
        $str = implode(" ", $e);

        if ($code > 499) {
            printf("Problems with SMTP conversation.<BR><BR>Code %d.<BR>Message %s<BR>", $code, $str);
            exit(1);
        }
    }
}




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