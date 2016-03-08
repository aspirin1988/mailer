<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 19.02.2016
 * Time: 14:51
 */

namespace library;


use core\Database;

class Helper
{
    /**
     * Принимает массив и ключь массива на сущестование и на пустату
     * или
     * Принимает строку на пустату
     * @param $data (array, string)
     * @param  $key
     * @return bool
     */
    public static function NotEmpty($data, $key=null)
    {
        if(is_array($data) && !is_null($key)){
            return (array_key_exists($key,$data) && !empty($data[$key]));
        } else {
            return !empty($data);
        }
    }

}