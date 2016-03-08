<?php
/**
 * Created by PhpStorm.
 * User: aibekps
 * Date: 19-Feb-16
 * Time: 20:10
 */

namespace app\programmer\models;


use core\Models;
use library\traits\Comments;
use library\traits\Files;
use library\traits\Patchlist;

class Programmer extends Models
{
    use Comments,Files,Patchlist;

}