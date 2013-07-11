<?php
/**
 * WebServices - PHP package
 * Copyleft (c) 2013 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <https://github.com/atelierspierrot/webservices>
 */
namespace WebServices;

use \ErrorException as BaseErrorException;

use Library\Logger;

/**
 * @author      Piero Wbmstr <piero.wbmstr@gmail.com>
 */
class ErrorException extends BaseErrorException
{

    /**
     * @var \WebServices\FrontController
     */
    protected $webservices;

    /**
     * @param string $message
     * @param int $code
     * @param int $severity
     * @param string $filename
     * @param int $lineno
     * @param object $previous \Exception
     */
    public function __construct($message = '', $code = 0, $severity = 1, $filename = __FILE__, $lineno = __LINE__, Exception $previous = null)
    {
        parent::__construct($message, $code, $severity, $filename, $lineno, $previous);
        $this->webservices = FrontController::getInstance();
        $this->webservices
            ->setStatus(FrontController::STATUS_INTERNAL_ERROR)
            ->getResponse()->setStatus(Response::STATUS_ERROR);
    }

    /**
     * Force the error display
     * @return void
     */
    public function __toString()
    {
        return $this->render();        
    }

    /**
     * Force the error display and log it
     * @return void
     */
    public function render()
    {
        $exception_context = array(
            'type'=> get_called_class(),
            'code'=> $this->getCode() . ' [severity: ' . $this->getSeverity() . ']',
            'message'=>$this->getMessage(),
            'line'=>$this->getLine(),
            'file'=>$this->getFile(),
        );
        $this->webservices->log(
            $this->webservices->getOption('error_log_mask'), $exception_context, Logger::CRITICAL
        );
        $this->webservices->log(
            $this->getTraceAsString(), array(), Logger::CRITICAL
        );
        $this->webservices->getResponse()
            ->addContent('error', $exception_context);
        $this->webservices->display();
    }

}

// Endfile
