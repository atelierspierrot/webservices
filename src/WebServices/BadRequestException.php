<?php
/**
 * WebServices - PHP package
 * Copyleft (c) 2013 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <https://github.com/atelierspierrot/webservices>
 */
namespace WebServices;

use Library\HttpFundamental\Response;

/**
 * @author      Piero Wbmstr <piero.wbmstr@gmail.com>
 */
class BadRequestException extends \WebServices\Exception
{

    /**
     * Construction of the exception - a message is needed (1st argument)
     *
     * @param string $message The exception message
     * @param numeric $code The exception code
     * @param misc $previous The previous exception if so
     */
    public function __construct($message = '', $code = 0, Exception $previous = null)
    {
        if (empty($message)) $message = 'Bad request';
        parent::__construct($message, $code, $previous);
        $this->webservices
            ->setStatus(FrontController::STATUS_REQUEST_ERROR)
            ->setMessage($this->getMessage())
            ->getResponse()->setStatus(Response::STATUS_BAD_REQUEST);
    }

}

// Endfile
