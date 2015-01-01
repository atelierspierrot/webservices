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

use \Library\HttpFundamental\Response;

/**
 * @author      Piero Wbmstr <me@e-piwi.fr>
 */
class TreatmentException extends \WebServices\Exception
{

    /**
     * Construction of the exception - a message is needed (1st argument)
     *
     * @param string $message The exception message
     * @param int $code The exception code
     * @param \Exception $previous The previous exception if so
     */
    public function __construct($message = '', $code = 0, Exception $previous = null)
    {
        if (empty($message)) $message = 'Treatment error';
        parent::__construct($message, $code, $previous);
        $this->webservices
            ->setStatus(FrontController::STATUS_TREATMENT_ERROR)
            ->setMessage($this->getMessage())
            ->getResponse()->setStatus(Response::STATUS_UNPROCESSABLE_ENTITY);
    }

}

// Endfile
