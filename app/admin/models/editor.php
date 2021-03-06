<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 07.04.16
 * Time: 16:45
 */

namespace app\admin\models;


use core\Models;

class editor extends Models
{
    function GetServices()
    {
        $siteData = $this->db->select('services',
            [
                'services.*'
            ]
        );

        return [
            'data' => $siteData,
        ];
    }

    function GetOptions($id)
        {
            $siteData = $this->db->select('site_options',
                [
                    "[>]template_site" => ["template" => "id"],
                    "[>]site" => ["site" => "id"]
                ],
                [
                    'site_options.*','site.name','template_site.name(t_name)','template_site.directory'
                ],
                [
                    'site'=>$id,
                ]
            );
            if ($siteData)
            {
                unset($siteData[0]['options']);
                unset($siteData[0]['text']);
                $siteData[0]['options_default']=json_decode( $siteData[0]['options_default'],true);
                $siteData[0]['text_default']=json_decode( $siteData[0]['text_default'],true);
                $siteData[0]['widgets']=json_decode( $siteData[0]['widgets'],true);
            }
            return $siteData[0];
        }

    function SetOptions($id,$value)
        {
            $data = [
                'id' => 1,
                'template' => 1,
                'color' => [
                    'default' => [
                        'm_cl' => "#393f48",
                        'm_cl_br' => "#434a54",
                        'h_f_cl' => "#fff",
                        'f_f_cl' => "#e2e3e7",
                        'sub_btn_cl' => "#cf5664",
                        'sub_btn_cl_hover' => "#a7424e",
                        'fields_f_cl' => "#e2e3e7",
                        'fields_bg_cl' => "#434a54",
                        'fields_br_cl' => "#e2e3e7",
                        'res_suc_bg_cl' => "#e2e3e7",
                        'res_err_bg_cl' => "#e2e3e7",
                        'res_suc_f_cl' => "#3c763d",
                        'res_err_f_cl' => "#a94442",
                        'res_suc_btn_f_cl' => "#e2e3e7",
                        'res_err_btn_f_cl' => "#ffffff",
                        'res_suc_btn_bg_cl' => "#3c763d",
                        'res_err_btn_bg_cl' => "#a94442",
                        'main_btn_f_cl' => "#e2e3e7",
                        'main_btn_bg_cl' => "#393f48",
                        'main_btn_sel_cl' => "#cf5664",
                        'main_btn_hover_cl' => "#cf5664",
                    ],
                    'custom' => [
                        'm_cl' => "#ffffff",
                        'm_cl_br' => "#ffffff",
                        'h_f_cl' => "#ffffff",
                        'f_f_cl' => "#ffffff",
                        'sub_btn_cl' => "#ffffff",
                        'sub_btn_cl_hover' => "#ffffff",
                        'fields_f_cl' => "#ffffff",
                        'fields_bg_cl' => "#ffffff",
                        'fields_br_cl' => "#ffffff",
                        'res_suc_bg_cl' => "#ffffff",
                        'res_err_bg_cl' => "#ffffff",
                        'res_suc_f_cl' => "#ffffff",
                        'res_err_f_cl' => "#ffffff",
                        'res_suc_btn_f_cl' => "#ffffff",
                        'res_err_btn_f_cl' => "#ffffff",
                        'res_suc_btn_bg_cl' => "#ffffff",
                        'res_err_btn_bg_cl' => "#ffffff",
                        'main_btn_f_cl' => "#ffffff",
                        'main_btn_br_cl' => "#ffffff"
                    ],
                    'custom1' => [
                        'm_cl' => "#ffffff",
                        'm_cl_br' => "#ffffff",
                        'h_f_cl' => "#ffffff",
                        'f_f_cl' => "#ffffff",
                        'sub_btn_cl' => "#ffffff",
                        'sub_btn_cl_hover' => "#ffffff",
                        'fields_f_cl' => "#ffffff",
                        'fields_bg_cl' => "#ffffff",
                        'fields_br_cl' => "#ffffff",
                        'res_suc_bg_cl' => "#ffffff",
                        'res_err_bg_cl' => "#ffffff",
                        'res_suc_f_cl' => "#ffffff",
                        'res_err_f_cl' => "#ffffff",
                        'res_suc_btn_f_cl' => "#ffffff",
                        'res_err_btn_f_cl' => "#ffffff",
                        'res_suc_btn_bg_cl' => "#ffffff",
                        'res_err_btn_bg_cl' => "#ffffff",
                        'main_btn_f_cl' => "#ffffff",
                        'main_btn_br_cl' => "#ffffff"
                    ]
                ],
                'text' => [
                    'recall' => [
                        'h_txt' => "Lorem ipsum.",
                        'f_txt' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab, rem.",
                        'sb_txt' => "Lorem ipsum.",
                        'icon_txt' => "Lorem ipsum.",
                        'suc_res_txt' => "Lorem ipsum.",
                        'err_res_txt' => "Lorem ipsum.",
                        'suc_btn_txt' => "Lorem ipsum.",
                        'err_btn_txt' => "Lorem ipsum."
                    ],
                    'message' => [
                        'h_txt' => "Lorem ipsum.",
                        'f_txt' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab, rem.",
                        'sb_txt' => "Lorem ipsum.",
                        'icon_txt' => "Lorem ipsum.",
                        'suc_res_txt' => "Lorem ipsum.",
                        'err_res_txt' => "Lorem ipsum.",
                        'suc_btn_txt' => "Lorem ipsum.",
                        'err_btn_txt' => "Lorem ipsum."
                    ],
                    'chat' => [
                        'h_txt' => "Lorem ipsum.",
                        'f_txt' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab, rem.",
                        'sb_txt' => "Lorem ipsum.",
                        'icon_txt' => "Lorem ipsum.",
                        'suc_res_txt' => "Lorem ipsum.",
                        'err_res_txt' => "Lorem ipsum.",
                        'suc_btn_txt' => "Lorem ipsum.",
                        'err_btn_txt' => "Lorem ipsum."
                    ]
                ],
                'site' => 4,
                'services' => null
            ];
            $siteData = $this->db->select('site_options',
                [
                    "[>]template_site" => ["template" => "id"]
                ],
                [
                    'site_options.*','template_site.name(t_name)','template_site.directory'
                ],
                [
                    'site'=>$id,
                ]
            );
            if ($siteData)
            {
                unset($siteData[0]['options']);
                $siteData[0]['options_default']=json_decode( $siteData[0]['options_default'],true);

                    $siteData = array_merge($siteData[0], $data);

                return $siteData;
            }
            return false;
        }

