<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 18.02.2016
 * Time: 10:55
 */

namespace app\programmer\controllers;


use core\Controller;

class Main extends Controller
{
    private  $css = [];
    private  $js = [];

    public function __construct()
    {
        parent::__construct();
        $this->css[] = "app.css";
        $this->js[] = "app.js";
    }

    public function index()
    {
        $this->render('index',['js'=>$this->js,'css'=>$this->css]);
    }
}