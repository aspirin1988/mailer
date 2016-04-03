<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 18.03.16
 * Time: 16:47
 */

namespace app\admin\controllers;


use core\Controller;

class Main extends Controller
{
    public function index()
    {
        $this->response->renderPage('public/resources/admin/index2',[]);
    }

}