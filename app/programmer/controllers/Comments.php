<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 19.02.2016
 * Time: 15:44
 */

namespace app\programmer\controllers;


use app\programmer\models\Programmer;
use app\programmer\models\Projects;
use core\Controller;
use library\Helper;

/**
 * Class Comments
 * @package app\programmer\controllers
 */
class Comments extends Controller
{

    /**
     * Получить комментарий по ид проекта
     * @param $projectId
     * @param int $page
     */
    public function getComments($projectId=null, $page = 0)
    {
        if (filter_var($projectId, FILTER_VALIDATE_INT)) {
            $model = new Programmer();
            $userId = $this->session->User('id');
            if (Projects::isMyProject($projectId,$userId)) {
                $comments = $model->getComments($projectId, $page);
                $this->response->json($comments);
            }
        } else{
            $this->response->notFound();
        }
    }

    /**
     *Добавить комментарий
     */
    public function addComment()
    {
        $data = $this->request->rest();

        if (!is_null($data) &&
            Helper::NotEmpty($data,'projectId') &&
            Helper::NotEmpty($data,'comments')
        ) {
            $projectId = $data['projectId'];
            $comments = $data['comments'];
            $model = new Programmer();
            $userId = $this->session->User('id');
            if (Projects::isMyProject($projectId,$userId)) {
                $this->response->json($model->addComment($projectId, $comments,$userId));
            }
        } else {
            $this->response->notFound();
        }
    }
}