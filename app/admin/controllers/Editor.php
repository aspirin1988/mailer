<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 07.04.16
 * Time: 16:45
 */

namespace app\admin\controllers;


use core\Controller;

class Editor extends Controller
{

    function GetServices()
    {
        $model = new \app\admin\models\editor();
        $this->response->json($model->GetServices());
    }

    function GetOptions($id)
    {

        $model = new \app\admin\models\editor();
        $this->response->json($model->GetOptions($id));
    }

    function SetOptions($id)
    {
        $value=$this->request->rest();
        $model = new \app\admin\models\editor();
        $this->response->json($model->SetOptions($id,$value));
    }

    function GetEditCSS($id)
    {
        $value=$this->request->rest();
        $model = new \app\admin\models\editor();
        $this->response->css($model->GetEditCSS($id,$value));
    }

    function GetEditContent($id)
    {
        $value=$this->request->rest();
        $model = new \app\admin\models\editor();
        $this->response->json($model->GetEditContent($id,$value));
    }




    function GetArray()
    {
        $str = file_get_contents(PUBLIC_PATH . DS . 'resources' . DS . 'callback' . DS . 'css' . DS . 'default'.DS.'default.css');
//        $str = file_get_contents(PUBLIC_PATH . DS . 'libs' . DS . 'bootstrap' . DS . 'css' . DS .'bootstrap.min.css');
        $str=str_replace('\r','',$str);
        $str=str_replace('\n','',$str);

        $res1=[
            'class'=>'main-container',
            'inner_text'=>false,
            'outer_text'=>'Подложка',
            'style'=>[
                [
                'key'=>'background-color',
                'Outer_text'=>'Цвет фона',
                'value'=>'#eee',
                'editable'=>true,
                'removable'=>false,
                ],
                [
                'key'=>'border-color',
                'Outer_text'=>'Цвет обводки',
                'value'=>'#fafafa',
                'editable'=>true,
                'removable'=>false,
                ],
                [
                'key'=>'color',
                'Outer_text'=>'Цвет шрифта',
                'value'=>'#ffa500',
                'editable'=>true,
                'removable'=>false,
                ],
                [
                'key'=>'border-radius',
                'Outer_text'=>'Цвет шрифта',
                'value'=>'5px',
                'editable'=>false,
                'removable'=>false,
                ],

            ]
        ];

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

       /* $res1=[
            'h_txt'=>'Lorem ipsum.',
            'f_txt'=>'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab, rem.',
            'sb_txt'=>'Lorem ipsum.',
            'icon_txt'=>'Lorem ipsum.',
            'suc_res_txt'=>'Lorem ipsum.',
            'err_res_txt'=>'Lorem ipsum.',
            'suc_btn_txt'=>'Lorem ipsum.',
            'err_btn_txt'=>'Lorem ipsum.',
        ];*/

        $text = [
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
    ];

        $str= explode('}',$str);
        //unset($str[0]);
        $str1='';
        foreach($str as $key=>$val)
        {
            $str1[$key] = explode('{',$val);
        }
        $str=[];
        for($i=0; $i<count($str1); $i++)
        {
            $str[$i]['class']=trim($str1[$i][0]);
            $str[$i]['inner_text']=false;
            $str[$i]['outer_text']='';
            $str[$i]['for_user']=false;
            $str[$i]['config']=explode(';',$str1[$i][1]);
            unset($str[$i]['config'][count($str[$i]['config'])-1]);
            foreach($str[$i]['config'] as $key=>$val)
            {
                $s=explode(':',$val);
                $str[$i]['config'][$key]=[];
                $str[$i]['config'][$key]['key']=trim($s[0]);
                $str[$i]['config'][$key]['value']=trim($s[1]);
                $str[$i]['config'][$key]['outer_text']='';
                if (strripos($s[0],'color')) $str[$i]['config'][$key]['outer_text'] = 'Цвет шрифта';
                if (strripos($s[0] ,'background-color')) $str[$i]['config'][$key]['outer_text'] = 'Цвет фона';
                if (strripos($s[0] , 'border-color')) $str[$i]['config'][$key]['outer_text'] = 'Цвет обводки';

                if (strripos($s[0],'color')){
                    $str[$i]['config'][$key]['editable'] = true;
                    $str[$i]['for_user']=true;
                }
                else{
                    $str[$i]['config'][$key]['editable'] = false;
                }
                $str[$i]['config'][$key]['removable'] = false;
            }

        }
        $this->response->json($text);
    }
}