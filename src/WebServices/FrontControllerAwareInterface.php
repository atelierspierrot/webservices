<?php
/**
 * WebServices - PHP package
 * Copyleft (c) 2013-2014 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <http://github.com/atelierspierrot/webservices>
 */
namespace WebServices;

use \WebServices\FrontController;

/**
 * This interface should be implemented by any object depending on the `\WebServices\FrontController` object
 * 
 * @author      Piero Wbmstr <me@e-piwi.fr>
 */
interface FrontControllerAwareInterface
{

    /**
     * @param \WebServices\FrontController $kernel
     */
    public function setFrontController(FrontController $kernel = null);

}

// Endfile
