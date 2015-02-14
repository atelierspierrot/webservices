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
