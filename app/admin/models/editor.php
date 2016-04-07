<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 07.04.16
 * Time: 16:45
 */

namespace app\admin\models;


use core\Models;

class editor extends Models
{
    function GetServices()
    {
        $siteData = $this->db->select('services',
            [
                'services.*'
            ]
        );

        return [
            'data' => $siteData,
        ];
    }

}