    function GetEditCSS($id,$value)
    {
        /*$data = [
            'class'=>'main-container',
            'inner_text'=>false,
            'outer_text'=>'Подложка',
            'style'=>[
                [
                    'key'=>'background-color',
                    'outer_text'=>'Цвет фона',
                    'value'=>'#eee',
                    'editable'=>true,
                    'removable'=>false,
                ],
                [
                    'key'=>'border-color',
                    'outer_text'=>'Цвет обводки',
                    'value'=>'#fafafa',
                    'editable'=>true,
                    'removable'=>false,
                ],
                [
                    'key'=>'color',
                    'outer_text'=>'Цвет шрифта',
                    'value'=>'#ffa500',
                    'editable'=>true,
                    'removable'=>false,
                ],
                [
                    'key'=>'border-radius',
                    'outer_text'=>'Цвет шрифта',
                    'value'=>'5px',
                    'editable'=>false,
                    'removable'=>false,
                ],

            ]
        ];*/

        $data=$value;
        $siteData = $this->db->select('site_options',
            [
                "[>]template_site" => ["template" => "id"]
            ],
            [
                'site_options.*','template_site.name(t_name)','template_site.directory'
            ],
            [
                'site' => $id,
            ]
        );

        if ($siteData) {
            $siteData[0]['options'] = json_decode($siteData[0]['options'], true);
            $siteData[0]['options_default'] = json_decode($siteData[0]['options_default'], true);
            if($data) {
                $siteData = array_merge($siteData[0], $data);
                $vl['options_default']=$data['options_default'];
                $vl['text_default']=$data['text_default'];
                $vl['widgets']=json_encode($data['widgets']);
                $this->UpdateConfig($id,$vl);
            }
            else
            {
                $siteData=$siteData[0];
            }

            //$path = PUBLIC_PATH . DS . 'resources' . DS . 'callback' . DS . 'css' . DS . 'blink-sb-edit.css';

            $res =''; //file_get_contents($path);

            foreach ($siteData['options_default']['css'] as $key=>$val) {
                $res.=$val['class'].'{';
                foreach($val['config'] as $key1=>$val1)
                {
                    $res.=$val1['key'].":".$val1['value'].';';
                }
                $res.='}';
                //$res=str_replace('{'.$key.'}',$val.'/*edit*/',$res);
            }

            return $res. ' '. $siteData['options_default']['media'];
        }
        return false;
    }

