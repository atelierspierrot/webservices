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
 * @author      Piero Wbmstr <piero.wbmstr@gmail.com>
 */
class Request
{

    /**
     * The URL to work on
     * @var string
     * @see \Library\Helper\Url::getRequestUrl()
     */
    protected $url;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var array
     */
    protected $headers;

    /**
     * The GET arguments
     * @var array
     */
    protected $arguments;

    /**
     * The POST arguments
     * @var array
     */
    protected $data;

    /**
     * The FILES arguments
     * @var array
     */
    protected $files;

    /**
     * The current user SESSION
     * @var array
     */
    protected $session;

    /**
     * The current COOKIES
     * @var array
     */
    protected $cookies;

    /**
     * Constructor : defines the current URL and gets the routes
     *
     * @param string $url
     * @param array $arguments
     * @param array $data
     * @param array $session
     * @param array $files
     * @param array $cookies
     */
    public function __construct(
        $url = null, $method = 'get', array $arguments = null, array $headers = null,
        array $data = null, $session = null, array $files = null, array $cookies = null
    ) {
        if (is_null($url)) {
            $url = UrlHelper::getRequestUrl();
            $headers = getallheaders();
            $method = $_SERVER['REQUEST_METHOD'];
            $arguments = $_GET;
            $data = $_POST;
            $session = $_SESSION;
            $files = $_FILES;
            $cookies = $_COOKIES;
        }
        $this
            ->setUrl($url)
            ->setArguments($arguments)
            ->setData($data)
            ->setSession($session)
            ->setFiles($files)
            ->setCookies($cookies)
            ->setHeaders($headers)
            ->setMethod($method);
    }

// -----------------------
// Setter / Getter
// -----------------------

