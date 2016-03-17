<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 16.02.2016
 * Time: 14:17
 */

namespace core;


/**
 * Class Response
 * @package core
 */
class Response
{
    /**
     * @var
     */
    private $headers = [];

    /**
     * @param $header
     */
    public function addHeaders($header)
    {
        $this->headers[] = $header;
    }

    /**
     * Возвращаем вид ы
     *
     * @param $view
     * @param array $data
     * @return string
     */
    public function render($view, $data = [])
    {
        $file = BASE_PATH . DS . $view . ".php";
        if (file_exists($file)) {

            extract($data);
            ob_start();

            if (!headers_sent() && count($this->headers) > 0) {
                foreach ($this->headers as $header) {
                    header($header, true);
                }
            }
            require_once(TEMPLATE_HEADER_FILE);
            require($file);
            require_once(TEMPLATE_FOOTER_FILE);

            echo ob_get_clean();
        } else {
            trigger_error('Error: Could not load template ' . $file . '!');
            exit();
        }
    }

    public function renderPage($view, $data = [])
    {
        $file = BASE_PATH . DS . $view . ".php";
        if (file_exists($file)) {

            extract($data);
            ob_start();

            if (!headers_sent() && count($this->headers) > 0) {
                foreach ($this->headers as $header) {
                    header($header, true);
                }
            }
            require($file);

            echo ob_get_clean();
        } else {
            trigger_error('Error: Could not load template ' . $file . '!');
            exit();
        }
    }

    /**
     * Возвращем json
     * @param $array
     * @return string
     */
    public function json($array)
    {
        header('Content-Type: application/json',true);
        echo json_encode($array, true);
    }

    public function js($data)
    {
        ///header_remove();
        header('Access-Control-Allow-Origin: *',true);
        //print_r($_SERVER);
        echo $data;
    }

    public function css($data)
    {
        ///header_remove();
        header('Content-Type: text/css',true);
        //print_r($_SERVER);
        echo $data;
    }

    /**
     * Редирект
     * @param $url
     */
    public function redirect($url)
    {
        header('Location: ' . $url, true, 302);
    }

    public function notFound()
    {
        $this->addHeaders('HTTP/1.0 404 Not Found');
        $this->renderPage('404');
    }


    public function __destruct()
    {
        \YASF::$app->get('Session')->flush();
    }
}