<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 16.02.2016
 * Time: 13:53
 */

namespace core;


class Request
{
    /**
     * Проверка на сущестование ключа в массиве
     *
     * @param $array
     * @param $key
     * @param $deault
     * @return mixed
     */
    protected function check($array, $key, $deault)
    {
        if (null === $key)
            return $array;

        return isset($array[$key]) ? $array[$key] : $deault;
    }

    /**
     * Получить $_GET запрос
     *  YASF:$app->get('Request')->get('someKey',null);
     * @param null $key
     * @param null $default
     * @return mixed
     */
//    public function get($key = null, $default = null)
//    {
//        return $this->check($_GET, $key, $default);
//    }


    /**
     * Получить $_POST запрос
     *
     * @param null $key
     * @param null $default
     * @return mixed
     */
    public function post($key = null, $default = null)
    {
        return $this->check($_POST, $key, $default);
    }


    /**
     * Получить $_FILES
     *
     * @param null $key
     * @param null $default
     * @return mixed
     */
    public function files($key = null, $default = null)
    {
        return $this->check($_FILES, $key, $default);
    }

    /**
     * Получить $_SESSION
     *
     * @param null $key
     * @param null $default
     * @return mixed
     */
    public function session($key = null, $default = null)
    {
        return $this->check($_SESSION, $key, $default);
    }

    /**
     * Получить $_COOKIE
     *
     * @param null $key
     * @param null $default
     * @return mixed
     */
    public function cookie($key = null, $default = null)
    {
        return $this->check($_COOKIE, $key, $default);
    }

    /**
     * Получить $_SERVER
     *
     * @param null $key
     * @param $default
     * @return mixed
     */
    public function server($key = null, $default)
    {
        return $this->check($_SERVER, $key, $default);
    }

    /**
     * Если это ajax запрос
     * @return bool
     */
    public function ajax()
    {
        return preg_match('/^application\/json/',$_SERVER['HTTP_ACCEPT']);
    }

    /**
     * Получить тело запроса
     *
     * @param null $default
     * @return null
     */
    public function rest($default = null)
    {
        if(preg_match('/^application\/json/',$_SERVER['HTTP_ACCEPT'],$matches,PREG_OFFSET_CAPTURE)) {
            $json = json_decode(file_get_contents('php://input'), true);
            return !is_null($json) ? $json : $default;
        }
        return $default;
    }
}