<?php
/**
 * Created by PhpStorm.
 * User: dobro
 * Date: 08.08.16
 * Time: 13:48
 */

namespace app\api\controllers;

use core\Controller;
use app\auth\models\Auth as AuthModel;
use app\api\models\Api as Api;

class Auth extends Controller
{

    public function index()
    {
        $rest = $this->request->rest([]);
        if(isset($rest['login']) && isset($rest['password']))
        {
            $model = new AuthModel();
            $verify = $model->verify($rest['login'], $rest['password']);
            if($verify){
                $api = new Api();
                $this->response->json(['status' => true, 'data' => $api->openSession($model->getUser('id'))]);
            }
            else{
                $this->response->json(['status' => false]);
            }
        }
    }

}