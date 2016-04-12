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
/*        if ( $this-> permission($name)['data'])
        {
            //print_r($_SERVER);
            $path = PUBLIC_PATH . DS . 'resources' . DS . 'callback' . DS . 'css' . DS . 'blink-sb-'.$style . '.css';
            if (!file_exists($path)) {
                $style = 'style';
            }*/
//            $path = PUBLIC_PATH.DS.'resources'.DS.'callback'.DS.'css'.DS.'blink-sb-'.$style.'.css';

//            $data = [
//                'id' => 1,
//                'template' => 1,
//                'color' => [
//                    'default' => [
//                        'm_cl' => "#393f48",
//                        'm_cl_br' => "#434a54",
//                        'h_f_cl' => "#fff",
//                        'f_f_cl' => "#e2e3e7",
//                        'sub_btn_cl' => "#cf5664",
//                        'sub_btn_cl_hover' => "#a7424e",
//                        'fields_f_cl' => "#e2e3e7",
//                        'fields_bg_cl' => "#434a54",
//                        'fields_br_cl' => "#e2e3e7",
//                        'res_suc_bg_cl' => "#e2e3e7",
//                        'res_err_bg_cl' => "#e2e3e7",
//                        'res_suc_f_cl' => "#3c763d",
//                        'res_err_f_cl' => "#a94442",
//                        'res_suc_btn_f_cl' => "#e2e3e7",
//                        'res_err_btn_f_cl' => "#ffffff",
//                        'res_suc_btn_bg_cl' => "#3c763d",
//                        'res_err_btn_bg_cl' => "#a94442",
//                        'main_btn_f_cl' => "#e2e3e7",
//                        'main_btn_bg_cl' => "#393f48",
//                        'main_btn_sel_cl' => "#cf5664",
//                        'main_btn_hover_cl' => "#cf5664",
//                    ],
//                    'custom' => [
//                        'm_cl' => "#ffffff",
//                        'm_cl_br' => "#ffffff",
//                        'h_f_cl' => "#ffffff",
//                        'f_f_cl' => "#ffffff",
//                        'sub_btn_cl' => "#ffffff",
//                        'sub_btn_cl_hover' => "#ffffff",
//                        'fields_f_cl' => "#ffffff",
//                        'fields_bg_cl' => "#ffffff",
//                        'fields_br_cl' => "#ffffff",
//                        'res_suc_bg_cl' => "#ffffff",
//                        'res_err_bg_cl' => "#ffffff",
//                        'res_suc_f_cl' => "#ffffff",
//                        'res_err_f_cl' => "#ffffff",
//                        'res_suc_btn_f_cl' => "#ffffff",
//                        'res_err_btn_f_cl' => "#ffffff",
//                        'res_suc_btn_bg_cl' => "#ffffff",
//                        'res_err_btn_bg_cl' => "#ffffff",
//                        'main_btn_f_cl' => "#ffffff",
//                        'main_btn_br_cl' => "#ffffff"
//                    ],
//                    'custom1' => [
//                        'm_cl' => "#ffffff",
//                        'm_cl_br' => "#ffffff",
//                        'h_f_cl' => "#ffffff",
//                        'f_f_cl' => "#ffffff",
//                        'sub_btn_cl' => "#ffffff",
//                        'sub_btn_cl_hover' => "#ffffff",
//                        'fields_f_cl' => "#ffffff",
//                        'fields_bg_cl' => "#ffffff",
//                        'fields_br_cl' => "#ffffff",
//                        'res_suc_bg_cl' => "#ffffff",
//                        'res_err_bg_cl' => "#ffffff",
//                        'res_suc_f_cl' => "#ffffff",
//                        'res_err_f_cl' => "#ffffff",
//                        'res_suc_btn_f_cl' => "#ffffff",
//                        'res_err_btn_f_cl' => "#ffffff",
//                        'res_suc_btn_bg_cl' => "#ffffff",
//                        'res_err_btn_bg_cl' => "#ffffff",
//                        'main_btn_f_cl' => "#ffffff",
//                        'main_btn_br_cl' => "#ffffff"
//                    ]
//                ],
//                'text' => [
//                    'recall' => [
//                        'h_txt' => "Lorem ipsum.",
//                        'f_txt' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab, rem.",
//                        'sb_txt' => "Lorem ipsum.",
//                        'icon_txt' => "Lorem ipsum.",
//                        'suc_res_txt' => "Lorem ipsum.",
//                        'err_res_txt' => "Lorem ipsum.",
//                        'suc_btn_txt' => "Lorem ipsum.",
//                        'err_btn_txt' => "Lorem ipsum."
//                    ],
//                    'message' => [
//                        'h_txt' => "Lorem ipsum.",
//                        'f_txt' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab, rem.",
//                        'sb_txt' => "Lorem ipsum.",
//                        'icon_txt' => "Lorem ipsum.",
//                        'suc_res_txt' => "Lorem ipsum.",
//                        'err_res_txt' => "Lorem ipsum.",
//                        'suc_btn_txt' => "Lorem ipsum.",
//                        'err_btn_txt' => "Lorem ipsum."
//                    ],
//                    'chat' => [
//                        'h_txt' => "Lorem ipsum.",
//                        'f_txt' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab, rem.",
//                        'sb_txt' => "Lorem ipsum.",
//                        'icon_txt' => "Lorem ipsum.",
//                        'suc_res_txt' => "Lorem ipsum.",
//                        'err_res_txt' => "Lorem ipsum.",
//                        'suc_btn_txt' => "Lorem ipsum.",
//                        'err_btn_txt' => "Lorem ipsum."
//                    ]
//                ],
//                'site' => 4,
//                'services' => null
//            ];
//            $siteData = $this->db->select('site_options',
//                [
//                    "[>]template_site" => ["template" => "id"]
//                ],
//                [
//                    'site_options.*','template_site.name(t_name)','template_site.directory'
//                ],
//                [
//                    'site' => 4,
//                ]
//            );
//            if ($siteData) {
//                $siteData[0]['color'] = json_decode($siteData[0]['color'], true);
//                $siteData[0]['text'] = json_decode($siteData[0]['text'], true);
//                $siteData=array_merge($siteData[0],$data);
//
//
//                $path = PUBLIC_PATH . DS . 'resources' . DS . 'callback' . DS . 'css' . DS . 'blink-sb-edit.css';
//                $res = file_get_contents($path);
//
//                foreach ($siteData['color'][$siteData['directory']] as $key=>$val) {
//                    $res=str_replace('{'.$key.'}',$val.'/*edit*/',$res);
//                    //echo $key.''.$val;
//                    //if ($key='m_cl_br') echo 111;
//                }

//            file_get_contents($path);

        if ( $this-> permission($name)['data']) {
            $path = PUBLIC_PATH . DS . 'css' . DS . 'cache' . DS . 'blink-sb-' . $name . 'style.css';
            if (!file_exists($path)) {
                $siteData = $this->db->select('site',
                    [
                        "[>]site_options" => ["id" => "site"],
                    ],
                    [
                        'site_options.*'
                    ],
                    [
                        'md5' => $name,
                    ]
                );

                if ($siteData) {
                    $siteData[0]['options'] = json_decode($siteData[0]['options'], true);
                    $siteData[0]['options_default'] = json_decode($siteData[0]['options_default'], true);
                    $siteData = $siteData[0];
                }
                $res = ''; //file_get_contents($path);

                foreach ($siteData['options'] as $key => $val) {
                    $res .= $val['class'] . '{';
                    foreach ($val['config'] as $key1 => $val1) {
                        $res .= $val1['key'] . ":" . $val1['value'] . ';';
                    }
                    $res .= '}';
                }
                file_put_contents($path,$res);
                return $res;
            }
            else
            {
                $res='@import "https'.HOST_NAME . DS . 'css' . DS . 'cache' . DS . 'blink-sb-' . $name . 'style.css"';
                return $res;
            }
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