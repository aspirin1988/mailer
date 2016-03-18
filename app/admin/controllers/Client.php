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
    public function GetAllSite($page=0)
    {
        $model = new \app\admin\models\client();
        $this->response->json($model->getAllSite($page));
    }

    public function GetSite($id)
    {
        $model = new \app\admin\models\client();
        $this->response->json($model->GetSite($id));
    }

    public  function EditSite ($id)
    {
        $value = $this->request->rest();
        $model = new \app\admin\models\client();
        $this->response->json($model->EditSite($id,$value));
    }

    public function AddSite ()
    {
        $value = $this->request->rest();
        $model = new \app\admin\models\client();
        $this->response->json($model->AddSite($value));
    }
/*---------Gateway-----------*/
    public function GetAllGateway($page=0)
    {
        $model = new \app\admin\models\client();
        $this->response->json($model->GetAllGateway($page));
    }

}