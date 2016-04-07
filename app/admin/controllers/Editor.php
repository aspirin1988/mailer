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

        $res=['default'=>$res1];


        $this->response->json($res);
    }
}