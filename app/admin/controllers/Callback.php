<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 07.04.16
 * Time: 11:00
 */

namespace app\admin\controllers;


use core\Controller;

class Callback extends Controller
{
    /*---------Site-----------*/

    public function GetAllSite($page=0)
    {
        $model = new \app\admin\models\callback();
        $this->response->json($model->getAllSite($page,$this->session->getUser()));
    }

    public function GetSite($id)
    {
        $model = new \app\admin\models\callback();
        $this->response->json($model->GetSite($id));
    }

    public  function EditSite ()
    {
        $value = $this->request->rest();
        unset($value['c_name']);
        $model = new \app\admin\models\callback();
        $this->response->json($model->EditSite($value['id'],$value));
    }

    public function AddSite ($company)
    {
        $value = $this->request->rest();
        $model = new \app\admin\models\callback();
        $this->response->json($model->AddSite($value,$this->session->getUser(),$company));
    }
    
    public function OperatorEdit ($id,$approve,$sitename)
    {
        $model = new \app\admin\models\callback();
        $this->response->json($model->OperatorEdit($id,$approve,$sitename,$this->session->getUser()));
    }


    public function DelSite ()
    {
        $value = $this->request->rest();
        $model = new \app\admin\models\callback();
        $this->response->json($model->DelSite($value));
    }

    /*---------Gateway-----------*/

    public function GetAllGateway($page=0)
    {
        $model = new \app\admin\models\callback();
        $this->response->json($model->GetAllGateway($page));
    }

    public  function GetGateway ($id)
    {
        $model = new \app\admin\models\callback();
        $this->response->json($model->GetGateway($id));
    }

    public  function EditGateway ()
    {
        $value = $this->request->rest();
        $id=$value['id'];
        unset($value['id']);
        $model = new \app\admin\models\callback();
        $this->response->json($model->EditGateway($id,$value));
    }

    public function AddGateway ()
    {
        $value = $this->request->rest();
        $model = new \app\admin\models\callback();
        $this->response->json($model->AddGateway($value));
    }
}