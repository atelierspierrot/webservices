<?php
/**
 * This file is part of the WebServices package.
 *
 * Copyright (c) 2013-2015 Pierre Cassat <me@e-piwi.fr> and contributors
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *      http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * The source code of this package is available online at 
 * <http://github.com/atelierspierrot/webservices>.
 */
namespace WebServices;

use \ErrorException as BaseErrorException;
use \Patterns\Commons\HttpStatus;
use \Library\Logger;

/**
 * @author  piwi <me@e-piwi.fr>
 */
class ErrorException
    extends BaseErrorException
    implements FrontControllerAwareInterface
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
     * @param \Exception $previous
     */
    public function __construct($message = '', $code = 0, $severity = 1, $filename = __FILE__, $lineno = __LINE__, \Exception $previous = null)
    {
        parent::__construct($message, $code, $severity, $filename, $lineno, $previous);
        $this->setFrontController(FrontController::getInstance());
        $this->webservices
            ->setStatus(FrontController::STATUS_INTERNAL_ERROR)
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
     *
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
