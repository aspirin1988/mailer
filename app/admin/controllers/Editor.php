<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 07.04.16
 * Time: 16:45
 */

namespace app\admin\controllers;


use core\Controller;

class Editor extends Controller
{

    function GetServices()
    {
        $model = new \app\admin\models\editor();
        $this->response->json($model->GetServices());
    }
}