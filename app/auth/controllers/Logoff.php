<?php
/**
 * Created by PhpStorm.
 * User: dobro
 * Date: 17.03.16
 * Time: 14:44
 */

namespace app\auth\controllers;

use core\Controller;
use app\auth\models\Auth as Auth;

class Logoff extends Controller
{
    public function index(){
        $this->session->setUser($this->session->getUserTemplate());
        $this->response->redirect('/auth');
    }
}