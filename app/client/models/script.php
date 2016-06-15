<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 15.03.16
 * Time: 12:54
 */

namespace app\client\models;


use core\Models;

class script extends Models
{
    public function Get($name)
    {
        if ( $this-> permission($name)['data'])
        {
            //print_r($_SERVER);
            return file_get_contents(LIBRARY.DS.'js/BlinkCB.min.js');
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