    /**
     * @param string $url
     * @return self
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $method
     * @return self
     */
    public function setMethod($method)
    {
        $this->method = strtolower($method);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param array $headers
     * @return self
     */
    public function setHeaders(array $headers = null)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param string $name
     * @return string|null
     */
    public function getHeader($name) 
    {
        return (!empty($this->headers) && array_key_exists($name, $this->headers)) ? $this->headers[$name] : null;
    }

    /**
     * @param array $arguments
     * @return self
     */
    public function setArguments(array $arguments = null)
    {
        $this->arguments = $arguments;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param string $param The parameter name if so, or 'args' to get all parameters values
     * @param misc $default The default value sent if the argument is not setted
     * @param bool $clean Clean the argument before return ? (default is true)
     * @param const $flags The PHP flags used with htmlentities() (default is ENT_QUOTES)
     * @param string $encoding The encoding used with htmlentities() (default is UTF-8)
     * @return string The value retrieved, $default otherwise
     */
    public function getArgument($param = null, $default = false, $clean = true, $clean_flags = ENT_QUOTES, $clean_encoding = 'UTF-8') 
    {
        if (!empty($this->arguments) && array_key_exists($param, $this->arguments)) {
            return true===$clean ?
                $this->cleanArgument($this->arguments[$param], $clean_flags, $clean_encoding) : $this->arguments[$param];
        }
        return $default;
    }

    /**
     * @param array $data
     * @return self
     */
    public function setData(array $data = null)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param string $param The parameter name if so, or 'args' to get all parameters values
     * @param misc $default The default value sent if the argument is not setted
     * @param bool $clean Clean the argument before return ? (default is true)
     * @param const $flags The PHP flags used with htmlentities() (default is ENT_QUOTES)
     * @param string $encoding The encoding used with htmlentities() (default is UTF-8)
     * @return string|array|null
     */
    public function getData($param = null, $default = false, $clean = true, $clean_flags = ENT_QUOTES, $clean_encoding = 'UTF-8')
    {
        if (is_null($param)) {
            return $this->data;
        } else {
            if (!empty($this->data) && array_key_exists($param, $this->data)) {
                return true===$clean ? 
                    $this->cleanArgument($this->data[$param], $clean_flags, $clean_encoding) : $this->data[$param];
            }
            return $default;
        }
    }

    /**
     * @param array $files
     * @return self
     */
    public function setFiles(array $files = null)
    {
        $this->files = $files;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param string $param
     * @return array|null
     */
    public function getFile($param, $index = null) 
    {
        if (!empty($this->files) && array_key_exists($param, $this->files)) {
            if (!empty($index)) {
                return isset($this->files[$param][$index]) ? $this->files[$param][$index] : null;
            } else {
                return $this->files[$param];
            }
        }
        return null;
    }

    /**
     * @param array $session
     * @return self
     */
    public function setSession(array $session = null)
    {
        $this->session = $session;
        return $this;
    }

    /**
     * @param string $param
     * @return array|null
     */
    public function getSession($param = null)
    {
        if (is_null($param)) {
            return $this->session;
        } else {
            return (!empty($this->session) && array_key_exists($param, $this->session)) ? $this->session[$param] : null;
        }
    }

    /**
     * @param array $cookies
     * @return self
     */
    public function setCookies(array $cookies = null)
    {
        $this->cookies = $cookies;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * @param string $param
     * @return array|null
     */
    public function getCookie($param)
    {
        return (!empty($this->cookies) && array_key_exists($param, $this->cookies)) ? $this->cookies[$param] : null;
    }

    /**
     * @param string $varname
     * @return misc|false
     */
    public function getEnv($varname)
    {
        return getenv($varname);
    }

    /**
     * @return string
     */
    public static function getUserIp()
    { 
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; 
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

// -----------------------
// Aliases
// -----------------------

    /**
     * @return bool
     */
    public static function isAjax()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'));
    }
    
	/**
     * @return bool
	 */
	public function isCli() 
	{
	  	return php_sapi_name()=='cli';
	}

	/**
     * @return bool
	 */
	public function isGet() 
	{
	  	return $this->getMethod()==='get';
	}

	/**
     * @return bool
	 */
	public function isPost() 
	{
	  	return $this->getMethod()==='post';
	}

	/**
     * @return bool
	 */
	public function isPut() 
	{
	  	return $this->getMethod()==='put';
	}

    /**
     * @param string $varname
     * @return misc|false
     */
    public function getGet($varname, $default = null)
    {
        return $this->getArgument($varname, $default);
    }

    /**
     * @param string $varname
     * @return misc|false
     */
    public function getPost($varname, $default = null)
    {
        return $this->getData($varname, $default);
    }

    /**
     * @param string $varname
     * @return misc|false
     */
    public function getGetOrPost($varname, $default = null)
    {
        $get = $this->getArgument($varname, $default);
        if (empty($get)) {
            return $get;
        }
        return $this->getData($varname, $default);
    }

    /**
     * @param string $varname
     * @return misc|false
     */
    public function getPostOrGet($varname, $default = null)
    {
        $post = $this->getData($varname, $default);
        if (empty($post)) {
            return $post;
        }
        return $this->getArgument($varname, $default);
    }

// -----------------------
// Helper
// -----------------------

    /**
     * Clean the value taken from request arguments or data
     *
     * @param string $param The parameter name if so, or 'args' to get all parameters values
     * @param const $flags The PHP flags used with htmlentities() (default is ENT_QUOTES)
     * @param string $encoding The encoding used with htmlentities() (default is UTF-8)
     *
     * @return string The cleaned value
     */
    public static function cleanArgument($arg_value, $flags = ENT_QUOTES, $encoding = 'UTF-8') 
    {
        if (is_string($arg_value)) {
            $result = stripslashes( htmlentities($arg_value, $flags, $encoding) );
        } elseif (is_array($arg_value)) {
            $result = array();
            foreach($arg_value as $arg=>$value) {
                $result[$arg] = self::cleanArg($value, $flags, $encoding);
            }
        }
        return $result;
    }

}

// Endfile
