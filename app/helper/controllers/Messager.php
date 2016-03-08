<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 22.02.2016
 * Time: 17:07
 */

namespace app\helper\controllers;


use core\Controller;

class Messager extends Controller
{
    /**
     * @var \app\helper\models\Messager
     */
    private $model = null;

    /**
     * Messager constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->model = new \app\helper\models\Messager();
    }

    /**
     *
     */
    public function showMessagers()
    {
        $this->response->json($this->model->getMessagers());
    }

    /**
     * @param int $id
     * @return bool
     */
    public function showMessager($id = 0)
    {
        if (filter_var($id, FILTER_VALIDATE_INT)) {
            $this->response->json($this->model->getMessagerById($id));
        }
        $this->response->notFound();
    }
}