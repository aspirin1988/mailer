<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 22.02.2016
 * Time: 12:22
 */

namespace app\programmer\controllers;


use app\programmer\models\Programmer;
use app\programmer\models\Projects;
use core\Controller;

class Files extends Controller
{
    public function getFiles($projectId = 0)
    {
        if (filter_var($projectId, FILTER_VALIDATE_INT)) {
            $model = new Programmer();
            $userId = $this->session->User('id');
            if (Projects::isMyProject($projectId, $userId)) {
                $files = $model->getProjectFiles($projectId);

                $des = 0;
                $off = 0;
                $pr = 0;
                $wb = 0;
                foreach ($files as $key => $val) {
                    switch ($val['post']) {
                        case 3 :
                            $des += 1;
                            break;
                        case 4 :
                            $wb += 1;
                            break;
                        case 5 :
                            $off += 1;
                            break;
                        case 7 :
                            $pr += 1;
                            break;
                    }
                }
                $project['files'] = $files;
                $project['count'] = array('3' => $des, '4' => $wb, '5' => $off, '7' => $pr);

                $this->response->json($project);
            }
        } else {
            $this->response->notFound();
        }

    }
}