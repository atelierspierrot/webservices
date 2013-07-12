<?php
/**
 * WebServices - PHP package
 * Copyleft (c) 2013 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <https://github.com/atelierspierrot/webservices>
 */
namespace WebServices\ContentType;

use WebServices\ContentTypeInterface,
    WebServices\Response;

/**
 * @author      Piero Wbmstr <piero.wbmstr@gmail.com>
 */
class Html implements ContentTypeInterface
{

    /**
     * Prepare the content of the response before to send it to client
     *
     * @param object $response \WebServices\Response
     * @return void
     */
    public function prepareResponse(Response $response)
    {
    }

    /**
     * Parse an input content
     *
     * @param string $content
     * @return misc
     */
    public function parseContent($content)
    {
        return (string) $content;
    }

    /**
     * Prepare a content for output
     *
     * @param misc $content
     * @return string
     */
    public function prepareContent($content)
    {
        if (is_array($content)) {
            $ctt = '';
            foreach ($content as $key=>$ctt) {
                $content .= $ctt;
            }
            $content = $ctt;
        }
        return (string) $content;
    }

    /**
     * Get the "content-Type" header value
     *
     * @return string
     */
    public static function getContentType()
    {
        return 'text/html';
    }

}

// Endfile
