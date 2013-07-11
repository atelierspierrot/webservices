<?php
/**
 * WebServices - PHP package
 * Copyleft (c) 2013 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <https://github.com/atelierspierrot/webservices>
 */
namespace WebServices;

/**
 * @author 		Piero Wbmstr <piero.wbmstr@gmail.com>
 */
class NotFoundException extends \WebServices\Exception
{

	/**
	 * Construction of the exception - a message is needed (1st argument)
	 *
	 * @param string $message The exception message
	 * @param numeric $code The exception code
	 * @param misc $previous The previous exception if so
	 */
    public function __construct($message = '', $code = 0, Exception $previous = null)
    {
		parent::__construct($message, $code, $previous);
        $this->webservices = FrontController::getInstance();

		$string = $this->getMessage();
        $this->webservices
            ->setStatus(FrontController::STATUS_REQUEST_ERROR)
            ->setMessage(!empty($string) ? $string : 'Not found')
            ->getResponse()->setStatus(Response::STATUS_NOT_FOUND);
    }

}

// Endfile