<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 22.02.2016
 * Time: 13:34
 */

namespace library\traits;


use core\Database;

trait Patchlist
{
    function getPatchList($projectId)
    {
        /** @var Database $database */
        $database = \YASF::$app->get('Database');

        $result = $database->select('project_bugs', [
            "[>]users" => ["user" => "id"],
            "[>]post_categorias" => ["to" => "id"],
        ], [
            'users.first_name',
            'users.last_name',
            'post_categorias.name(to_post)',
            'project_bugs.id',
            'project_bugs.parent',
            'project_bugs.project',
            'project_bugs.message',
            'project_bugs.user',
            'project_bugs.date',
            'project_bugs.to',
            'project_bugs.title',
            'project_bugs.finish',
        ], [
            "AND" => [
                'project' => $projectId,
                'parent' => 0
            ]
        ]);

        if ($result) {


            foreach ($result as $key => $value) {
                $result[$key]['node'] = $database->select('project_bugs', [
                    "[>]users" => ["user" => "id"],
                    "[>]post_categorias" => ["to" => "id"],
                ], [
                    'users.first_name',
                    'users.last_name',
                    'post_categorias.name(to_post)',
                    'project_bugs.id',
                    'project_bugs.parent',
                    'project_bugs.project',
                    'project_bugs.message',
                    'project_bugs.user',
                    'project_bugs.date',
                    'project_bugs.to',
                    'project_bugs.title',
                    'project_bugs.finish',
                ], [
                    "AND" => [
                        'project' => $projectId,
                        'parent' => $result[$key]['id']
                    ]
                ]);
            }
        }

        return $result;
    }


    function getPatchListFiles($projectId)
    {
        /** @var Database $database */
        $database = \YASF::$app->get('Database');
        $result = $database->select('project_bugs_files', '*', ['project' => $projectId]);
        return $result;
    }

}