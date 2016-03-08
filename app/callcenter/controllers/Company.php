<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 23.02.16
 * Time: 15:27
 */

namespace app\callcenter\controllers;


use core\Controller;

class Company extends Controller
{
    public function getRawCompany($page)
    {
        $model = new \app\callcenter\models\Company();
        $this->response->json($model->getRawCompany($page));
    }

    public function getRejectCompany($page=0)
    {
        $model = new \app\callcenter\models\Company();
        $this->response->json($model->getRejectCompany($this->session->user('id'),$page));
    }

    public function getRecallCompany($page=0)
    {
        $model = new \app\callcenter\models\Company();
        $this->response->json($model->getRecallCompany($this->session->user('id'),$page));
    }

    public function getIncorrectCompany($page=0)
    {
        $model = new \app\callcenter\models\Company();
        $this->response->json($model->getIncorrectCompany($this->session->user('id'),$page));
    }

    public function getHassiteCompany($page=0)
    {
        $model = new \app\callcenter\models\Company();
        $this->response->json($model->getHassiteCompany($this->session->user('id'),$page));
    }

    public function getMeetCompany($page=0)
    {
        $model = new \app\callcenter\models\Company();
        $this->response->json($model->getMeetCompany($this->session->user('id'),$page));
    }

    public function getEditCompany($id)
    {
        $model = new \app\callcenter\models\Company();
        $this->response->json($model->getEditCompany($this->session->user('id'),$id));
    }



}