<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 22.02.2016
 * Time: 17:54
 */

namespace app\helper\controllers;


use core\Controller;

/**
 * Class Companycategory
 * @package app\helper\controllers
 */
class Companycategory extends Controller
{
    /**
     * @var \app\helper\models\Companycategory|null
     */
    private $model = null;

    /**
     * Companycategory constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->model = new \app\helper\models\Companycategory();
    }

    /**
     *
     */
    public function getCompanyCategory()
    {
        $this->response->json($this->model->getCompanyCategory());
    }

    /**
     * @param $id
     */
    public function getCompanyCategoryById($id)
    {
        if (filter_var($id, FILTER_VALIDATE_INT)) {
            $this->response->json($this->model->getCompanyCategoryById($id));
        }
        $this->response->notFound();
    }
}