<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 15.07.16
 * Time: 11:49
 */

namespace app\admin\controllers;


use core\Controller;

class Users extends Controller
{
    public function index(){
        echo "This users";
    }

    public function GetAllUsers (){
        $model = new \app\admin\models\users();
        $this->response->json($model->GetAllUsers($this->session->getUser()));
    }
    
    public function delPermission($id){
        $model = new \app\admin\models\users();
        $this->response->json($model->delPermission($id,$this->session->getUser()));  
    }

    public function delPermission_s($id){
        $model = new \app\admin\models\users();
        $this->response->json($model->delPermission_s($id,$this->session->getUser()));
    }

    public function approvePermission_c($id){
        $model = new \app\admin\models\users();
        $rest=$this->request->rest();
        $value=$rest['permission'];
        $this->response->json($model->approvePermission_c($id,$value,$this->session->getUser()));
    }

    public function approvePermission_s($id){
        $model = new \app\admin\models\users();
        $rest=$this->request->rest();
        $value=$rest['permission'];
        $this->response->json($model->approvePermission_s($id,$value,$this->session->getUser()));
    }
}