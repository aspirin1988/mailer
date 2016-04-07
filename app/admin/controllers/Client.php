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



}