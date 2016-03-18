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

    public  function EditSite ()
    {
        $value = $this->request->rest();
        $model = new \app\admin\models\client();
        $this->response->json($model->EditSite($value['id'],$value));
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

    public  function GetGateway ($id)
    {
        $model = new \app\admin\models\client();
        $this->response->json($model->GetGateway($id));
    }

    public  function EditGateway ($id)
    {
        $value = $this->request->rest();
        $model = new \app\admin\models\client();
        $this->response->json($model->EditGateway($id,$value));
    }

    public function AddGateway ()
    {
        $value = $this->request->rest();
        $model = new \app\admin\models\client();
        $this->response->json($model->AddGateway($value));
    }

}