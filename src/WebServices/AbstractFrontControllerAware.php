<?php
/**
 * This file is part of the WebServices package.
 *
 * Copyright (c) 2013-2015 Pierre Cassat <me@e-piwi.fr> and contributors
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
namespace WebServices;

/**
 * This class designs an object depending on the `WebServices\FrontController` object
 * 
 * Keep in mind that the FrontController instance in the object is stored in the `$kernel`
 * property.
 * 
 * @author      Piero Wbmstr <me@e-piwi.fr>
 */
abstract class AbstractFrontControllerAware
    implements FrontControllerAwareInterface
{

    /**
     * @var \WebServices\FrontController
     */
    protected $kernel;

    /**
     * @param \WebServices\FrontController $kernel
     * @return self
     */
    public function setFrontController(FrontController $kernel = null)
    {
        $this->kernel = $kernel;
        return $this;
    }

    /**
     * @return \WebServices\FrontController
     */
    public function getFrontController()
    {
        return $this->kernel;
    }

}

// Endfile
