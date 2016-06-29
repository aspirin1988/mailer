<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 18.03.16
 * Time: 16:59
 */

namespace app\admin\controllers;


use core\Controller;

class Client extends Controller
{
/*---------Client-----------*/

    public function GetAllClient($page=0)
    {
        $model = new \app\admin\models\client();

        $this->response->json($model->GetAllClient($page,$this->session->getUser()));
    }

    public function GetAllSiteClient($id,$page=0)
    {
        $model = new \app\admin\models\client();

        $this->response->json($model->GetAllSiteClient($id,$this->session->getUser()));
    }

    public function GetAllSiteClientNP($id)
    {
        $model = new \app\admin\models\client();

        $this->response->json($model->GetAllSiteClientNP($id,$this->session->getUser()));
    }

    public function GetClient($id)
        {
            $model = new \app\admin\models\client();
            $this->response->json($model->GetClient($id,$this->session->getUser()));
        }

    public  function EditClient ()
    {
        $value = $this->request->rest();
        $model = new \app\admin\models\client();
        $this->response->json($model->EditClient($value['id'],$value,$this->session->getUser()));
    }

    public function AddClient ()
    {
        $value = $this->request->rest();
        $model = new \app\admin\models\client();
        $this->response->json($model->AddClient($value,$this->session->getUser() ));
    }

    public function DelClient ($id)
    {
        $model = new \app\admin\models\client();
        $this->response->json($model->DelClient($id));
    }

    public function SearchClient($value)
    {
        $model = new \app\admin\models\client();
        $this->response->json($model->SearchClient($value));
    }




}