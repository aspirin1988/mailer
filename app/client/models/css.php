<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 17.03.16
 * Time: 14:14
 */

namespace app\client\models;


use core\Models;

class css extends Models
{
    public function Get($name,$style)
    {
        if ( $this-> permission($name)['data'])
        {
            //print_r($_SERVER);
            $path = PUBLIC_PATH . DS . 'resources' . DS . 'callback' . DS . 'css' . DS . 'blink-sb-'.$style . '.css';
            if (!file_exists($path)) {
                $style = 'style';
            }
            $path = PUBLIC_PATH.DS.'resources'.DS.'callback'.DS.'css'.DS.'blink-sb-'.$style.'.css';
            return file_get_contents($path);
        }
        else
        {
            return false;
        }
    }

    //Проверка на существование данного сайта и истечение срока его подписки
    function permission($name)
    {
        $siteData = $this->db->select('site',
            [
                'site.*',
            ]
            ,
            [
                'md5'=>$name
            ]
        );

        return [
            'data' => $siteData,
        ];
    }

}