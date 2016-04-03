<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 16.03.16
 * Time: 23:13
 */

namespace library\mailer;


/**
 * PHPMailer exception handler
 * @package PHPMailer
 */
class phpmailerException extends \Exception
{
    /**
     * Prettify error message output
     * @return string
     */
    public function errorMessage()
    {
        $errorMsg = '<strong>' . $this->getMessage() . "</strong><br />\n";
        return $errorMsg;
    }
}