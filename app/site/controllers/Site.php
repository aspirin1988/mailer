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
}