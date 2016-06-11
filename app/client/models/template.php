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
            $data =$this->getOptions($site['data'][0]['id']);
            $text=json_decode($data['data'][0]['text'],true);
            $widgets = json_decode($data['data'][0]['widgets'],true);
            $path = CALLBACK . DS . 'html' . DS . 'index.html';
            print_r($widgets);
            $template = file_get_contents($path);

            foreach($widgets as $key => $value)
            {
                foreach($value as $key1 => $value1) {
                    if ($value1=='true') {
                        $path = CALLBACK . DS . 'html' . DS . 'widgets' . DS . $key1 . '-popup-btn.html';
                        $popup = file_get_contents($path);
                        $template = str_replace('{widgets:' . $key1 . '-popup-btn}', $popup, $template);

                        $path = CALLBACK . DS . 'html' . DS . 'widgets' . DS . $key1 . '-main-widgets.html';
                        $widgets = file_get_contents($path);
                        $template = str_replace('{widgets:' . $key1 . '-main-widgets}', $widgets, $template);

                        $path = CALLBACK . DS . 'html' . DS . 'widgets' . DS . $key1 . '-main-icon.html';
                        $icon = file_get_contents($path);
                        $template = str_replace('{widgets:' . $key1 . '-main-icon}', $icon, $template);



                    }
                    else
                    {
                        $popup = '';
                        $template = str_replace('{widgets:' . $key1 . '-popup-btn}', $popup, $template);
                        $widgets = '';
                        $template = str_replace('{widgets:' . $key1 . '-main-widgets}', $widgets, $template);
                        $icon = '';
                        $template = str_replace('{widgets:' . $key1 . '-main-icon}', $icon, $template);

                    }
                }

            }

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