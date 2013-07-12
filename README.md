WebServices Engine
===================

A PHP engine to manage web-services easily.


## How-to ?

### The basis

The engine is designed as a sort of "MVC" to handle new requests by developing your Controllers
easily. The only thing to do to write a new webserice is to create a new PHP class extending
the `\WebServices\Controller\AbstrsactController` abstract class. As explained in next section,
you have to declare the actions of your controller by naming them like `dosomethingAction()`. 

For instance, consider a custom "MyController" controller with a method "indexAction()" and
"customAction()". You will call each of these actions with requests:

    $ curl -i 'http://mydomain.com/webservices/?ws=MyController'
    $ curl -i 'http://mydomain.com/webservices/?ws=MyController&action=custom'

The response is a JSON table containing at least a `status` and a `message` entry:

    {"status":0,"message":"Hello World !"}

As the "WebServices" depends on them (they must be installed), you can use in your scripts
all classes from the following third-party packages:

-   the [PHP Library of Les Ateliers Pierrot](https://github.com/atelierspierrot/library), 
    see <http://docs.ateliers-pierrot.fr/library/> for an inline documentation
-   the [PHP Patterns package of Les Ateliers Pierrot](https://github.com/atelierspierrot/patterns), 
    see <http://docs.ateliers-pierrot.fr/patterns/> for an inline documentation.

### Return status

The `FrontController` is designed to return a status code as an integer following these rules:

-   `0` : the default "no error at all" status,
-   `1` : the "unexcpected result" status, which means that no error happened but the result
    is not totally the one expected,
-   `2` : the "request error" status, used for not found webservice or method, for bad arguments
    values etc,
-   `3` : the "treatment error" status, which must be used when the treament has to stop for
    any reason,
-   `-1` : the "internal server error" status, that is used by PHP errors and exceptions.

### Rewritting

The engine is designed to handle requests written with GET arguments like `key=>value` pairs
or full URL written as `key/value`.

For instance, these followings are equivalent:

    $ curl -i 'http://mydomain.com/webservices/?ws=MyController&action=custom'
    $ curl -i 'http://mydomain.com/webservices/ws/MyController/action/custom'



## Usage

The default arguments used by the front controller (GET or POST) are:

-   `ws` : the chosen web-service ; this must be a classname of a controller,
-   `action` : the action to execute from the web-service ; this must be a method of the controller
    called `[action]Action()` ; default action is `index`

By default, the response is in JSON format and contains at the minimum an entry `status` that is
the final status of the process (the "ok" status is 0) and `message` that is the information
string.


### Get method (default)

    $ curl -i 'http://mydomain.com/webservices/?action=helloworld'

    HTTP/1.1 200 OK
    Date: Thu, 11 Jul 2013 09:57:40 GMT
    Server: Apache/2.2.22 (Ubuntu)
    X-Powered-By: PHP/5.3.10-1ubuntu3.6
    Connection: keep-alive
    Cache-Control: max-age=0, private, must-revalidate
    Content-Length: 40
    Content-Type: application/json; charset=UTF-8

    {"status":0,"message":"Hello World ;)"}

### Post method

    $ curl -i -d "name=Pierre" 'http://mydomain.com/webservices/?action=testPost'

    HTTP/1.1 200 OK
    Date: Thu, 11 Jul 2013 09:57:40 GMT
    Server: Apache/2.2.22 (Ubuntu)
    X-Powered-By: PHP/5.3.10-1ubuntu3.6
    Connection: keep-alive
    Cache-Control: max-age=0, private, must-revalidate
    Content-Length: 41
    Content-Type: application/json; charset=UTF-8

    {"status":0,"message":"Hello Pierre ;)"}


## Development

To install all PHP packages for development, just run:

    ~$ composer install --dev

A documentation can be generated with [Sami](https://github.com/fabpot/Sami) running:

    ~$ php vendor/sami/sami/sami.php render sami.config.php

The latest version of this documentation is available online at <http://docs.ateliers-pierrot.fr/webservices/>.


## Author & License

>    WebServices Engine

>    https://github.com/atelierspierrot/webservices

>    Copyleft 2013, Pierre Cassat and contributors

>    Licensed under the GPL Version 3 license.

>    http://opensource.org/licenses/GPL-3.0

>    ----

>    Les Ateliers Pierrot - Paris, France

>    <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
