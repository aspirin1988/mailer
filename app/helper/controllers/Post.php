<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 22.02.2016
 * Time: 17:30
 */

namespace app\helper\controllers;


use core\Controller;

/**
 * Class Post
 * @package app\helper\controllers
 */
class Post extends Controller
{
    /**
     * @var \app\helper\models\Post|null
     */
    private $model = null;

    /**
     * Post constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->model = new \app\helper\models\Post();
    }

    /**
     *
     */
    public function getPost()
    {
        $this->response->json($this->model->getPost());
    }

    /**
     * @param $id
     * @return bool
     */
    public function selectPost($id)
    {
        if (filter_var($id, FILTER_VALIDATE_INT)) {
            $this->response->json($this->model->selectPost($id));
        }
        $this->response->notFound();
    }
}