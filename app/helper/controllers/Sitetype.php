<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 23.02.2016
 * Time: 10:09
 */

namespace app\helper\controllers;


use core\Controller;

/**
 * Тип Сайта
 * Class Sitetype
 * @package app\helper\controllers
 */
class Sitetype extends Controller
{
    /**
     * @var \app\helper\models\SiteType|null
     */
    private $model = null;

    /**
     * Sitetype constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->model = new \app\helper\models\SiteType();
    }

    /**
     *Получить тип сайта
     */
    public function getSiteType()
    {
        $this->response->json($this->model->getSiteType());
    }

    /**
     * Получить тип сайта по id
     * @param $id
     */
    public function getSiteTypeById($id)
    {
        if (filter_var($id, FILTER_VALIDATE_INT)) {
            $this->response->json($this->model->getSiteTypeId($id));
        }
        $this->response->notFound();
    }
}