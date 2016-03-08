<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 22.02.2016
 * Time: 14:09
 */

namespace app\programmer\controllers;


use app\programmer\models\Programmer;
use app\programmer\models\Projects;
use core\Controller;

class Patchlist extends Controller
{
    public function getPatchList($projectId = 0)
    {
        if (filter_var($projectId, FILTER_VALIDATE_INT)) {
            $model = new Programmer();
            $userId = $this->session->User('id');
            if (Projects::isMyProject($projectId,$userId)) {
                $patchlist = $model->getPatchList($projectId);
                $patchlistFiles = $model->getPatchListFiles($projectId);
                $result['patch_lists']['data'] = $patchlist;
                $result['patch_lists']['files'] = $patchlistFiles;
                $this->response->json($result);
            }
        } else {
            $this->response->notFound();
        }
    }
}