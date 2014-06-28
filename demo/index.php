<?php

/**
 * Show errors at least initially
 *
 * `E_ALL` => for hard dev
 * `E_ALL & ~E_STRICT` => for hard dev in PHP5.4 avoiding strict warnings
 * `E_ALL & ~E_NOTICE & ~E_STRICT` => classic setting
 */
@ini_set('display_errors','1'); @error_reporting(E_ALL);
//@ini_set('display_errors','1'); @error_reporting(E_ALL & ~E_STRICT);
//@ini_set('display_errors','1'); @error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);

/**
 * Set a default timezone to avoid PHP5 warnings
 */
$dtmz = @date_default_timezone_get();
date_default_timezone_set($dtmz?:'Europe/Paris');

/**
 * For security, transform a realpath as '/[***]/package_root/...'
 *
 * @param string $path
 * @param int $depth_from_root
 *
 * @return string
 */
function _getSecuredRealPath($path, $depth_from_root = 1)
{
    $ds = DIRECTORY_SEPARATOR;
    $parts = explode($ds, realpath('.'));
    for ($i=0; $i<=$depth_from_root; $i++) array_pop($parts);
    return str_replace(join($ds, $parts), $ds.'[***]', $path);
}

/**
 * GET arguments settings
 */
$arg_ln = isset($_GET['ln']) ? $_GET['ln'] : 'en';

function getPhpClassManualLink( $class_name, $ln='en' )
{
    return sprintf('http://php.net/manual/%s/class.%s.php', $ln, strtolower($class_name));
}

if (file_exists($a = __DIR__.'/../vendor/autoload.php')) {
    require_once $a;
} else {
    die('You need to run Composer on your project to use this interface!');
}

$webservice_domain = str_replace('demo', 'www', \Library\Helper\Url::getRequestUrl());

?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Test & documentation of PHP "WebServices" package</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="assets/html5boilerplate/css/normalize.css" />
    <link rel="stylesheet" href="assets/html5boilerplate/css/main.css" />
    <script src="assets/html5boilerplate/js/vendor/modernizr-2.6.2.min.js"></script>
    <link rel="stylesheet" href="assets/styles.css" />
