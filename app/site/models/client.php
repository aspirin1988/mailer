<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 15.03.16
 * Time: 11:39
 */

namespace app\site\models;


use core\Models;

class client extends Models
{
    public function Template($name,$style)
    {

    }

    public function Script($name,$style)
    {

    }

    public function CallBack($param)
    {
        $this->$param();
    }

    function Recall()
    {
        echo 111;
    }
}