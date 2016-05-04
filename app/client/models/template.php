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
        $site=$this->permission($name);
        if ($site['data']) {
            $text =$this->getOptions($site['data'][0]['id']);
            $text=json_decode($text['data'][0]['text'],true);
            $path = CALLBACK . DS . 'html' . DS . 'index.html';
            $template = file_get_contents($path);
            foreach($text as $key => $value)
            {
                foreach($value as $key1 => $value1)
                {
                    $template = str_replace('{'.$key.':'.$key1.'}',$value1,$template);
                }

            }
            $template = str_replace('{css}', 'https'.HOST_NAME . DS . 'client' . DS . 'css' . DS . 'get'.DS , $template);
            $template = str_replace('{host}','https'.HOST_NAME, $template);
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

    function  getOptions($id)
    {
        $siteData = $this->db->select('site_options',
            [
                'site_options.*',
            ]
            ,
            [
                'site' => $id
            ]
        );

        return [
            'data' => $siteData,
        ];
    }
}