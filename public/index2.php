<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 26.04.16
 * Time: 18:44
 */

$f_name='css/cache/text.txt';
file_put_contents($f_name,print_r($_POST,true));