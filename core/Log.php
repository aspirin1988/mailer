<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 16.02.2016
 * Time: 14:53
 */

namespace core;


/**
 * Лог
 * Class Log
 * @package core
 */
class Log
{

    /**
     * Добавить запись в лог файл
     * @param $message
     */
    public function write($message,$filename = null)
    {
        if (is_null($filename)) {
            $path = LOG_PATH . DS . 'log.txt';
        } else {
            $path = LOG_PATH . DS . $filename;
        }
        file_put_contents($path,date('Y-m-d G:i:s') . ' - ' . print_r($message, true) . "\n",FILE_APPEND | LOCK_EX);
    }

}