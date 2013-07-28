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

abstract class AbstractController
{

    /**
     * Path of a file containing the "usage" info of the webservice controller
     *
     * File can be named with extension '.md' or '.md.php' to be parsed by the
     * [Markdown Extended](http://github.com/atelierspierrot/markdown-extended) parser.
     *
     * @var null|string
     */
    public $usage_filepath = null;

    /**
     * @var WebServices\FrontController
     */
    protected $kernel;

    /**
     * @param object WebServices\FrontController
     */
    public function __construct(FrontController $kernel)
    {
        $this->kernel = $kernel;
        $this->init();
    }

    /**
     * Method to use as children constructor ; this method is called for each object creation
     */
    protected function init() {}

}

// Endfile