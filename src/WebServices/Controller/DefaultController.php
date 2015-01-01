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
namespace WebServices\Controller;

use \WebServices\FrontController;
use \WebServices\Exception;
use \WebServices\ErrorException;
use \WebServices\NotFoundException;
use \WebServices\BadRequestException;
use \WebServices\TreatmentException;
use \Library\HttpFundamental\Request;
use \Library\HttpFundamental\Response;

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
