<?php
// show errors at least initially
@ini_set('display_errors','1'); @error_reporting(E_ALL ^ E_NOTICE);

// set a default timezone to avoid PHP5 warnings
$dtmz = date_default_timezone_get();
date_default_timezone_set($dtmz?:'Europe/Paris');

// get the Composer autoloader
if (file_exists($a = __DIR__.'/../../../autoload.php')) {
    require_once $a;
} elseif (file_exists($b = __DIR__.'/../vendor/autoload.php')) {
    require_once $b;

// else error, classes can't be found
} else {
    die( json_encode("You need to run Composer on the project to build dependencies and auto-loading"
        ." (see: http://getcomposer.org/doc/00-intro.md#using-composer)!") );
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

// special PHP settings
function WebServicesErrorHandler($errno, $errstr, $errfile, $errline)
{
    throw new \WebServices\ErrorException($errstr, $errno, 1, $errfile, $errline);
    return true;
}
//set_error_handler('WebServicesErrorHandler');

// distribute request
WebServices\FrontController
    ::create(new Library\HttpFundamental\Request, new Library\HttpFundamental\Response, $options)
        ->distribute();

// or exit
exit( json_encode('ERROR IN RENDERING !') );

// Endfile
