<?php
/**
 * WebServices - PHP package
 * Copyleft (c) 2013 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <https://github.com/atelierspierrot/webservices>
 */
namespace WebServices\Controller;

use WebServices\FrontController,
    WebServices\AbstractFrontControllerAware;

/**
 * Any package or custom controller must extend this basic class
 * 
 * It defines the global `FrontController` you can access in any controller's method
 * with `$this->kernel` or `$this->getFrontController()`.
 * 
 * The magic constructor of this mother class will call any `init()` protected method defined
 * in the children. You can use this method as a children constructor.
 * 
 * You can define an object `$usage_filepath` variable on the absolute path of a usage info
 * to be displayed using the `action=usage` call.
 * 
 * @author      Piero Wbmstr <piero.wbmstr@gmail.com>
 */
abstract class AbstractController extends AbstractFrontControllerAware
{

    /**
     * Path of a file containing the "usage" info of the webservice controller
     *
     * File can be named with extension '.md' or '.md.php' to be parsed by the
     * [Markdown Extended](http://github.com/atelierspierrot/markdown-extended) parser.
     *
     * File can be named with final extension '.php' to be compiled by PHP knowning that
     * a set of environement variables are exported as PHP properties.
     * See `WebServices\FrontController::parseUsageFilepath()` method.
     *
     * @var null|string
     * @see WebServices\FrontController::parseUsageFilepath()
     */
    public $usage_filepath = null;

    /**
     * @param object WebServices\FrontController
     */
    public function __construct(FrontController $kernel)
    {
        $this->setFrontController($kernel);
        $this->init();
    }

    /**
     * Method to use as children constructor ; this method is called for each object creation
     */
    protected function init() {}

}

// Endfile
