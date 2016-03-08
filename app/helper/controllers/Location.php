<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 22.02.2016
 * Time: 16:32
 */

namespace app\helper\controllers;


use core\Controller;

/**
 * Class Location
 * @package app\helper\controllers
 */
class Location extends Controller
{
    /**
     * @var \app\helper\models\Location|null
     */
    private $model = null;

    /**
     * Location constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->model = new \app\helper\models\Location();
    }

    /**
     *  Получить Country
     */
    public function showCountryies()
    {
        $this->response->json($this->model->getCountry());
    }

    /**
     * Получить City
     */
    public function showCityes()
    {
        $this->response->json($this->model->getCity());
    }

    /**
     * Получить City по значению
     * @param $val
     * @return bool
     */
    public function showCity($val = 0)
    {
        if (filter_var($val, FILTER_VALIDATE_INT)) {
            $this->response->json($this->model->selectCity($val));
        }
        $this->response->notFound();
    }
}