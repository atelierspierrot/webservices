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
     * Classic URL with arguments as "[script.php]?var=val&var2=val2" pairs
     * @var int
     */
    const NO_REWRITE = 0;

    /**
     * Allow a query string written as "[script.php]/var/val/var2/val2"
     * Allow to cumulate as "[script.php]/var/val?var2=val2"
     * @var int
     */
    const REWRITE_SEGMENTS_QUERY = 1;

    /**
     * @var int
     */
    protected $flag;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $protocol;

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
     * @var array
     */
    protected $authentication = array('type'=>'basic', 'user'=>null, 'pw'=>null);

// -----------------------
// Static
// -----------------------

    /**
     * Constructor : defines the current URL and gets the routes
     *
     * @param string $url
     * @param array $arguments
     * @param array $data
     * @param array $session
     * @param array $files
     * @param array $cookies
     *
     * @return self
     */
    public static function create(
        $url = null, $flag = self::NO_REWRITE,
        $protocol = 'http', $method = 'get', array $headers = null, 
        array $arguments = null, array $data = null, 
        array $session = null, array $files = null, array $cookies = null
    ) {
        $request = new self($url, $flag);
        if (!is_null($protocol)) $request->setProtocol($protocol);
        if (!is_null($method)) $request->setMethod($method);
        if (!is_null($headers)) $request->setHeaders($headers);
        if (!is_null($arguments)) $request->setArguments($arguments);
        if (!is_null($data)) $request->setData($data);
        if (!is_null($session)) $request->setSession($session);
        if (!is_null($files)) $request->setFiles($files);
        if (!is_null($cookies)) $request->setCookies($cookies);
        return $request;
    }

// -----------------------
// Construction
// -----------------------

    /**
     * Constructor : defines the request URL and the object rewrite flag
     *
     * @param string $url
     * @param int $flag Must be one of the class `REWRITE` constants
     */
    public function __construct($url = null, $flag = self::NO_REWRITE)
    {
        $this->setFlag($flag);
        if (is_null($url)) $this->guessFromCurrent();
    }

    /**
     * Populate the request object with current HTTP request values
     *
     * @return self
     * @see \Library\Helper\Url::getRequestUrl()
     */
    public function guessFromCurrent()
    {
        $this
            ->setUrl(UrlHelper::getRequestUrl())
            ->setProtocol(UrlHelper::getHttpProtocol())
            ->setMethod($_SERVER['REQUEST_METHOD'])
            ->setHeaders(getallheaders())
            ->setArguments($_GET)
            ->setData($_POST)
            ->setSession($_SESSION)
            ->setFiles($_FILES)
            ->setCookies($_COOKIE)
            ->setAuthenticationUser($_SERVER['PHP_AUTH_USER'])
            ->setAuthenticationPassword($_SERVER['PHP_AUTH_PW'])
            ->setAuthenticationType(!empty($_SERVER['PHP_AUTH_DIGEST']) ? 'digest' : 'basic')
            ;
        return $this;
    }

// -----------------------
// Setter / Getter
// -----------------------

    /**
     * @param int $flag Must be one of the class `REWRITE` constants
     * @return self
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;
        return $this;
    }

    /**
     * @return int
     */
    public function getFlag()
    {
        return $this->flag;
    }

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
     * @param string $protocol
     * @return self
     */
    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getProtocol()
    {
        return $this->protocol;
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
     * @param string|array $arguments
     * @return self
     */
    public function setArguments($arguments = null)
    {
        if (is_string($arguments)) $this->_extractArguments($arguments);
        if ($this->getFlag() & self::REWRITE_SEGMENTS_QUERY) $this->_extractSegments($arguments);
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
     * @param array|string $data
     * @return self
     */
    public function setData($data = null)
    {
        if (is_string($data)) $this->_extractArguments($data);
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
     * @param array $authentication
     * @return self
     */
    public function setAuthentication(array $authentication = null)
    {
        $this->authentication = $authentication;
        return $this;
    }

    /**
     * @param string $type
     * @return self
     */
    public function setAuthenticationType($type)
    {
        $this->authentication['type'] = $type;
        return $this;
    }

    /**
     * @param string $user
     * @return self
     */
    public function setAuthenticationUser($user)
    {
        $this->authentication['user'] = $user;
        return $this;
    }

    /**
     * @param string $pw
     * @return self
     */
    public function setAuthenticationPassword($pw)
    {
        $this->authentication['pw'] = $pw;
        return $this;
    }

    /**
     * @param string $param
     * @return array|string|null
     */
    public function getAuthentication($param = null)
    {
        if (is_null($param)) {
            return $this->authentication;
        } else {
            return (!empty($this->authentication) && array_key_exists($param, $this->authentication)) ? $this->authentication[$param] : null;
        }
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
// Transformers
// -----------------------

    /**
     * Extract the table of "var=>val" arguments pairs from a query string
     *
     * @param string $arguments (passed and transformed by reference)
     */
    protected function _extractArguments(&$arguments)
    {
        $originals = $arguments;
        parse_str($originals, $arguments);
    }

    /**
     * Extract the table of "var=>val" arguments pairs from a slashed route
     *
     * @param array|string $arguments (passed and transformed by reference)
     */
    protected function _extractSegments(&$arguments)
    {
        if (is_string($arguments)) $this->_extractArguments($arguments);
        foreach ($arguments as $var=>$val) {
            if (empty($val) && strpos($var, '/')!==false) {
                $parts = explode('/', $var);
                unset($arguments[$var]);
                $index = null;
                foreach ($parts as $part) {
                    if (is_null($index)) {
                        $index = $part;
                    } else {
                        $arguments[$index] = $part;
                        $index = null;
                    }
                }
            }
        }
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

    /**
     * @param string $varname
     * @return misc|false
     */
    public static function getEnvironment($varname)
    {
        return getenv($varname);
    }

    /**
     * @return string
     */
    public static function getClientIp()
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

}

// Endfile
