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
}