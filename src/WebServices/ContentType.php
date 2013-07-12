<?php
/**
 * WebServices - PHP package
 * Copyleft (c) 2013 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <https://github.com/atelierspierrot/webservices>
 */
namespace WebServices;

use WebServices\ContentTypeInterface,
    WebServices\Response;

use Library\Helper\Text as TextHelper;

/**
 * @author      Piero Wbmstr <piero.wbmstr@gmail.com>
 */
class ContentType
{

    /**
     * @var string
     */
    protected $content_type;

    /**
     * @var object implementing the ResponseTypeInterface
     */
    protected $content_type_object;

    /**
     */
    static $content_types = array(
        'html' => 'text/html',
        'text' => 'text/plain',
        'css' => 'text/css',
        'xml' => 'application/xml',
        'javascript' => 'application/x-javascript',
        'json' => 'application/json',
    );

    /**
     * Create a new ContentType object extracting the type from a content string
     *
     * @param string $content
     * @return self
     */
    public static function createFromContent($content)
    {
        return new self(self::guessContentType($content));
    }
    
    /**
     * @param string $content
     * @return string
     */
    public static function guessContentType($content)
    {
        $finfo = new \finfo();
        return $finfo->buffer($content, FILEINFO_MIME);
    }

    /**
     * Constructor : defines the current URL and gets the routes
     *
     * @param string $content_type
     */
    public function __construct($content_type)
    {
        $this->prepareContentType($content_type);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getContentType();
    }

// ----------------------
// Setters / Getters
// ----------------------

    /**
     * @param string $content_type
     * @return self
     * @throws Excpetion if the content_type was not declared and unknown
     */
    public function setContentType($content_type) 
    {
        if (in_array($content_type, self::$content_types)) {
            $this->content_type = $content_type;
        } elseif (array_key_exists($content_type, self::$content_types)) {
            $this->content_type = self::$content_types[$content_type];
        } else {
            throw new \Exception(
                sprintf('Unknown content type "%s"!', $content_type)
            );
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getContentType() 
    {
        return $this->content_type;
    }

    /**
     * @param object $content_type_object Must implement the `ContentTypeInterface`
     * @return self
     */
    public function setContentTypeObject(ContentTypeInterface $content_type_object) 
    {
        $this->content_type_object = $content_type_object;
        $this->setContentType($this->content_type_object->getContentType());
        return $this;
    }

    /**
     * @return object|null Object implementing the `ContentTypeInterface`
     */
    public function getContentTypeObject() 
    {
        return $this->content_type_object;
    }

// ----------------------
// Process
// ----------------------

    /**
     * @param string $content_type
     * @return self
     */
    public function prepareContentType($content_type) 
    {
        $_cls = '\WebServices\ContentType\\'.TextHelper::toCamelCase($content_type);
        if (class_exists($_cls)) {
            return $this->setContentTypeObject(new $_cls);
        } else {
            return $this->setContentType($content_type);
        }
    }

    /**
     * Prepare the content of the response before to send it to client
     *
     * @param object $response \WebServices\Response
     * @return void
     */
    public function prepareResponse(Response $response)
    {
        $cto = $this->getContentTypeObject();
        if (!empty($cto)) {
            $ctt_type = $cto->getContentType();
        } else {
            $ctt_type = $this->getContentType();
        }
        $response->setContentType($ctt_type);
    }

    /**
     * Parse an input content
     *
     * @param string $content
     * @return misc
     */
    public function parseContent($content)
    {
        $cto = $this->getContentTypeObject();
        if (!empty($cto)) {
            return $cto->parseContent($content);
        } else {
            return $content;
        }
    }

    /**
     * Prepare a content for output
     *
     * @param misc $content
     * @return string
     */
    public function prepareContent($content)
    {
        $cto = $this->getContentTypeObject();
        if (!empty($cto)) {
            return $cto->prepareContent($content);
        } else {
            return (string) $content;
        }
    }

}

// Endfile
