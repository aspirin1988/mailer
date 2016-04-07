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

    function GetOptions($id)
        {
            $siteData = $this->db->select('site_options',
                [
                    'site_options.*'
                ],
                [
                    'site'=>$id,
                ]
            );
            if ($siteData)
            {
                $siteData[0]['color']=json_decode( $siteData[0]['color'],true);
                $siteData[0]['text']=json_decode( $siteData[0]['text'],true);
            }
            return [
                'data' => $siteData,
            ];
        }

}