<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 15.03.16
 * Time: 12:08
 */

namespace app\site\controllers;


use core\Controller;

class Client extends Controller
{
    public function index()
    {
        echo 'is index';
    }

    public function CallBack($param)
    {
        $model = new \app\site\models\client();
        $model->CallBack($param);
    }

}