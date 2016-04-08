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




    function GetArray()
    {


        $res1=[
            'm_cl'=>'#ffffff',
            'm_cl_br'=>'#ffffff',
            'h_f_cl'=>'#ffffff',
            'f_f_cl'=>'#ffffff',
            'sub_btn_cl'=>'#ffffff',
            'sub_btn_cl:hover'=>'#ffffff',
            'fields_f_cl'=>'#ffffff',
            'fields_bg_cl'=>'#ffffff',
            'fields_br_cl'=>'#ffffff',
            'res_suc_bg_cl'=>'#ffffff',
            'res_err_bg_cl'=>'#ffffff',
            'res_suc_f_cl'=>'#ffffff',
            'res_err_f_cl'=>'#ffffff',
            'res_suc_btn_f_cl'=>'#ffffff',
            'res_err_btn_f_cl'=>'#ffffff',
            'res_suc_btn_bg_cl'=>'#ffffff',
            'res_err_btn_bg_cl'=>'#ffffff',
            'main_btn_f_cl'=>'#ffffff',
            'main_btn_br_cl'=>'#ffffff',
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

        //$res=['default'=>$res1];


        $this->response->json($data['color']);
    }
}