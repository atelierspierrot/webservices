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

// else try to register `WebServices` namespace
} elseif (file_exists($c = __DIR__.'/../src/SplClassLoader.php')) {
    require_once $c;
    $classLoader = new SplClassLoader('WebServices', __DIR__.'/../src');
    $classLoader->register();

// else error, classes can't be found
} else {
    die( json_encode("You need to run Composer on the project to build dependencies and auto-loading"
        ." (see: http://getcomposer.org/doc/00-intro.md#using-composer)!") );
}

// user options
$options = array(
    'tmp_directory' => __DIR__.'/tmp',
    'log_directory' => __DIR__.'/tmp/logs',
);

// distribute request
WebServices\FrontController
    ::create(new WebServices\Request, new WebServices\Response, $options)
        ->distribute();

// or exit
exit( json_encode('ERROR IN RENDERING !') );

// Endfile