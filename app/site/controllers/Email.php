<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 10.03.16
 * Time: 23:59
 */

namespace app\site\controllers;


use core\Controller;

class Email extends Controller
{
    public function index($p,$p1)
    {
        echo 'index '.$p.' '.$p1;
    }


    public function getAllEmail($page)
    {
        $model = new \app\site\models\email();
        $this->response->json($model->getAllEmail($page));
    }

    public  function EditEmail ($id)
    {
        $value = $this->request->rest();
        $model = new \app\site\models\Email();
        $this->response->json($model->EditEmail($id,$value));
    }

    public function AddSite ()
    {
        $value = $this->request->rest();
        $model = new \app\site\models\Email();
        $this->response->json($model->AddEmail($value));
    }
}