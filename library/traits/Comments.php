<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 18.02.2016
 * Time: 17:25
 */

namespace library\traits;


use core\Database;

trait Comments
{
    function getComments($projectId, $page = 0)
    {
        /** @var Database $databaseObject */
        $databaseObject = \YASF::$app->get("Database");

        $limit = PAGE_SIZE;
        $countData = $databaseObject->count("comment_project", ['project'=>$projectId]);

        $countPage = ceil($countData / $limit);
        $offset = (int)$page * $limit;

        $commentsList = $databaseObject->select('comment_project', [
            "[>]users" => ["user" => "id"]
        ], [
            'comment_project.message',
            'comment_project.user',
            'comment_project.date',
            'comment_project.project',
            'users.last_name',
            'users.first_name'
        ], [
            "comment_project.project" => $projectId,
            'LIMIT' => [$offset, $limit],
            'ORDER' => ['comment_project.id ASC']
        ]);

        return [
            'data' => $commentsList,
            'count' => $countPage,
        ];
    }


    function addComment($projectId,$message,$userId)
    {
        /** @var Database $databaseObject */
        $databaseObject = \YASF::$app->get("Database");
        $date=date('Y-m-d H:i:s');

        $lastId = $databaseObject->insert('comment_project',[
            "project" => $projectId,
            "message" => $message,
            "user" => $userId,
            "date" => $date
        ]);

        return [
            'data'=>$lastId
        ];
    }
}