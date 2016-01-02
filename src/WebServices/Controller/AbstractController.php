<?php
/**
 * This file is part of the WebServices package.
 *
 * Copyright (c) 2013-2016 Pierre Cassat <me@e-piwi.fr> and contributors
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
 * @author  piwi <me@e-piwi.fr>
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
    protected function init()
    {
    }
}
