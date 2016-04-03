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
        $this->response->json($model->GetAllClient($page));
    }

    public function GetClient($id)
        {
            $model = new \app\admin\models\client();
            $this->response->json($model->GetClient($id));
        }

    public  function EditClient ()
    {
        $value = $this->request->rest();
        $model = new \app\admin\models\client();
        $this->response->json($model->EditClient($value['id'],$value));
    }

    public function AddClient ()
    {
        $value = $this->request->rest();
        $model = new \app\admin\models\client();
        $this->response->json($model->AddSite($value));
    }

/*---------Site-----------*/

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

    public  function EditGateway ()
    {
        $value = $this->request->rest();
        $id=$value['id'];
        unset($value['id']);
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