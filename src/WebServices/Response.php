<?php
/**
 * WebServices - PHP package
 * Copyleft (c) 2013 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <https://github.com/atelierspierrot/webservices>
 */
namespace WebServices;

use Library\Converter\Html2Text;

/**
 * The global response class
 *
 * This is the global response of the application
 *
 * @author 		Piero Wbmstr <piero.wbmstr@gmail.com>
 */
class Response
{

    const STATUS_OK = '200 OK';
    const STATUS_BAD_REQUEST = '400 Bad Request';
    const STATUS_NOT_FOUND = '404 Not Found';
    const STATUS_UNPROCESSABLE_ENTITY = '422 Unprocessable Entity';
    const STATUS_ERROR = '500 Internal Server Error';

    protected $protocol = 'HTTP/1.1';

    protected $status;

    protected $headers = array();

	/**
	 * The response contents
	 */
	protected $contents = array();

	/**
	 * The response character set
	 */
	protected $charset = 'utf-8';

	/**
	 * The content type
	 */
	protected $content_type = 'application/json';

	/**
	 */
	static $content_types = array(
		'html' => 'text/html',
		'text' => 'text/plain',
		'css' => 'text/css',
		'xml' => 'application/xml',
		'javascript' => 'application/x-javascript',
	);

	/**
	 * Constructor : defines the current URL and gets the routes
	 */
	public function __construct($content = null, $charset = null)
	{
	    if (!empty($content)) {
	        if (is_array($content)) $this->setContent($content);
	        else $this->addContent(null, $content);
	    }
	    if (!empty($charset)) $this->setCharset($charset);
	}

    public function __toString()
    {
        return $this->send(true);
    }

// ----------------------
// Setters / Getters
// ----------------------

	/**
	 */
	public function setProtocol($value) 
	{
		$this->protocol = $value;
		return $this;
	}

	/**
	 */
	public function getProtocol() 
	{
		return $this->protocol;
	}

	/**
	 */
	public function setHeaders(array $headers) 
	{
		$this->headers = $headers;
		return $this;
	}

	/**
	 */
	public function addHeader($header, $value) 
	{
		$this->headers[$header] = $value;
		return $this;
	}

	/**
	 */
	public function getHeader($header, $default = null) 
	{
		return isset($this->headers[$header]) ? $this->headers[$header] : $default;
	}

	/**
	 */
	public function getHeaders() 
	{
		return $this->headers;
	}

	/**
	 */
	public function setStatus($flag) 
	{
		$this->status = $flag;
		return $this;
	}

	/**
	 */
	public function getStatus() 
	{
		return $this->status;
	}

	/**
	 */
	public function setCharset($string) 
	{
		$this->charset = $string;
		return $this;
	}

	/**
	 */
	public function getCharset() 
	{
		return $this->charset;
	}

	/**
	 */
	public function addContent($name, $content) 
	{
	    if (is_null($name)) {
    		array_push($this->contents, $content);
	    } else {
    		$this->contents[$name] = $content;
	    }
		return $this;
	}

	/**
	 */
	public function setContents(array $contents) 
	{
		$this->contents = array_merge($this->contents, $contents);
		return $this;
	}

	/**
	 */
	public function getContent($name, $default = null) 
	{
		return isset($this->contents[$name]) ? $this->contents[$name] : $default;
	}

	/**
	 */
	public function getContents() 
	{
		return $this->contents;
	}

	/**
	 */
	public function setContentType( $type ) 
	{
		if (array_key_exists($type, self::$content_types))
			$this->content_type = self::$content_types[ $type ];
	}

// ----------------------
// Send
// ----------------------

	/**
	 * Send the response to the device
	 */
	public function send($return_string = false) 
	{
        self::header($this->getProtocol() . ' ' . $this->getStatus());
		self::header('Content-type: '.$this->content_type.'; charset='.strtoupper($this->getCharset()));
        foreach ($this->getHeaders() as $header=>$name) {
            self::header("$header: $name");
        }

		if ($this->content_type=='application/json') {
        	$response = json_encode((array) $this->contents);
		} elseif ($this->content_type=='text/plain') {
			$_escaped_output = strip_tags((string) $this->contents);
			if ($_escaped_output != (string) $this->contents) {
				if (preg_match('/(.*)<body(.*)</body>/i', (string) $this->contents, $matches)) {
					$_output = $matches[0];
				} else {
					$_output = (string) $this->contents;
				}
				$response = Html2Text::convert($_output);
			}
		} else {
    		$response = (string) $this->contents;
		}

        if ($return_string) {
            return $response;
        } else {
            echo $response;
    		exit("\n");
        }
	}

	/**
	 * Force device to download a file
	 */
	public function download($file = null, $type = null, $file_name = null) 
	{
		if (!empty($file) && @file_exists($file)) {
			if (is_null($file_name)) 
			  $file_name = end( explode('/', $file) );
			self::header("Content-disposition: attachment; filename=".$file_name);
			self::header("Content-Type: application/force-download");
			self::header("Content-Transfer-Encoding: $type\n");
			self::header("Content-Length: ".filesize($file));
			self::header("Pragma: no-cache");
			self::header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
			self::header("Expires: 0"); 
			readfile( $file );
			exit;
		}
		return;
	}

	/**
	 * Flush (display) a file content
	 */
	public function flush($file_content = null, $type = null) 
	{
		if (!empty($file_content)) {
			if (empty($type)) {
				$finfo = new \finfo();
				$type = $finfo->buffer($file_content, FILEINFO_MIME);
	    	}
			self::header("Content-Type: $type");
			echo $file_content;
			exit;
		}
		return;
	}

	/**
	 * Writes a header string if headers had not been sent
	 *
	 * @param string $str The header string
	 */
	public static function header($str)
	{
		if (!headers_sent()) header($str);
	}

}

// Endfile