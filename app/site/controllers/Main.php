<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 09.03.16
 * Time: 2:47
 */

namespace app\site\controllers;


use core\Controller;

class Main extends Controller
{
    public function index()
    {
        $this->response->renderPage('public/resources/site/index2', []);
    }
}