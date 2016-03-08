<?php
/**
 * Created by PhpStorm.
 * User: dobro
 * Date: 22.02.16
 * Time: 14:45
 */

namespace app\auth\controllers;

use core\Controller;
use app\auth\models\Auth as Auth;

class Main extends Controller
{

    public function index()
    {
        /*if($this->session->user()){*/
            $this->response->renderPage('public/resources/auth/Default',[]);
       /* }else{
            $this->response->redirect('/'.$this->session->user('template'));
        }*/

    }

    public function login()
    {
        $rest = $this->request->rest([]);
            if(isset($rest['login']) && isset($rest['password']))
            {
                $model = new Auth();
                $verify = $model->verify($rest['login'], $rest['password']);
                //$this->response->json($verify > 0 ? ['status'=>$verify,'data'=>['redirect'=>'/']] : ['status'=>$verify,'data'=>[]]);
                if($verify > 0)
                {
                    $UserPermission = $model->getPermissions($model->getUser('post'));
                    if($UserPermission){
                        $UserPermission['permission'] = json_decode($UserPermission['permission'],true);
                        $model->setUserPermission($model->getUser(),$UserPermission['permission']);
                    }
                    $model->setUser('template',str_replace('/','',$UserPermission['template']));
// зухра и жим
                    $this->session->setUser($model->getUser());
                    $this->response->json([
                        'status'=>$verify,
                        'data'=>['redirect'=>$UserPermission['template']],
                        'session'=>$this->session->getUser()
                    ]);


                }else{
                    $this->response->json(['status'=>$verify,'data'=>[]]);
                }

            }else{
                $this->response->json(['status'=>-2,'data'=>[]]);
            }
    }

    public function setPassword($secret){

    }

    public function logoff(){
        $this->session->setUser($this->session->getUserTemplate());
    }

}