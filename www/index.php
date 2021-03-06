<?php
/**
 * This file is part of the WebServices package.
 *
 * Copyright (c) 2013-2016 Pierre Cassat <me@e-piwi.fr> and contributors
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *      http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * The source code of this package is available online at 
 * <http://github.com/atelierspierrot/webservices>.
 */
 
 /**
 * Show errors at least initially
 *
 * `E_ALL` => for hard dev
 * `E_ALL & ~E_STRICT` => for hard dev in PHP5.4 avoiding strict warnings
 * `E_ALL & ~E_NOTICE & ~E_STRICT` => classic setting
 */
//@ini_set('display_errors','1'); @error_reporting(E_ALL);
//@ini_set('display_errors','1'); @error_reporting(E_ALL & ~E_STRICT);
@ini_set('display_errors', '1'); @error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);

/**
 * Set a default timezone to avoid PHP5 warnings
 */
$dtmz = @date_default_timezone_get();
date_default_timezone_set($dtmz?:'Europe/Paris');

// get the Composer autoloader
if (file_exists($a = __DIR__.'/../../../autoload.php')) {
    require_once $a;
} elseif (file_exists($b = __DIR__.'/../vendor/autoload.php')) {
    require_once $b;

// else error, classes can't be found
} else {
    die(json_encode("You need to run Composer on the project to build dependencies and auto-loading"
        ." (see: http://getcomposer.org/doc/00-intro.md#using-composer)!"));
}

// user options
$options = array(
    // the HTTP accessible temporary files
    'tmp_directory' => __DIR__.'/tmp',
    // the HTTP NON-accessible temporary files, must be out of your document root
    'var_directory' => __DIR__.'/../var',
    // the log files, must be out of your document root (here in 'var/')
    'log_directory' => __DIR__.'/../var/logs',
    // enable full logging
    'enable_logging' => true,
    // enable the URL rewriting : "http://.../var/val" = "http://.../?var=val"
    'enable_url_rewrite' => true,
    // write your custom controllers here like "route => classname" pairs
    // then you can call "http://.../?ws=route" to access them
    'controllers_mapping' => array(
    ),
);

// distribute request
\WebServices\FrontController
    ::create(new \Library\HttpFundamental\Request, new \Library\HttpFundamental\Response, $options)
        ->distribute();

// or exit
exit(json_encode('ERROR IN RENDERING !'));
