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
    public function Get($name,$style)
    {
        if ($this->permission($name)['data'])
        {
            !is_null($style) ?:  $style = 'style';
            $path=CALLBACK.DS.'html'.DS.'index.html';
            $template = file_get_contents($path);
            $template=str_replace('{css}',HOST_NAME.DS.'resources'.DS.'callback'.DS.'css'.DS.$style.'.css',$template);
            return $template;
        }
        else
        {
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
                'md5'=>$name
            ]
        );

        return [
            'data' => $siteData,
        ];
    }
}