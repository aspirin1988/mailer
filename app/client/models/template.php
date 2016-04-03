<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 15.03.16
 * Time: 12:54
 */

namespace app\client\models;


use core\Models;

class template extends Models
{
    public function Get($name, $style)
    {
        $name='';
        if ($_SERVER['HTTP_REFERER'])
        {
            $name=md5($_SERVER['HTTP_REFERER']);
        }
        else
        {
            $name=md5($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/');
        }
        if ($this->permission($name)['data']) {

            $path = CALLBACK . DS . 'html' . DS . 'index.html';
            $template = file_get_contents($path);
            $template = str_replace('{css}', 'http'.HOST_NAME . DS . 'client' . DS . 'css' . DS . 'get'.DS.$name.DS.$style , $template);
            $template = str_replace('{host}','http'.HOST_NAME, $template);
            $template = str_replace('{md5}',$name, $template);
            return $template;
        } else {
            return false;
        }
    }

    function permission($name)
    {
        $siteData = $this->db->select('site',
            [
                'site.*',
            ]
            ,
            [
                'md5' => $name
            ]
        );

        return [
            'data' => $siteData,
        ];
    }
}