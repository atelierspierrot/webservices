<?php
/**
 * WebServices - PHP package
 * Copyleft (c) 2013 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <https://github.com/atelierspierrot/webservices>
 */
namespace WebServices;

use WebServices\Response;

/**
 */
interface ContentTypeInterface
{

    /**
     * Prepare the content of the response before to send it to client
     *
     * @param object $response \WebServices\Response
     * @return void
     */
    public function prepareResponse(Response $response);

    /**
     * Parse an input content
     *
     * @param string $content
     * @return string|array
     */
    public function parseContent($content);

    /**
     * Prepare a content for output
     *
     * @param string|array $content
     * @return string
     */
    public function prepareContent($content);

    /**
     * Get the "content-Type" header value
     *
     * @return string
     */
    public static function getContentType();

}

// Endfile
