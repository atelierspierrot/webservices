Test WebService
===============

## Usage

    <?php echo $webservice_url; ?> ? [options = argument]

    HTTP/1.1 200 OK
    Date: Sun, 28 Jul 2013 21:26:13 GMT
    Connection: keep-alive
    Cache-Control: max-age=0, private, must-revalidate
    X-XSS-Protection: 1; mode=block
    Content-Length: 40
    Content-Type: application/json; charset=UTF-8

    {
        "status": 0,
        "message": "Hello World ;)"
    }

The script response is a JSON string with a human readable `message` entry and the final
`status` of the application call, which can be:

- `0` : no error
- `1` : unexpected result
- `2` or `3` : request error
- `-1` : internal error.

## Options

*ws* **name of the webservice**
:   The webservice controller to call ; this can be left empty in case of a call to a 
    default controller ; the argument must be the controller class name or a shortcut
    if it is defined in the application configuration.
        
*action* **name of a method**
:   This is the method name to call in concerned webservice ; if it is left empty, the
    default action is `index` ; you can try the `usage` action to get usage info about
    the webservice.

## Examples

To call the method `MyMethod` of the webservice controller named `MyController`, call:

    curl -i '<?php echo $webservice_url; ?>?ws=MyController&action=MyMethod'

To make the same call with GET parameters (*name = Pierre*), call:

    curl -i '<?php echo $webservice_url; ?>?ws=MyController&action=MyMethod&name=Pierre'

To make the same call with POST data (*name = Pierre*), call:

    curl -d "name=Pierre" -i '<?php echo $webservice_url; ?>?ws=MyController&action=MyMethod'

## Infos / Bugs

For more informations about this package or transmit a bug, see <http://github.com/atelierspierrot/webservices>.

