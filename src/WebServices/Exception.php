<?php
/**
 * WebServices - PHP package
 * Copyleft (c) 2013 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <https://github.com/atelierspierrot/webservices>
 */
namespace WebServices;

use \Exception as BaseException;

/**
 * @author 		Piero Wbmstr <piero.wbmstr@gmail.com>
 */
class Exception extends BaseException
{

    protected $webservices;

    public function __construct($message = '', $code = 0, Exception $previous = null)
    {
		parent::__construct($message, $code, $previous);
        $this->webservices = FrontController::getInstance();
        $this->webservices
            ->setStatus(FrontController::STATUS_TREATMENT_ERROR)
            ->getResponse()->setStatus(Response::STATUS_ERROR);
    }

    public function __toString()
    {
        return $this->render();        
    }

    public function render()
    {
        $this->webservices->getResponse()
            ->addContent(
                'error', array(
                    'type'=> get_called_class(),
                    'code'=> $this->getCode(),
                    'message'=>$this->getMessage(),
                    'line'=>$this->getLine(),
                    'file'=>$this->getFile(),
                )
            );
        $this->webservices->display();
    }

}

// Endfile