<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 19.02.2016
 * Time: 17:39
 */

namespace app\programmer\controllers;


use core\Controller;

class Company extends Controller
{
    public function getCompany($companyId = 0)
    {
        if (filter_var($companyId, FILTER_VALIDATE_INT)) {
            $model = new \app\programmer\models\Company();
            $userId = $this->session->User('id');
            $projectDetail = $model->getCompanyById($companyId, $userId);
            $this->response->json($projectDetail);

        } else {
            $this->response->notFound();
        }
    }
}