<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 09.03.16
 * Time: 23:28
 */

namespace app\site\controllers;


use core\Controller;

class Site extends Controller
{
    public function getAllSite($page)
    {
        $model = new \app\site\models\site();
        $this->response->json($model->getAllSite($page));
    }

    public function getSite($id)
    {
        $model = new \app\site\models\site();
        $this->response->json($model->getSite($id));
    }

    public  function EditSite ($id)
    {
        $value = $this->request->rest();
        $model = new \app\site\models\site();
        $this->response->json($model->EditSite($id,$value));
    }

    public function AddSite ()
    {
        $value = $this->request->rest();
        $model = new \app\site\models\site();
        $this->response->json($model->AddSite($value));
    }

}