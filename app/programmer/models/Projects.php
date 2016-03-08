<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 18.02.2016
 * Time: 11:20
 */

namespace app\programmer\models;


use core\Database;
use core\Models;
use library\Status;


class Projects extends Models
{

    public function getProjects($status, $developerId, $page = 0)
    {
        $limit = PAGE_SIZE;
        $countData = $this->db->count("project", [
            "AND" => [
                'status' => $status,
                'developer' => $developerId,
            ],
        ]);

        $countPage = ceil($countData / $limit);
        $offset = (int)$page * $limit;

        $projectData = $this->db->select('project', ['status', 'name', 'id'], [
            "AND" => [
                'status' => $status,
                'developer' => $developerId,
            ],
            'LIMIT' => [$offset, $limit],
            'ORDER' => ['id ASC']
        ]);

        return [
            'data' => $projectData,
            'count' => $countPage
        ];
    }


    public function getProjectById($projectId, $developerId)
    {
        $projectData = $this->db->select('project', '*', [
            "AND" => [
                'id' => $projectId,
                'developer' => $developerId,
            ]
        ]);

        return [
            'data' => $projectData
        ];
    }


    public function editProjectByStatus($projectId,$statusId)
    {
        $date=time();

        $result = $this->db->update('project',[
            "status" => $statusId,
            "date_last_edit" => $date,
        ],[
            'id'=>$projectId
        ]);

        return [
            'data'=>$result
        ];
    }


    public function editDeveloper($projectId,$developer)
    {
        $result = $this->db->update('project',[
            "developer" => $developer,
        ],[
            'id'=>$projectId
        ]);

        return $result;
    }

    public static function isMyProject($projectId,$developer)
    {
        /** @var Database $database */
        $database = \YASF::$app->get('Database');
        return $database->has('project', [
            "AND" => [
                'id' => $projectId,
                'developer' => $developer
            ]
        ]);
    }

    public static function issetProject($developer)
    {
        $database = \YASF::$app->get('Database');
        /** @var Database $database */
        return $database->has('project', [
            "AND" => [
                'status' => Status::DEV_PROJECT,
                'developer' => $developer
            ]
        ]);
    }



}