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
namespace WebServices\Controller;

use \WebServices\FrontController;
use \WebServices\ErrorException;
use \WebServices\NotFoundException;
use \WebServices\BadRequestException;
use \WebServices\TreatmentException;

class DefaultController
    extends AbstractController
{

    protected function init()
    {
        $this->usage_filepath = __DIR__.'/DefaultController.md.php';
    }

// ------------------------
// Actions
// ------------------------

    public function indexAction()
    {
//        fopen(); // test the internal error handler
        $this->kernel
            ->setStatus(FrontController::STATUS_OK)
            ->setMessage('Nothing to do');
    }

    public function helloworldAction()
    {
        $this->kernel
            ->setStatus(FrontController::STATUS_OK)
            ->setMessage('Hello World ;)');
    }

    public function testGetAction()
    {
        $status = FrontController::STATUS_OK;
        $name = $this->kernel->getRequest()->getArgument('name', 'Anonymous');
        $rand = $this->kernel->getRequest()->getArgument('random', 'false');
        if ($rand && $rand=='true') {
            $name .= '_' . time();
            $status = FrontController::STATUS_UNEXPECTED_RESULT;
        }
        $this->kernel
            ->setStatus($status)
            ->setMessage(
                sprintf('Hello %s ;)', $name)
            );
    }

    public function testPostAction()
    {
        $status = FrontController::STATUS_OK;
        $name = $this->kernel->getRequest()->getData('name', 'Anonymous');
        $rand = $this->kernel->getRequest()->getArgument('random', 'false');
        if ($rand && $rand=='true') {
            $name .= '_' . time();
            $status = FrontController::STATUS_UNEXPECTED_RESULT;
        }
        $this->kernel
            ->setStatus($status)
            ->setMessage(
                sprintf('Hello %s ;)', $name)
            );
    }

    public function testNotFoundAction()
    {
        // something was not found ...
        throw new NotFoundException('Test of not found error');
    }

    public function testBadRequestAction()
    {
        // something was not understood in the request or is missing ...
        throw new BadRequestException('Test of bad request');
    }

    public function testTreatmentErrorAction()
    {
        // something causes an error during data treatment ...
        throw new TreatmentException('Test of treatment error');
    }

    public function testInternalErrorAction()
    {
        // something went really wrong ...
        throw new ErrorException('Test of internal server error');
    }

}

// Endfile
