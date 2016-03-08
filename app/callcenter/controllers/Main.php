<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 23.02.16
 * Time: 10:33
 */

namespace app\callcenter\controllers;

use core\Controller;

class Main extends Controller
{
    public function index ()
    {
        $this->render('index');
    }

}