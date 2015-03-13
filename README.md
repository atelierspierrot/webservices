WebServices Engine
===================

[![documentation](http://img.ateliers-pierrot-static.fr/read-the-doc.svg)](http://docs.ateliers-pierrot.fr/webservices/)
A PHP engine to manage web-services easily.


## How-to ?

### The basis

The engine is designed as a sort of "MVC" application to handle new requests by developing
your Controllers easily. All requests are handled by an interface, `www/index.php` by default,
in which you can define some options values to fit your needs or environment.

The default arguments used by the front controller (GET or POST) are:

-   `ws` : the chosen web-service ; this must be a classname of a controller,
-   `action` : the action to execute from the web-service ; this must be a method of the controller
    called `[action]Action()` ; default action is `index`.

The response is a JSON table containing at least a `status` and a `message` entry:

    {"status":0, "message":"Hello World !"}

#### Get method (default)

    $ curl -i 'http://mydomain.com/webservices/?action=helloworld'

    HTTP/1.1 200 OK
    Date: Thu, 11 Jul 2013 09:57:40 GMT
    Connection: keep-alive
    Cache-Control: max-age=0, private, must-revalidate
    Content-Length: 40
    Content-Type: application/json; charset=UTF-8

    {"status":0,"message":"Hello World ;)"}

#### Post method

    $ curl -i -d "name=Pierre" 'http://mydomain.com/webservices/?action=testPost'

    HTTP/1.1 200 OK
    Date: Thu, 11 Jul 2013 09:57:40 GMT
    Connection: keep-alive
    Cache-Control: max-age=0, private, must-revalidate
    Content-Length: 41
    Content-Type: application/json; charset=UTF-8

    {"status":0,"message":"Hello Pierre ;)"}

### Return status

The `FrontController` is designed to return a status code as an integer following these rules:

-   `0` : the default "no error at all" status,
-   `1` : the "unexpected result" status, which means that no error happened but the result
    is not totally the one expected,
-   `2` : the "request error" status, used for not found webservice or method, for bad arguments
    values etc,
-   `3` : the "treatment error" status, which must be used when the treament has to stop for
    any reason,
-   `-1` : the "internal server error" status, that is used by PHP errors and exceptions.

### Options

The `WebServices\FrontController::create()` method accepts a third argument to define a set
of customized options:

```php
array(
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
)
```

### Rewritting

The engine is designed to handle requests written with GET arguments like `key=>value` pairs
or full URL written as a list of `key/value` pairs.

For instance, these followings are equivalent:

    $ curl -i 'http://mydomain.com/webservices/?ws=MyController&action=custom'
    $ curl -i 'http://mydomain.com/webservices/ws/MyController/action/custom'

This URL rewriting feature can be disabled setting the `enable_url_rewrite` option on `false`.

### Logging

By default, the engine will log any request received and some of the PHP work done from it.
The default path for log files is `var/logs/` from the package root directory. This path can
be defined with option `log_directory`.

The logging feature can be disabled setting the `enable_logging` option on `false`.

### Customization

#### Installation of a WebServicesEngine environment

To prepare a package based on the WebServices, you will need [Composer](http://getcomposer.org/)
installed on your machine, and then you just need to run:

    ~$ php path/to/composer.phar create-project atelierspierrot/webservices YOURDIR dev-master --no-dev
    ...

    ~$ vim YOURDIR/composer.json
    // add an entry in the 'autoload' of composer.json to reference your namespace, i.e.
    "autoload": { "psr-0": { "WebServices":"src", "MyNamespace":"src" } }
    ~$ php path/to/composer.phar dump-autoload YOURDIR
    ...

    ~$ vim YOURDIR/www/index.php
    // adapt the interface options to fit your needs
    // reference your controllers to have a shortcut access to them

Then, you just have to create your `src/MyNamespace/` directory and put your controllers
in it.

That's it!

#### Key concepts

The only thing to do to write a new webservice is to create a new
PHP class extending the `\WebServices\Controller\AbstractController` abstract class. As
explained in previous section, you have to declare the actions of your controller by naming
them like `dosomethingAction()`. 

For instance, consider a custom "MyController" controller with methods "indexAction()" and
"customAction()". You will call each of these actions with requests:

    $ curl -i 'http://mydomain.com/webservices/?ws=MyController'
    $ curl -i 'http://mydomain.com/webservices/?ws=MyController&action=custom'

#### Write a "usage" information for a custom controller

Each controller can propose a "usage" string information defining the `$usage_filepath` property
on the absolute accessible path of a usage file. The content can be parsed by the 
[Markdown Extended](http://github.com/piwi/markdown-extended) parser if it is
named with a `.md` extension.

You can write your usage contents in PHP as in this case, the current configuration settings
are loaded as environment variables. The special variable `$webservice_url` is defined on the
current interface URL. To do so, you MUST use a final extension `.php`
(`.md.php` to use the Markdown parser).

The "usage" string is displayed fo each controller calling the `usage` action.

#### Referencing your custom controllers

You can develop as many new controllers you want and build a shortcut to access them by
defining the `controllers_mapping` option table, which is constructed like `shortcut => classname`.
For instance, to access a controller defined in class `MyNamespace\MyController`, you can
write `'myctrl' => 'MyNamespace\MyController'` and access it by URL `http://.../?ws=myctrl`.

#### Package environment

As they are mandatory, you can use one of the temporary directories of the package in your
developments (they must be accessible for Apache user as they may be created by it):

-   `var/` : the temporary config and logs directory, NOT HTTP accessible,
-   `www/tmp/` : the temporary HTTP accessible files.

#### Development environment

As the "WebServices" depends on them (they must be installed), you can use in your scripts
all classes from the following third-party packages:

-   the [PHP Library of Les Ateliers Pierrot](http://github.com/atelierspierrot/library), 
    see <http://docs.ateliers-pierrot.fr/library/> for an inline documentation
-   the [PHP Patterns package of Les Ateliers Pierrot](http://github.com/atelierspierrot/patterns), 
    see <http://docs.ateliers-pierrot.fr/patterns/> for an inline documentation.

## Development of the package

To install all PHP packages for development, just run:

    ~$ composer install --dev

A documentation can be generated with [Sami](http://github.com/fabpot/Sami) running:

    ~$ php vendor/sami/sami/sami.php render sami.config.php

The latest version of this documentation is available online at <http://docs.ateliers-pierrot.fr/webservices/>.


## Author & License

>    WebServices Engine

>    http://github.com/atelierspierrot/webservices

>    Copyright (c) 2013-2015 Pierre Cassat and contributors

>    Licensed under the Apache 2.0 license.

>    http://www.apache.org/licenses/LICENSE-2.0

>    ----

>    Les Ateliers Pierrot - Paris, France

>    <http://www.ateliers-pierrot.fr/> - <contact@ateliers-pierrot.fr>
