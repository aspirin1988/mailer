<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 15.03.16
 * Time: 12:55
 */

namespace app\client\models;


use core\Models;

class callback extends Models
{
    public function Recall ()
    {
        return 'is recall';
    }

    public function Query ()
    {
        return 'is query';
    }

}