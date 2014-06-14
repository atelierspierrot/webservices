<?php
/**
 * WebServices - PHP package
 * Copyleft (c) 2013-2014 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <http://github.com/atelierspierrot/webservices>
 */
namespace WebServices;

use WebServices\FrontController;

/**
 * This class designs an object depending on the `WebServices\FrontController` object
 * 
 * Keep in mind that the FrontController instance in the object is stored in the `$kernel`
 * property.
 * 
 * @author      Piero Wbmstr <me@e-piwi.fr>
 */
abstract class AbstractFrontControllerAware implements FrontControllerAwareInterface
{

    /**
     * @var WebServices\FrontController
     */
    protected $kernel;

    /**
     * @param object|null A `WebServices\FrontController` instance
     * 
     * @return self
     */
    public function setFrontController(FrontController $kernel = null)
    {
        $this->kernel = $kernel;
        return $this;
    }

    /**
     * @return object|null The `WebServices\FrontController` instance loaded in the object
     */
    public function getFrontController()
    {
        return $this->kernel;
    }

}

// Endfile
