<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 22.02.2016
 * Time: 12:23
 */

namespace library\traits;


use core\Database;

trait Files
{
    function getProjectFiles($projectId)
    {
        /** @var Database $database */
        $database = \YASF::$app->get('Database');
        $files = $database->select('project_files', '*', ['project_id' => $projectId]);
        return $files;
    }


    function downloadProjectFiles($projectId, $userId)
    {
//        $path = TEMP_PATH . DS . $userId . DS . 'project_' . $projectId;
//        $archive = 'project_' . $projectId . '.zip';
//        mkdir($path, 0777, true);
//        chmod($path, 0777);
//
//        /** @var Database $database */
//        $database = \YASF::$app->get('Database');
//
//        $files = $database->select('project_files', [
//            "[>]post_categorias" => ["post" => "id"],
//        ], [
//            'post_categorias.name',
//        ], [
//            'project_id' => $projectId
//        ]);
//
//
//        if (file_exists($path . DS . $archive)) {
//            unlink($path . DS . $archive);
//        }
//
//        $zip = new \ZipArchive();
//        if ($zip->open($path . DS . $archive, \ZipArchive::CREATE) !== TRUE) {
//            exit("Невозможно открыть <$archive>\n");
//        }
//
//        foreach ($files as $key => $val) {
//            $zip->addFile(BASE_PATH . '/' . $val['path'], $val['uploader'] . '/' . $val['name_old']);
//        }
//        $zip->close();
//        self::FileForceDownload($path . '/' . $archive);
//        return $files;

    }
}