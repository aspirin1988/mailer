<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 17.02.2016
 * Time: 15:51
 */

namespace core;


abstract class Models
{
    /**
     * @var Database $db
     */
    protected $db;

    public function __construct()
    {
        $this->db = \YASF::$app->get('Database');
    }
}