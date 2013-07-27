<?php
/**
 * WebServices - PHP package
 * Copyleft (c) 2013 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <https://github.com/atelierspierrot/webservices>
 */
namespace WebServices\Controller;

use WebServices\FrontController;

use WebServices\Exception,
    WebServices\ErrorException,
    WebServices\NotFoundException,
    WebServices\BadRequestException,
    WebServices\TreatmentException;

use Library\HttpFundamental\Request,
    Library\HttpFundamental\Response;

class DefaultController extends AbstractController
{

// ------------------------
// Actions
// ------------------------

    public function indexAction()
    {
//        fopen();
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
