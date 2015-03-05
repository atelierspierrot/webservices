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

use \Patterns\Commons\HttpStatus;

/**
 * @author      Piero Wbmstr <me@e-piwi.fr>
 */
class NotFoundException
    extends Exception
{

    /**
     * Construction of the exception - a message is needed (1st argument)
     *
     * @param string $message The exception message
     * @param int $code The exception code
     * @param \Exception $previous The previous exception if so
     */
    public function __construct($message = '', $code = 0, \Exception $previous = null)
    {
        if (empty($message)) $message = 'Not found';
        parent::__construct($message, $code, $previous);
        $this->webservices
            ->setStatus(FrontController::STATUS_REQUEST_ERROR)
            ->setMessage($this->getMessage())
            ->getResponse()->setStatus(HttpStatus::NOT_FOUND);
    }

}

// Endfile