</head>
<body>
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

    <header id="top" role="banner">
        <hgroup>
            <h1>Tests of PHP <em>WebServices</em> package</h1>
            <h2 class="slogan">A PHP engine to manage web-services easily.</h2>
        </hgroup>
        <div class="hat">
            <p>These pages show and demonstrate the use and functionality of the <a href="https://github.com/atelierspierrot/webservices">atelierspierrot/webservices</a> PHP package you just downloaded.</p>
        </div>
    </header>

    <nav>
        <h2>Map of the package</h2>
        <ul id="navigation_menu" class="menu" role="navigation">
            <li><a href="index.php">Homepage</a><ul>
        </ul>

        <div class="info">
            <p><a href="https://github.com/atelierspierrot/webservices">See online on GitHub</a></p>
            <p class="comment">The sources of this plugin are hosted on <a href="http://github.com">GitHub</a>. To follow sources updates, report a bug or read opened bug tickets and any other information, please see the GitHub website above.</p>
        </div>

        <p class="credits" id="user_agent"></p>
    </nav>

    <div id="content" role="main">

        <div class="info" id="dev_block">
            <p><a id="source_handler" class="handler" title="See source code of the demonstration content below">See javascript source code</a></p>
            <div id="source"><pre class="code" id="source_block_content"></pre></div>
        </div>

        <div class="info" id="jsconsole">
            <p><a class="handler strong noimg">Javascript Console</a></p>
            <div id="console"></div>
        </div>

        <article>

    <h3>Test of success requests</h3>
    <ul>
        <li><a href="javascript:runTest('action=helloworld');">test "hello world"</a></li>
        <li><a href="javascript:runTest('action=testGet');">test with GET method</a></li>
        <li><a href="javascript:runTest('action=testGet&name=Pierre');">test with GET method and name "Pierre"</a></li>
        <li><a href="javascript:runTest('action=testPost');">test with POST method</a></li>
        <li><a href="javascript:runTest('action=testPost', 'name=Pierre');">test with POST method and name "Pierre" data</a></li>
    </ul>
    <p><strong>Same four last tests with random:</strong></p>
    <ul>
        <li><a href="javascript:runTest('action=testGet&random=true');">test with GET method</a></li>
        <li><a href="javascript:runTest('action=testGet&name=Pierre&random=true');">test with GET method and name "Pierre"</a></li>
        <li><a href="javascript:runTest('action=testPost&random=true');">test with POST method</a></li>
        <li><a href="javascript:runTest('action=testPost&random=true', 'name=Pierre');">test with POST method and name "Pierre" data</a></li>
    </ul>
    
    
    <h3>Test of failure requests</h3>
    <ul>
        <li><a href="javascript:runTest('action=abcd');">test sending a 404 error</a></li>
        <li><a href="javascript:runTest('action=testBadRequest');">test of a bad request</a></li>
        <li><a href="javascript:runTest('action=testTreatmentError');">test of a treatment error</a></li>
        <li><a href="javascript:runTest('action=testInternalError');">test of an internal server error</a></li>
    </ul>
    
    <h3>Test of "usage" call</h3>
    <p>The "usage" method always returns, if available, a presentation of the webservice in plain HTML, generated from <a href="http://github.com/piwi/markdown-extended">Markdown Extended</a> syntax.</p>
    <ul>
        <li><a href="<?php echo $webservice_domain; ?>?action=usage">test of test controller "usage"</a></li>
    </ul>

        </article>
    </div>

    <footer id="footer">
        <div class="credits float-left">
            This page is <a href="" title="Check now online" id="html_validation">HTML5</a> & <a href="" title="Check now online" id="css_validation">CSS3</a> valid.
        </div>
        <div class="credits float-right">
            <a href="http://github.com/atelierspierrot/webservices">atelierspierrot/webservices</a> package by <a href="http://github.com/atelierspierrot">Les Ateliers Pierrot</a> under <a href="http://opensource.org/licenses/GPL-3.0">GNU GPL v.3</a> license.
        </div>
    </footer>

    <div class="back_menu" id="short_navigation">
        <a href="#" title="See navigation menu" id="short_menu_handler"><span class="text">Navigation Menu</span></a>
        &nbsp;|&nbsp;
        <a href="#top" title="Back to the top of the page"><span class="text">Back to top&nbsp;</span>&uarr;</a>
        <ul id="short_menu" class="menu" role="navigation"></ul>
    </div>

    <div id="message_box" class="msg_box"></div>

<!-- jQuery lib -->
<script src="assets/js/jquery-1.9.1.min.js"></script>

<!-- HTML5 boilerplate -->
<script src="assets/html5boilerplate/js/plugins.js"></script>

<!-- jQuery.highlight plugin -->
<script src="assets/js/highlight.js"></script>

<!-- scripts for demo -->
<script src="assets/scripts.js"></script>

<script>
$(function() {
    initBacklinks();
    activateMenuItem();
    getToHash();
    buildFootNotes();
    addCSSValidatorLink('assets/styles.css');
    addHTMLValidatorLink();
    $("#user_agent").html( navigator.userAgent );
    initHandler('source');
    $('#source_block_content').text( $('#js_code').html() );
    $('pre.code').highlight({source:0, indent:'tabs', code_lang: 'data-language'});
});
</script>
<script id="js_code">

// run a test
function runTest(arguments, data)
{
    $.ajax({
        url: "<?php echo $webservice_domain; ?>?" + arguments,
        dataType: 'json',
        method: data===undefined ? 'get' : 'post',
        data: data
    })
    .done(function(data, textStatus, jqXHR) {
        ajaxReturn(data);
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        data = $.parseJSON(jqXHR.responseText);
        ajaxReturn(data, "error");
    });
}

// treat ajax return
function ajaxReturn(data, _class)
{
    if(console && console.log) {
        console.log("Receiving:", data);
    }
    var response = "<span class=\"" + _class + "\">Receiving webservice response with status "
        + data.status + " and message '" + data.message + "'</span>";

    writeInConsole(response);
}

// write a string in page's console
function writeInConsole(ctt)
{
    $("#console").append("<br />"+ctt);
}

</script>
</body>
</html>
