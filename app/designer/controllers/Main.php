<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 17.02.2016
 * Time: 17:14
 */

namespace app\designer\controllers;

use core\Controller;

class Main extends Controller
{
    public function index()
    {
        $this->response->json(['asd'=>'hello']);
    }
}