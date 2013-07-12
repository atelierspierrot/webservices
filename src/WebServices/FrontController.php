<?php
/**
 * WebServices - PHP package
 * Copyleft (c) 2013 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <https://github.com/atelierspierrot/webservices>
 */
namespace WebServices;

use Patterns\Interfaces\StaticCreatorInterface,
    Patterns\Abstracts\AbstractSingleton;

use Library\Helper\Url as UrlHelper,
    Library\Helper\Directory as DirectoryHelper,
    Library\Logger;

class FrontController
    extends AbstractSingleton implements StaticCreatorInterface
{

    /**
     * Status shortcut constant for internal error
     *
     * This one is used by PHP Exceptions during process
     * @const int
     */
    const STATUS_INTERNAL_ERROR     = -1;

    /**
     * Status shortcut constant for no error
     * @const int
     */
    const STATUS_OK                 = 0;

    /**
     * Status shortcut constant for no error but unexcpected ending or values
     * @const int
     */
    const STATUS_UNEXPECTED_RESULT  = 1;

    /**
     * Status shortcut constant for request error (arguments, 404 ...)
     * @const int
     */
    const STATUS_REQUEST_ERROR      = 2;

    /**
     * Status shortcut constant for process error (not PHP error but process of data)
     * @const int
     */
    const STATUS_TREATMENT_ERROR    = 3;

    /**
     * Default messages for result status as `status=>info` pairs
     * @static array
     */
    static $default_messages = array(
        -1  =>'Internal server error',
        0   =>'OK',
        1   =>'Unexpected result',
        2   =>'Request error',
        3   =>'Treatment error'
    );

    /**
     * Options passed to constructor
     * @var array
     */
    protected $user_options;

    /**
     * @var \WebServices\Response
     */
    protected $response;

    /**
     * @var \WebServices\Request
     */
    protected $request;

    /**
     * @var \WebServices\Logger
     */
    protected $logger;

    /**
     * @var \WebServices\Controller\AbstractController
     */
    protected $controller;

    /**
     * @var array
     */
    protected $headers = array(
        'Connection' => 'keep-alive',
        'Cache-Control' => 'max-age=0, private, must-revalidate',
        'X-XSS-Protection' => '1; mode=block',
    );

// ------------------------
// Creation / Instance / Dependencies
// ------------------------

    /**
     * Default options
     *
     * @return array
     */
    protected function extendOptions(array $user_options = array())
    {
        if (!array_key_exists('tmp_directory', $user_options)) {
            $ini_path = sys_get_temp_dir();
            $user_options['tmp_directory'] = 
                !empty($ini_path) ? $ini_path : __DIR__.'/../tmp';
        }
        if (!array_key_exists('log_directory', $user_options)) {
            $ini_path = ini_get('error_log');
            $user_options['log_directory'] = 
                !empty($ini_path) ? $ini_path : __DIR__.'/../tmp/logs';
        }
        if (!array_key_exists('error_log_mask', $user_options)) {
            $user_options['error_log_mask'] = '{type} with code {code}: "{message}" in file {file} at line {line}';
        }
        if (!array_key_exists('enable_logging', $user_options)) {
            $user_options['enable_logging'] = false;
        }
        if (!array_key_exists('enable_url_rewrite', $user_options)) {
            $user_options['enable_url_rewrite'] = false;
        }
        return $user_options;
    }

    /**
     * Initializer : this method is called after any instance creation
     *
     * @param object $request \WebServices\Request
     * @param object $response \WebServices\Response
     * @param array $user_options
     */
    protected function init(Request $request = null, Response $response = null, array $user_options = array())
    {
        $this->setUserOptions(
            $this->extendOptions($user_options)
        );
        foreach (array('tmp_directory', 'log_directory') as $_dir) {
            DirectoryHelper::ensureExists($this->getOption($_dir));
        }
        $this->setLogger(
            new Logger($this->getLoggerOptions())
        );
        if (!is_null($request)) $this->setRequest($request);
        if (!is_null($response)) $this->setResponse($response);
        if ($this->getOption('enable_url_rewrite')===true) {
            $query = $_SERVER['QUERY_STRING'];
            $args = array();
            $index = null;
            foreach (explode('/', $query) as $count=>$part) {
                if (is_null($index)) {
                    $index = $part;
                } else {
                    $args[$index] = $part;
                    $index = null;
                }
            }
            $request = $this->getRequest();
            $get = $request->getArguments();

var_export($query);
echo '<br />'.PHP_EOL;
var_export($_GET);
echo '<br />'.PHP_EOL;
var_export($args);
echo '<br />'.PHP_EOL;
var_export($get);
echo '<br />'.PHP_EOL;
var_export(array_merge($get, $args));
echo '<br />'.PHP_EOL;
var_export($_SERVER['PHP_AUTH_USER']);
exit('yo');

            $request->setArguments(
                !is_null($get) ? array_merge($get, $args) : $args
            );
        }
    }

    /**
     * Creation of a singleton instance
     *
     * @param object $request \WebServices\Request
     * @param object $response \WebServices\Response
     * @param array $user_options
     *
     * @return self
     */
    public static function create(Request $request = null, Response $response = null, array $user_options = array())
    {
        return self::getInstance($request, $response, $user_options);
    }

    /**
     * Shrotcut for logging message
     *
     * @param string $message
     * @param array $context
     * @param string $logname
     *
     * @return bool The result of `\WebServices\Logger::log()`
     */
    public static function log($message, array $context = array(), $level = Logger::INFO, $logname = null)
    {
        $_this = self::getInstance();
        if ($_this->getOption('enable_logging')===false) return;
        $default_context = array(
            'url' => $_this->getRequest()->getUrl()
        );
        return self::getInstance()->getLogger()
            ->log($level, $message, array_merge($default_context, $context), $logname);
    }

// ------------------------
// Distribution
// ------------------------

    /**
     * Distributes the application actions
     */
    public function distribute()
    {
        $this->log('[BEGIN] Handling request {url}');
        $this->callController(
            $this->getRequest()->getPostOrGet('ws', 'DefaultController')
        );
        $this->callControllerMethod(
            $this->getRequest()->getPostOrGet('action', 'index')
        );
        $this->log('[END] Handling request {url}');
        $this->display();
    }

    /**
     * Displays the request result
     */
    public function display($return = false) 
    {
        if ($this->getStatus()===null) {
            $this->setStatus(self::STATUS_OK);
        }
        if ($this->getMessage()===null) {
            $this->setMessage(
                array_key_exists($this->getStatus(), self::$default_messages) ? 
                    self::$default_messages[$this->getStatus()] : ''
            );
        }
        if ($this->getResponse()->getStatus()===null) {
            $this->getResponse()->setStatus(Response::STATUS_OK);
        }
        $this->getResponse()->setHeaders($this->headers);
        if ($return) {
            return $this->getResponse();
        } else {
            $this->getResponse()->send();
        }
    }

    /**
     * @param string $name
     *
     * @return bool
     *
     * @throws \WebServices\NotFoundException if class `$name` or `WebServices\Controller\$name`
     *          does not exist
     */
    public function callController($name = 'DefaultController')
    {
        if (class_exists($name)) {
            $this->setController(new $name($this));
            return true;
        } else {
            $long_name = 'WebServices\Controller\\' . $name;
            if (class_exists($long_name)) {
                $this->setController(new $long_name($this));
                return true;
            }
        }
        throw new NotFoundException(sprintf("Unknown webservice '%s'!", $name));
    }

    /**
     * @param string $method
     *
     * @return bool
     *
     * @throws \WebServices\NotFoundException if method `$method` does not exist in 
     *          object `$this->controller`
     */
    public function callControllerMethod($method = 'index')
    {
        $action_meth = $method.'Action';
        if (method_exists($this->getController(), $action_meth)) {
            call_user_func(array($this->getController(), $action_meth));
            return true;
        }
        throw new NotFoundException(sprintf("Unknown action '%s' in webservice '%s'!",
            $method, get_class($this->getController())));
    }

// ------------------------
// Getters / Setters
// ------------------------

    /**
     * @param array $options
     * @return self
     */
    public function setUserOptions(array $options = null)
    {
        $this->user_options = $options;
        return $this;
    }

    /**
     * @return array
     */
    public function getUserOptions()
    {
        return $this->user_options;
    }

    /**
     * @param string $name
     * @param misc $value
     * @return self
     */
    public function setOption($name, $value)
    {
        $this->user_options[$name] = $value;
        return $this;
    }

    /**
     * @param string $name
     * @return misc|null
     */
    public function getOption($name)
    {
        return array_key_exists($name, $this->user_options) ? $this->user_options[$name] : null;
    }

    /**
     * @return array
     */
    public function getLoggerOptions()
    {
        $log_opts = array();
        $options = $this->user_options;
        $entries = Logger::getOptions();
        foreach ($options as $var=>$val) {
            if (array_key_exists($var, $entries)) {
                $log_opts[$var] = $val;
            }
        }
        if (!isset($log_opts['directory'])) {
            $log_opts['directory'] = $options['log_directory'];
        }
        return $log_opts;
    }

    /**
     * @param int $status Must be one of the class constants `STATUS_...`
     * @return self
     */
    public function setStatus($flag)
    {
        $this->getResponse()->addContent('status', $flag);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getStatus()
    {
        return $this->getResponse()->getContent('status');
    }

    /**
     * @param string $string
     * @return self
     */
    public function setMessage($string)
    {
        $this->getResponse()->addContent('message', $string);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage()
    {
        return $this->getResponse()->getContent('message');
    }

    /**
     * @param string $name
     * @param misc $value
     * @return self
     */
    public function addContent($name, $value)
    {
        $this->getResponse()->addContent($name, $value);
        return $this;
    }

    /**
     * @return misc
     */
    public function getContent($name)
    {
        return $this->getResponse()->getContent($name);
    }

    /**
     * @param object $request \WebServices\Request
     * @return self
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return \WebServices\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param object $response \WebServices\Response
     * @return self
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @return \WebServices\Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param object $logger \WebServices\Logger
     * @return self
     */
    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * @return \WebServices\Logger
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param object $controller \WebServices\Controller\AbstractController
     * @return self
     */
    public function setController(Controller\AbstractController $controller)
    {
        $this->controller = $controller;
        return $this;
    }

    /**
     * @return \WebServices\Controller\AbstractController
     */
    public function getController()
    {
        return $this->controller;
    }

}

// Endfile