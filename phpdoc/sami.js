(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '    <ul>                <li data-name="namespace:WebServices" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="WebServices.html">WebServices</a>                    </div>                    <div class="bd">                            <ul>                <li data-name="namespace:WebServices_Controller" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="WebServices/Controller.html">Controller</a>                    </div>                    <div class="bd">                            <ul>                <li data-name="class:WebServices_Controller_AbstractController" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="WebServices/Controller/AbstractController.html">AbstractController</a>                    </div>                </li>                            <li data-name="class:WebServices_Controller_DefaultController" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="WebServices/Controller/DefaultController.html">DefaultController</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:WebServices_AbstractFrontControllerAware" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="WebServices/AbstractFrontControllerAware.html">AbstractFrontControllerAware</a>                    </div>                </li>                            <li data-name="class:WebServices_BadRequestException" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="WebServices/BadRequestException.html">BadRequestException</a>                    </div>                </li>                            <li data-name="class:WebServices_ErrorException" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="WebServices/ErrorException.html">ErrorException</a>                    </div>                </li>                            <li data-name="class:WebServices_Exception" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="WebServices/Exception.html">Exception</a>                    </div>                </li>                            <li data-name="class:WebServices_FrontController" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="WebServices/FrontController.html">FrontController</a>                    </div>                </li>                            <li data-name="class:WebServices_FrontControllerAwareInterface" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="WebServices/FrontControllerAwareInterface.html">FrontControllerAwareInterface</a>                    </div>                </li>                            <li data-name="class:WebServices_NotFoundException" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="WebServices/NotFoundException.html">NotFoundException</a>                    </div>                </li>                            <li data-name="class:WebServices_TreatmentException" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="WebServices/TreatmentException.html">TreatmentException</a>                    </div>                </li>                </ul></div>                </li>                </ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                    {"type": "Namespace", "link": "WebServices.html", "name": "WebServices", "doc": "Namespace WebServices"},{"type": "Namespace", "link": "WebServices/Controller.html", "name": "WebServices\\Controller", "doc": "Namespace WebServices\\Controller"},
            {"type": "Interface", "fromName": "WebServices", "fromLink": "WebServices.html", "link": "WebServices/FrontControllerAwareInterface.html", "name": "WebServices\\FrontControllerAwareInterface", "doc": "&quot;This interface should be implemented by any object depending on the &lt;code&gt;\\WebServices\\FrontController&lt;\/code&gt; object&quot;"},
                                                        {"type": "Method", "fromName": "WebServices\\FrontControllerAwareInterface", "fromLink": "WebServices/FrontControllerAwareInterface.html", "link": "WebServices/FrontControllerAwareInterface.html#method_setFrontController", "name": "WebServices\\FrontControllerAwareInterface::setFrontController", "doc": "&quot;\n&quot;"},
            
            
            {"type": "Class", "fromName": "WebServices", "fromLink": "WebServices.html", "link": "WebServices/AbstractFrontControllerAware.html", "name": "WebServices\\AbstractFrontControllerAware", "doc": "&quot;This class designs an object depending on the &lt;code&gt;WebServices\\FrontController&lt;\/code&gt; object&quot;"},
                                                        {"type": "Method", "fromName": "WebServices\\AbstractFrontControllerAware", "fromLink": "WebServices/AbstractFrontControllerAware.html", "link": "WebServices/AbstractFrontControllerAware.html#method_setFrontController", "name": "WebServices\\AbstractFrontControllerAware::setFrontController", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\AbstractFrontControllerAware", "fromLink": "WebServices/AbstractFrontControllerAware.html", "link": "WebServices/AbstractFrontControllerAware.html#method_getFrontController", "name": "WebServices\\AbstractFrontControllerAware::getFrontController", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "WebServices", "fromLink": "WebServices.html", "link": "WebServices/BadRequestException.html", "name": "WebServices\\BadRequestException", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "WebServices\\BadRequestException", "fromLink": "WebServices/BadRequestException.html", "link": "WebServices/BadRequestException.html#method___construct", "name": "WebServices\\BadRequestException::__construct", "doc": "&quot;Construction of the exception - a message is needed (1st argument)&quot;"},
            
            {"type": "Class", "fromName": "WebServices\\Controller", "fromLink": "WebServices/Controller.html", "link": "WebServices/Controller/AbstractController.html", "name": "WebServices\\Controller\\AbstractController", "doc": "&quot;Any package or custom controller must extend this basic class&quot;"},
                                                        {"type": "Method", "fromName": "WebServices\\Controller\\AbstractController", "fromLink": "WebServices/Controller/AbstractController.html", "link": "WebServices/Controller/AbstractController.html#method___construct", "name": "WebServices\\Controller\\AbstractController::__construct", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "WebServices\\Controller", "fromLink": "WebServices/Controller.html", "link": "WebServices/Controller/DefaultController.html", "name": "WebServices\\Controller\\DefaultController", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "WebServices\\Controller\\DefaultController", "fromLink": "WebServices/Controller/DefaultController.html", "link": "WebServices/Controller/DefaultController.html#method_indexAction", "name": "WebServices\\Controller\\DefaultController::indexAction", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\Controller\\DefaultController", "fromLink": "WebServices/Controller/DefaultController.html", "link": "WebServices/Controller/DefaultController.html#method_helloworldAction", "name": "WebServices\\Controller\\DefaultController::helloworldAction", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\Controller\\DefaultController", "fromLink": "WebServices/Controller/DefaultController.html", "link": "WebServices/Controller/DefaultController.html#method_testGetAction", "name": "WebServices\\Controller\\DefaultController::testGetAction", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\Controller\\DefaultController", "fromLink": "WebServices/Controller/DefaultController.html", "link": "WebServices/Controller/DefaultController.html#method_testPostAction", "name": "WebServices\\Controller\\DefaultController::testPostAction", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\Controller\\DefaultController", "fromLink": "WebServices/Controller/DefaultController.html", "link": "WebServices/Controller/DefaultController.html#method_testNotFoundAction", "name": "WebServices\\Controller\\DefaultController::testNotFoundAction", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\Controller\\DefaultController", "fromLink": "WebServices/Controller/DefaultController.html", "link": "WebServices/Controller/DefaultController.html#method_testBadRequestAction", "name": "WebServices\\Controller\\DefaultController::testBadRequestAction", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\Controller\\DefaultController", "fromLink": "WebServices/Controller/DefaultController.html", "link": "WebServices/Controller/DefaultController.html#method_testTreatmentErrorAction", "name": "WebServices\\Controller\\DefaultController::testTreatmentErrorAction", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\Controller\\DefaultController", "fromLink": "WebServices/Controller/DefaultController.html", "link": "WebServices/Controller/DefaultController.html#method_testInternalErrorAction", "name": "WebServices\\Controller\\DefaultController::testInternalErrorAction", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "WebServices", "fromLink": "WebServices.html", "link": "WebServices/ErrorException.html", "name": "WebServices\\ErrorException", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "WebServices\\ErrorException", "fromLink": "WebServices/ErrorException.html", "link": "WebServices/ErrorException.html#method___construct", "name": "WebServices\\ErrorException::__construct", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\ErrorException", "fromLink": "WebServices/ErrorException.html", "link": "WebServices/ErrorException.html#method___toString", "name": "WebServices\\ErrorException::__toString", "doc": "&quot;Force the error display&quot;"},
                    {"type": "Method", "fromName": "WebServices\\ErrorException", "fromLink": "WebServices/ErrorException.html", "link": "WebServices/ErrorException.html#method_render", "name": "WebServices\\ErrorException::render", "doc": "&quot;Force the error display and log it&quot;"},
                    {"type": "Method", "fromName": "WebServices\\ErrorException", "fromLink": "WebServices/ErrorException.html", "link": "WebServices/ErrorException.html#method_setFrontController", "name": "WebServices\\ErrorException::setFrontController", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\ErrorException", "fromLink": "WebServices/ErrorException.html", "link": "WebServices/ErrorException.html#method_getFrontController", "name": "WebServices\\ErrorException::getFrontController", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "WebServices", "fromLink": "WebServices.html", "link": "WebServices/Exception.html", "name": "WebServices\\Exception", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "WebServices\\Exception", "fromLink": "WebServices/Exception.html", "link": "WebServices/Exception.html#method___construct", "name": "WebServices\\Exception::__construct", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\Exception", "fromLink": "WebServices/Exception.html", "link": "WebServices/Exception.html#method___toString", "name": "WebServices\\Exception::__toString", "doc": "&quot;Force the error display&quot;"},
                    {"type": "Method", "fromName": "WebServices\\Exception", "fromLink": "WebServices/Exception.html", "link": "WebServices/Exception.html#method_render", "name": "WebServices\\Exception::render", "doc": "&quot;Force the error display and log it&quot;"},
                    {"type": "Method", "fromName": "WebServices\\Exception", "fromLink": "WebServices/Exception.html", "link": "WebServices/Exception.html#method_setFrontController", "name": "WebServices\\Exception::setFrontController", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\Exception", "fromLink": "WebServices/Exception.html", "link": "WebServices/Exception.html#method_getFrontController", "name": "WebServices\\Exception::getFrontController", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "WebServices", "fromLink": "WebServices.html", "link": "WebServices/FrontController.html", "name": "WebServices\\FrontController", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "WebServices\\FrontController", "fromLink": "WebServices/FrontController.html", "link": "WebServices/FrontController.html#method_create", "name": "WebServices\\FrontController::create", "doc": "&quot;Creation of a singleton instance&quot;"},
                    {"type": "Method", "fromName": "WebServices\\FrontController", "fromLink": "WebServices/FrontController.html", "link": "WebServices/FrontController.html#method_log", "name": "WebServices\\FrontController::log", "doc": "&quot;Shrotcut for logging message&quot;"},
                    {"type": "Method", "fromName": "WebServices\\FrontController", "fromLink": "WebServices/FrontController.html", "link": "WebServices/FrontController.html#method_distribute", "name": "WebServices\\FrontController::distribute", "doc": "&quot;Distributes the application actions&quot;"},
                    {"type": "Method", "fromName": "WebServices\\FrontController", "fromLink": "WebServices/FrontController.html", "link": "WebServices/FrontController.html#method_display", "name": "WebServices\\FrontController::display", "doc": "&quot;Displays the request result&quot;"},
                    {"type": "Method", "fromName": "WebServices\\FrontController", "fromLink": "WebServices/FrontController.html", "link": "WebServices/FrontController.html#method_callController", "name": "WebServices\\FrontController::callController", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\FrontController", "fromLink": "WebServices/FrontController.html", "link": "WebServices/FrontController.html#method_callControllerMethod", "name": "WebServices\\FrontController::callControllerMethod", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\FrontController", "fromLink": "WebServices/FrontController.html", "link": "WebServices/FrontController.html#method_getControllerUsage", "name": "WebServices\\FrontController::getControllerUsage", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\FrontController", "fromLink": "WebServices/FrontController.html", "link": "WebServices/FrontController.html#method_parseUsageFilepath", "name": "WebServices\\FrontController::parseUsageFilepath", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\FrontController", "fromLink": "WebServices/FrontController.html", "link": "WebServices/FrontController.html#method_setUserOptions", "name": "WebServices\\FrontController::setUserOptions", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\FrontController", "fromLink": "WebServices/FrontController.html", "link": "WebServices/FrontController.html#method_getUserOptions", "name": "WebServices\\FrontController::getUserOptions", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\FrontController", "fromLink": "WebServices/FrontController.html", "link": "WebServices/FrontController.html#method_setOption", "name": "WebServices\\FrontController::setOption", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\FrontController", "fromLink": "WebServices/FrontController.html", "link": "WebServices/FrontController.html#method_getOption", "name": "WebServices\\FrontController::getOption", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\FrontController", "fromLink": "WebServices/FrontController.html", "link": "WebServices/FrontController.html#method_getLoggerOptions", "name": "WebServices\\FrontController::getLoggerOptions", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\FrontController", "fromLink": "WebServices/FrontController.html", "link": "WebServices/FrontController.html#method_setStatus", "name": "WebServices\\FrontController::setStatus", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\FrontController", "fromLink": "WebServices/FrontController.html", "link": "WebServices/FrontController.html#method_getStatus", "name": "WebServices\\FrontController::getStatus", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\FrontController", "fromLink": "WebServices/FrontController.html", "link": "WebServices/FrontController.html#method_setMessage", "name": "WebServices\\FrontController::setMessage", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\FrontController", "fromLink": "WebServices/FrontController.html", "link": "WebServices/FrontController.html#method_getMessage", "name": "WebServices\\FrontController::getMessage", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\FrontController", "fromLink": "WebServices/FrontController.html", "link": "WebServices/FrontController.html#method_addContent", "name": "WebServices\\FrontController::addContent", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\FrontController", "fromLink": "WebServices/FrontController.html", "link": "WebServices/FrontController.html#method_getContent", "name": "WebServices\\FrontController::getContent", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\FrontController", "fromLink": "WebServices/FrontController.html", "link": "WebServices/FrontController.html#method_setRequest", "name": "WebServices\\FrontController::setRequest", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\FrontController", "fromLink": "WebServices/FrontController.html", "link": "WebServices/FrontController.html#method_getRequest", "name": "WebServices\\FrontController::getRequest", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\FrontController", "fromLink": "WebServices/FrontController.html", "link": "WebServices/FrontController.html#method_setResponse", "name": "WebServices\\FrontController::setResponse", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\FrontController", "fromLink": "WebServices/FrontController.html", "link": "WebServices/FrontController.html#method_getResponse", "name": "WebServices\\FrontController::getResponse", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\FrontController", "fromLink": "WebServices/FrontController.html", "link": "WebServices/FrontController.html#method_setLogger", "name": "WebServices\\FrontController::setLogger", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\FrontController", "fromLink": "WebServices/FrontController.html", "link": "WebServices/FrontController.html#method_getLogger", "name": "WebServices\\FrontController::getLogger", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\FrontController", "fromLink": "WebServices/FrontController.html", "link": "WebServices/FrontController.html#method_setController", "name": "WebServices\\FrontController::setController", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebServices\\FrontController", "fromLink": "WebServices/FrontController.html", "link": "WebServices/FrontController.html#method_getController", "name": "WebServices\\FrontController::getController", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "WebServices", "fromLink": "WebServices.html", "link": "WebServices/FrontControllerAwareInterface.html", "name": "WebServices\\FrontControllerAwareInterface", "doc": "&quot;This interface should be implemented by any object depending on the &lt;code&gt;\\WebServices\\FrontController&lt;\/code&gt; object&quot;"},
                                                        {"type": "Method", "fromName": "WebServices\\FrontControllerAwareInterface", "fromLink": "WebServices/FrontControllerAwareInterface.html", "link": "WebServices/FrontControllerAwareInterface.html#method_setFrontController", "name": "WebServices\\FrontControllerAwareInterface::setFrontController", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "WebServices", "fromLink": "WebServices.html", "link": "WebServices/NotFoundException.html", "name": "WebServices\\NotFoundException", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "WebServices\\NotFoundException", "fromLink": "WebServices/NotFoundException.html", "link": "WebServices/NotFoundException.html#method___construct", "name": "WebServices\\NotFoundException::__construct", "doc": "&quot;Construction of the exception - a message is needed (1st argument)&quot;"},
            
            {"type": "Class", "fromName": "WebServices", "fromLink": "WebServices.html", "link": "WebServices/TreatmentException.html", "name": "WebServices\\TreatmentException", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "WebServices\\TreatmentException", "fromLink": "WebServices/TreatmentException.html", "link": "WebServices/TreatmentException.html#method___construct", "name": "WebServices\\TreatmentException::__construct", "doc": "&quot;Construction of the exception - a message is needed (1st argument)&quot;"},
            
            
                                        // Fix trailing commas in the index
        {}
    ];

    /** Tokenizes strings by namespaces and functions */
    function tokenizer(term) {
        if (!term) {
            return [];
        }

        var tokens = [term];
        var meth = term.indexOf('::');

        // Split tokens into methods if "::" is found.
        if (meth > -1) {
            tokens.push(term.substr(meth + 2));
            term = term.substr(0, meth - 2);
        }

        // Split by namespace or fake namespace.
        if (term.indexOf('\\') > -1) {
            tokens = tokens.concat(term.split('\\'));
        } else if (term.indexOf('_') > 0) {
            tokens = tokens.concat(term.split('_'));
        }

        // Merge in splitting the string by case and return
        tokens = tokens.concat(term.match(/(([A-Z]?[^A-Z]*)|([a-z]?[^a-z]*))/g).slice(0,-1));

        return tokens;
    };

    root.Sami = {
        /**
         * Cleans the provided term. If no term is provided, then one is
         * grabbed from the query string "search" parameter.
         */
        cleanSearchTerm: function(term) {
            // Grab from the query string
            if (typeof term === 'undefined') {
                var name = 'search';
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(location.search);
                if (results === null) {
                    return null;
                }
                term = decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            return term.replace(/<(?:.|\n)*?>/gm, '');
        },

        /** Searches through the index for a given term */
        search: function(term) {
            // Create a new search index if needed
            if (!bhIndex) {
                bhIndex = new Bloodhound({
                    limit: 500,
                    local: searchIndex,
                    datumTokenizer: function (d) {
                        return tokenizer(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                bhIndex.initialize();
            }

            results = [];
            bhIndex.get(term, function(matches) {
                results = matches;
            });

            if (!rootPath) {
                return results;
            }

            // Fix the element links based on the current page depth.
            return $.map(results, function(ele) {
                if (ele.link.indexOf('..') > -1) {
                    return ele;
                }
                ele.link = rootPath + ele.link;
                if (ele.fromLink) {
                    ele.fromLink = rootPath + ele.fromLink;
                }
                return ele;
            });
        },

        /** Get a search class for a specific type */
        getSearchClass: function(type) {
            return searchTypeClasses[type] || searchTypeClasses['_'];
        },

        /** Add the left-nav tree to the site */
        injectApiTree: function(ele) {
            ele.html(treeHtml);
        }
    };

    $(function() {
        // Modify the HTML to work correctly based on the current depth
        rootPath = $('body').attr('data-root-path');
        treeHtml = treeHtml.replace(/href="/g, 'href="' + rootPath);
        Sami.injectApiTree($('#api-tree'));
    });

    return root.Sami;
})(window);

$(function() {

    // Enable the version switcher
    $('#version-switcher').change(function() {
        window.location = $(this).val()
    });

    
        // Toggle left-nav divs on click
        $('#api-tree .hd span').click(function() {
            $(this).parent().parent().toggleClass('opened');
        });

        // Expand the parent namespaces of the current page.
        var expected = $('body').attr('data-name');

        if (expected) {
            // Open the currently selected node and its parents.
            var container = $('#api-tree');
            var node = $('#api-tree li[data-name="' + expected + '"]');
            // Node might not be found when simulating namespaces
            if (node.length > 0) {
                node.addClass('active').addClass('opened');
                node.parents('li').addClass('opened');
                var scrollPos = node.offset().top - container.offset().top + container.scrollTop();
                // Position the item nearer to the top of the screen.
                scrollPos -= 200;
                container.scrollTop(scrollPos);
            }
        }

    
    
        var form = $('#search-form .typeahead');
        form.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'search',
            displayKey: 'name',
            source: function (q, cb) {
                cb(Sami.search(q));
            }
        });

        // The selection is direct-linked when the user selects a suggestion.
        form.on('typeahead:selected', function(e, suggestion) {
            window.location = suggestion.link;
        });

        // The form is submitted when the user hits enter.
        form.keypress(function (e) {
            if (e.which == 13) {
                $('#search-form').submit();
                return true;
            }
        });

    
});


