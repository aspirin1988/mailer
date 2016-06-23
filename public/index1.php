<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 21.06.16
 * Time: 18:39
 */

$message=file_get_contents('php://input');
file_put_contents('css/cache/text.txt',json_encode($message,true));
echo true;