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
        $this->kernel->addContent('yo', 'kh hlqksjdfh');
    }

    public function helloworldAction()
    {
		$name = $this->kernel->getRequest()->getArg('name', 'Anonymous');
        $this->kernel
            ->setStatus(FrontController::STATUS_OK)
            ->setMessage(
                sprintf('Hello %s ;)', $name)
            );
    }

}

// Endfile