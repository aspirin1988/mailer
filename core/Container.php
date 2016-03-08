<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 16.02.2016
 * Time: 13:28
 */

namespace core;

/**
 * Класс для хранение объектов
 *
 * Class Container
 * @package core
 */
class Container
{
    /** Контайнер который хранит название объектов
     * @var
     */
    private $lazy = [];

    /** Контайнер который хранит массив объектов
     * @var array
     */
    private $data = [];

    /**
     * проверяет входной ключь, если есть то отправляет объект
     *
     * $someClass = YASF::$app->get('someClass');
     *
     * @param $key
     * @return bool
     */
    public function get($key)
    {
        if (array_key_exists($key, $this->lazy)) {
            return new $this->lazy[$key];
        } else if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        } else {
            return false;
        }
    }

    /**
     * $someClass = YASF::$app->set('someClass',new SomeClass());
     * Or
     * $someClass = YASF::$app->set('someClass',"SomeClass");
     * @param $key
     * @param $value
     *
     */

    public function set($key, $value)
    {
        if (is_string($value)) {
            $this->lazy[$key] = $value;
        } else {
            $this->data[$key] = $value;
        }
    }
}