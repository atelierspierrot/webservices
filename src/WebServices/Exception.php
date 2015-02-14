<?php
/**
 * This file is part of the WebServices package.
 *
 * Copyleft (ↄ) 2013-2015 Pierre Cassat <me@e-piwi.fr> and contributors
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * The source code of this package is available online at 
 * <http://github.com/atelierspierrot/webservices>.
 */
namespace WebServices;

use \Exception as BaseException;
use \Patterns\Commons\HttpStatus;
use \Library\Logger;

/**
 * @author      Piero Wbmstr <me@e-piwi.fr>
 */
class Exception
    extends BaseException
    implements FrontControllerAwareInterface
{

    /**
     * @var \WebServices\FrontController
     */
    protected $webservices;


    /**
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($message = '', $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->setFrontController(FrontController::getInstance());
        $this->webservices
            ->setStatus(FrontController::STATUS_TREATMENT_ERROR)
            ->getResponse()->setStatus(HttpStatus::ERROR);
    }

    /**
     * Force the error display
     *
     * @return string
     */
    public function __toString()
    {
        $this->render();
        return '';
    }

    /**
     * Force the error display and log it
     * @return void
     */
    public function render()
    {
        $exception_context = array(
            'type'=> get_called_class(),
            'code'=> $this->getCode(),
            'message'=>$this->getMessage(),
            'line'=>$this->getLine(),
            'file'=>$this->getFile(),
        );
        $this->webservices->log(
            $this->webservices->getOption('error_log_mask'), $exception_context, Logger::ERROR
        );
        $this->webservices->getResponse()
            ->addContent('error', $exception_context);
        $this->webservices->display();
    }

    /**
     * @param \WebServices\FrontController $kernel
     * @return self
     */
    public function setFrontController(FrontController $kernel = null)
    {
        $this->webservices = $kernel;
        return $this;
    }

    /**
     * @return \WebServices\FrontController
     */
    public function getFrontController()
    {
        return $this->webservices;
    }

}

// Endfile
