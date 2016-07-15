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
}