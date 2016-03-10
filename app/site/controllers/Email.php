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
    public function getAllEmail($page)
    {
        $model = new \app\site\models\email();
        $this->response->json($model->getAllEmail($page));
    }
}