    function GetEditContent($id,$value)
        {
            /*$data = [
                'class'=>'main-container',
                'inner_text'=>false,
                'outer_text'=>'Подложка',
                'style'=>[
                    [
                        'key'=>'background-color',
                        'outer_text'=>'Цвет фона',
                        'value'=>'#eee',
                        'editable'=>true,
                        'removable'=>false,
                    ],
                    [
                        'key'=>'border-color',
                        'outer_text'=>'Цвет обводки',
                        'value'=>'#fafafa',
                        'editable'=>true,
                        'removable'=>false,
                    ],
                    [
                        'key'=>'color',
                        'outer_text'=>'Цвет шрифта',
                        'value'=>'#ffa500',
                        'editable'=>true,
                        'removable'=>false,
                    ],
                    [
                        'key'=>'border-radius',
                        'outer_text'=>'Цвет шрифта',
                        'value'=>'5px',
                        'editable'=>false,
                        'removable'=>false,
                    ],

                ]
            ];*/

            $data=$value;

            $siteData = $this->db->select('site_options',
                [
                    "[>]template_site" => ["template" => "id"]
                ],
                [
                    'site_options.*','template_site.name(t_name)','template_site.directory'
                ],
                [
                    'site' => $id,
                ]
            );

            if ($siteData) {
                $siteData[0]['text'] = json_decode($siteData[0]['text'], true);
                $siteData[0]['text_default'] = json_decode($siteData[0]['text_default'], true);
                if($data) {
                    $siteData = array_merge($siteData[0], $data);
                    $vl['text_default']=$data['text_default'];
                    $this->UpdateConfig($id,$vl);
                }
                else
                {
                    $siteData=$siteData[0];
                }

                return $siteData['text_default'];
            }
            return false;
        }

    function SaveConfig($id)
    {
        $result = $this->db->query('update site_options set "text"="text_default","options"="options_default" where "site"=' . $id)->fetchAll();
        if ($result) {
            $siteData = $this->db->select('site',
                [
                    "[>]site_options" => ["id" => "site"],
                ],
                [
                    'site.md5', 'site_options.*'
                ],
                [
                    'site.id' => $id,
                ]
            );
            $siteData[0]['options'] = json_decode($siteData[0]['options'], true);
            $siteData = $siteData[0];
            $res = '';
            $path = PUBLIC_PATH . DS . 'css' . DS . 'cache' . DS . 'blink-sb-' . $siteData['md5'] . 'style.css';
            foreach ($siteData['options']['css'] as $key => $val) {
                $res .= $val['class'] . '{';
                foreach ($val['config'] as $key1 => $val1) {
                    $res .= $val1['key'] . ":" . $val1['value'] . ';';
                }
                $res .= '}';
            }
            file_put_contents($path, $res.' '.$siteData['options']['media'] );


        }
        return $this->GetEditCSS($id, array());
    }

    function CancelConfig($id)
    {
        $result = $this->db->query('update site_options set "text_default"="text","options_default"="options" where "site"='.$id)->fetchAll();

        return $this->GetEditCSS($id, array());

    }



    function UpdateConfig($id,$value)
    {
        unset($value['options']);
        unset($value['text']);
        $value['options_default']=json_encode($value['options_default']);
        $value['text_default']=json_encode($value['text_default']);
        //print_r($value);
        $siteData = $this->db->update('site_options',$value,['site'=>$id]);
        return $siteData;
    }


}