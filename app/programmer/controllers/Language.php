<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 23.02.2016
 * Time: 15:57
 */

namespace app\programmer\controllers;


use core\Controller;

class Language extends Controller
{
    public function index()
    {
        $this->response->json($this->getLang());
    }

}