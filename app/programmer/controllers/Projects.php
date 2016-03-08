<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 18.02.2016
 * Time: 11:16
 */

namespace app\programmer\controllers;


use app\programmer\models\Projects as ProjectsModel;
use core\Controller;
use library\Helper;
use library\Status;

class Projects extends Controller
{
    /**
     * Мои проекты
     * @param int $page
     */
    public function myProjects($page = 0)
    {
        $model = new ProjectsModel();
        $userId = $this->session->User('id');
        $data = $model->getProjects(Status::DEV_PROJECT, $userId, $page);
        $this->response->json($data);
    }

    /**
     * Необработанные проекты
     * @param int $page
     */
    public function otherProjects($page = 0)
    {
        $model = new ProjectsModel();
        $data = $model->getProjects(Status::DEV_PROJECT, 0, $page);
        $userId = $this->session->User('id');
        $data['hasProject'] = ProjectsModel::issetProject($userId) ? 1 : 0;
        $this->response->json($data);
    }

    /**
     * Ожидающие утверждёния
     * @param int $page
     */
    public function toApprove($page = 0)
    {
        $model = new ProjectsModel();
        $userId = $this->session->User('id');
        $data = $model->getProjects(Status::TEST_PROJECT, $userId, $page);
        $this->response->json($data);
    }

    /**
     * Завершенные проекты
     * @param int $page
     */
    public function finish($page = 0)
    {
        $model = new ProjectsModel();
        $userId = $this->session->User('id');
        $data = $model->getProjects(Status::COMPLETED_PROJECT, $userId, $page);
        $this->response->json($data);
    }

    /**
     * Просмотреть детализация моего проекта
     * @param int $projectId
     */
    public function projectView($projectId = 0)
    {
        $userId = $this->session->User('id');
        if (filter_var($projectId, FILTER_VALIDATE_INT)) {
            $model = new ProjectsModel();
            $projectDetail = $model->getProjectById($projectId, $userId);
            $this->response->json($projectDetail);
        } else {
            $this->response->notFound();
        }
    }


    public function editDeveloper()
    {
        $projectId = $this->request->post('projectId');
        if (!is_null($projectId)) {
            $model = new ProjectsModel();
            $userId = $this->session->User('id');
            $model->editDeveloper($projectId, $userId);
        } else {
            return false;
        }
    }

    /**
     *Редактирует проект, меняет статус проекта на Status::TEST_PROJECT
     */
    public function editProject()
    {
        $data = $this->request->rest();

        if (!is_null($data) && Helper::NotEmpty($data, 'id')) {
            $projectId = $data['id'];
            $status = Status::TEST_PROJECT;
            $model = new ProjectsModel();
            $userId = $this->session->User('id');
            if (ProjectsModel::isMyProject($projectId, $userId)) {
                $this->response->json($model->editProjectByStatus($projectId, $status));
            }
        } else {
            $this->response->notFound();
        }
    }

}