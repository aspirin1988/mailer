<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 22.02.2016
 * Time: 17:22
 */

namespace app\helper\controllers;


use core\Controller;

class Education extends Controller
{
    /**
     * @var \app\helper\models\Education|null
     */
    private  $model = null;

    /**
     * Education constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->model = new \app\helper\models\Education();
    }

    /**
     *
     */
    public function getEducation()
    {
        $this->response->json($this->model->getEducation());
    }

    /**
     * @param int $id
     * @return bool
     */
    public function selectEducation($id = 0)
    {
        if (filter_var($id, FILTER_VALIDATE_INT)) {
            $this->response->json($this->model->selectEducation($id));
        }
        $this->response->notFound();
    }

}