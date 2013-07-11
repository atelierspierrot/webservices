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

class DefaultController extends AbstractController
{

// ------------------------
// Actions
// ------------------------

    public function indexAction()
    {
    }

    public function helloworldAction()
    {
        $this->kernel
            ->setStatus(FrontController::STATUS_OK)
            ->setMessage('Hello World ;)');
    }

    public function testGetAction()
    {
        $name = $this->kernel->getRequest()->getArgument('name', 'Anonymous');
        $this->kernel
            ->setStatus(FrontController::STATUS_OK)
            ->setMessage(
                sprintf('Hello %s ;)', $name)
            );
    }

    public function testPostAction()
    {
        $name = $this->kernel->getRequest()->getData('name', 'Anonymous');
        $this->kernel
            ->setStatus(FrontController::STATUS_OK)
            ->setMessage(
                sprintf('Hello %s ;)', $name)
            );
    }

}

// Endfile
