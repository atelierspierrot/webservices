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
use \WebServices\AbstractFrontControllerAware;

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
 * @author      Piero Wbmstr <me@e-piwi.fr>
 */
abstract class AbstractController
    extends AbstractFrontControllerAware
{

    /**
     * Path of a file containing the "usage" info of the webservice controller
     *
     * File can be named with extension '.md' or '.md.php' to be parsed by the
     * [Markdown Extended](http://github.com/piwi/markdown-extended) parser.
     *
     * File can be named with final extension '.php' to be compiled by PHP knowing that
     * a set of environment variables are exported as PHP properties.
     * See `WebServices\FrontController::parseUsageFilepath()` method.
     *
     * @var null|string
     * @see \WebServices\FrontController::parseUsageFilepath()
     */
    public $usage_filepath = null;

    /**
     * @param \WebServices\FrontController $kernel
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
