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
    Library\Logger as BaseLogger;

class FrontController
    extends AbstractSingleton implements StaticCreatorInterface
{

    const STATUS_INTERNAL_ERROR     = -1;
    const STATUS_OK                 = 0;
    const STATUS_UNEXPECTED_RESULT  = 1;
    const STATUS_REQUEST_ERROR      = 2;
    const STATUS_TREATMENT_ERROR    = 3;

    static $default_messages = array(
        -1  =>'Internal server error',
        0   =>'OK',
        1   =>'Unexpected result',
        2   =>'Request error',
        3   =>'Treatment error'
    );

    protected $user_options;
    protected $response;
    protected $request;
    protected $logger;
    protected $controller;

    protected $headers = array(
        'Connection' => 'keep-alive',
        'Cache-Control' => 'max-age=0, private, must-revalidate'
	);

// ------------------------
// Creation / Instance
// ------------------------

    /**
     * Initializer : this method is called after any instance creation
     */
    protected function init(Request $request = null, Response $response = null, array $user_options = array())
    {
        if (!isset($user_options['tmp_directory'])) {
            $ini_path = sys_get_temp_dir();
            $user_options['tmp_directory'] = 
                !empty($ini_path) ? $ini_path : __DIR__.'/../tmp';
        }
        if (!isset($user_options['log_directory'])) {
            $ini_path = ini_get('error_log');
            $user_options['log_directory'] = 
                !empty($ini_path) ? $ini_path : __DIR__.'/../tmp/logs';
        }
        $this->setUserOptions($user_options);
        foreach (array('tmp_directory', 'log_directory') as $_dir) {
            DirectoryHelper::ensureExists($this->getOption($_dir));
        }
        $this->setLogger(
            new Logger($this->getLoggerOptions())
        );
        if (!is_null($request)) $this->setRequest($request);
        if (!is_null($response)) $this->setResponse($response);
    }

	public static function create(Request $request = null, Response $response = null, array $user_options = array())
	{
	    return self::getInstance($request, $response, $user_options);
	}

// ------------------------
// Distribution
// ------------------------

	/**
	 * Distributes the application actions
	 */
	public function distribute()
	{
	    $this->getLogger()->log(
	        sprintf('[BEGIN] Handling request %s', $this->getRequest()->url),
	        BaseLogger::INFO
	    );
	    $this->callController(
	        $this->getRequest()->getArg('ws', 'DefaultController')
	    );
	    $this->callControllerMethod(
	        $this->getRequest()->getArg('action', 'index')
	    );
	    $this->getLogger()->log(
	        sprintf('[END] Handling request %s', $this->getRequest()->url),
	        BaseLogger::INFO
	    );
        $this->display();
	}

	/**
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

    public function setUserOptions(array $options = null)
    {
        $this->user_options = $options;
        return $this;
    }

    public function getUserOptions()
    {
        return $this->user_options;
    }

    public function setOption($name, $value)
    {
        $this->user_options[$name] = $value;
        return $this;
    }

    public function getOption($name)
    {
        return isset($this->user_options[$name]) ? $this->user_options[$name] : null;
    }

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
        return $log_opts;
    }

    public function setStatus($flag)
    {
        $this->getResponse()->addContent('status', $flag);
        return $this;
    }

    public function getStatus()
    {
        return $this->getResponse()->getContent('status');
    }

    public function setMessage($string)
    {
        $this->getResponse()->addContent('message', $string);
        return $this;
    }

    public function getMessage()
    {
        return $this->getResponse()->getContent('message');
    }

    public function addContent($name, $string)
    {
        $this->getResponse()->addContent($name, $string);
        return $this;
    }

    public function getContent($name)
    {
        return $this->getResponse()->getContent($name);
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function setResponse(Response $response)
    {
        $this->response = $response;
        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
        return $this;
    }

    public function getLogger()
    {
        return $this->logger;
    }

    public function setController(Controller\AbstractController $controller)
    {
        $this->controller = $controller;
        return $this;
    }

    public function getController()
    {
        return $this->controller;
    }

}

// Endfile