<?php
/**
 * WebServices - PHP package
 * Copyleft (c) 2013 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <https://github.com/atelierspierrot/webservices>
 */
namespace WebServices;

use Library\Helper\Url as UrlHelper;

/**
 * The global request class
 *
 * This is the global request instance of the application
 *
 * @author 		Piero Wbmstr <piero.wbmstr@gmail.com>
 */
class Request
{

	/**
	 * The URL to work on
	 *
	 * @see current_url()
	 */
	var $url;

	/**
	 * The GET arguments
	 */
	var $get;

	/**
	 * The current user SESSION
	 */
	var $session;

	/**
	 * Constructor : defines the current URL and gets the routes
	 */
	public function __construct()
	{
		$this->url = UrlHelper::getRequestUrl();
		$this->get = $_GET;
		$this->session = $_SESSION;
	}

	/**
	 * Get the value of a specific argument from current parsed URL
	 *
	 * @param string $param The parameter name if so, or 'args' to get all parameters values
	 * @param const $flags The PHP flags used with htmlentities() (default is ENT_QUOTES)
	 * @param string $encoding The encoding used with htmlentities() (default is UTF-8)
	 * @return string The cleaned value
	 */
	public function cleanArg($arg_value, $flags = ENT_QUOTES, $encoding = 'UTF-8') 
	{
		if (is_string($arg_value)) {
	  		$result = stripslashes( htmlentities($arg_value, $flags, $encoding) );
		} elseif (is_array($arg_value)) {
			$result = array();
			foreach($arg_value as $arg=>$value) {
				$result[$arg] = $this->cleanArg($value, $flags, $encoding);
			}
		}
	  	return $result;
	}

	/**
	 * Get the value of a specific argument from current parsed URL
	 *
	 * @param string $param The parameter name if so, or 'args' to get all parameters values
	 * @param misc $default The default value sent if the argument is not setted
	 * @param bool $clean Clean the argument before return ? (default is true)
	 * @param const $flags The PHP flags used with htmlentities() (default is ENT_QUOTES)
	 * @param string $encoding The encoding used with htmlentities() (default is UTF-8)
	 * @return string The value retrieved, $default otherwise
	 */
	public function getArg($param = null, $default = false, $clean = true, $clean_flags = ENT_QUOTES, $clean_encoding = 'UTF-8') 
	{
  		if (!empty($this->get) && isset($this->get[$param])) {
			return true===$clean ? $this->cleanArg($this->get[$param], $clean_flags, $clean_encoding) : $this->get[$param];
  		}
	  	return $default;
	}

}

// Endfile