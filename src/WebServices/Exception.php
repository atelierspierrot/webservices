<?php
/**
 * This file is part of the WebServices package.
 *
 * Copyright (c) 2013-2016 Pierre Cassat <me@e-piwi.fr> and contributors
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

use \Exception as BaseException;
use \Patterns\Commons\HttpStatus;
use \Library\Logger;

/**
 * @author  piwi <me@e-piwi.fr>
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
