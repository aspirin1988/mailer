<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 23.02.2016
 * Time: 9:58
 */

namespace app\helper\controllers;


use core\Controller;

/**
 *
 * Статусы
 * Class Companystatusmanager
 * @package app\helper\controllers
 */
class Companystatusmanager extends Controller
{
    /**
     * @var \app\helper\models\Companystatusmanager|null
     */
    private $model = null;

    /**
     * Companystatusmanager constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->model = new \app\helper\models\Companystatusmanager();
    }

    /**
     * Все статусы
     */
    public function getStatusManager()
    {
        $this->response->json($this->model->getStatusManager());
    }

    /**
     *Статус Клиентов
     */
    public function getStatusClient()
    {
        $this->response->json($this->model->getStatusClient());
    }

    /**
     *Статус проектов
     */
    public function getStatusProject()
    {
        $this->response->json($this->model->getStatusProject());
    }

    /**
     * Получить статус по Id
     * @param int $id
     */
    public function getStatusById($id=0)
    {
        if (filter_var($id, FILTER_VALIDATE_INT)) {
            $this->response->json($this->model->getStatusById($id));
        }
        $this->response->notFound();
    }
}