<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 18.02.2016
 * Time: 14:32
 */

namespace library;


class Status
{
    /**
     * Без статуса
     */
    const NOT_STATUS = 0;

    /**
     * Отказ
     */
    const FAILURE = 1;

    /**
     * Встреча
     */
    const MEET = 2;

    /**
     * Перезвонить
     */
    const CALL_BACK = 3;

    /**
     * Есть сайт
     */
    const HAVE_WEB_SITE = 4;

    /**
     * Не верные данные
     */
    const NOT_CORRECT_DATA = 5;

    /**
     * Клиент
     */
    const CLIENT = 6;

    /**
     * Закрытый проект
     */
    const CLOSED_PROJECT = 10;

    /**
     * Черновик проекта
     */
    const DRAFT_PROJECT = 11;

    /**
     * Дизайн
     */
    const DESIGN_PROJECT = 12;

    /**
     * Утверждение дизайна
     */
    const DESIGN_APPROVAL_PROJECT = 13;

    /**
     * Верстка
     */
    const MAKEUP_PROJECT = 14;

    /**
     * Тестирование проекта
     */
    const TEST_PROJECT = 17;

    /**
     * Разработка проекта
     */
    const DEV_PROJECT = 16;

    /**
     * Утверждение проекта
     */
    const DEV_APPROVAL_PROJECT = 18;

    /**
     * Завершенный проект
     */
    const COMPLETED_PROJECT = 19;

    /**
     * Утверждение вертски
     */
    const MAKEUP_APPROVAL_PROJECT = 15;


}