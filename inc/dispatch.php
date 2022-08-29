<?php
/**
 * Dispatch the request to the controller or display a 404 error page
 */
use pp\Hook;

Hook::trigger('dispatch_start');

// Routing config
$config = require 'config/routing.php';

// Controller URI
$controllerUri = $_SERVER['PATH_INFO'];

// Avoid the explicit call of the default controller
if (strpos($_SERVER['PATH_INFO'], '/'.ltrim($config->default_controller, '/')) === 0) {
    abort(exception: new Exception(sprintf('Explicit call to the default controller name is not allowed')));
}
// Avoid the explicit call of the default action
elseif (substr($_SERVER['PATH_INFO'], (strlen($config->default_action)+1)*-1) === '/'.$config->default_action) {
    abort(exception: new Exception(sprintf('Explicit call to the index action: %s', $_SERVER['PATH_INFO'])));
}

// In the case of requests to rewritten controllers, try redirecting to the new canonical URL 
try {
    $canonical = url_for($controllerUri, $_GET);
    $canonicalControllerUri = parse_url(str_replace(url(), '/', $canonical), PHP_URL_PATH);
    if ($canonicalControllerUri !== $controllerUri) {
        redirect($canonical, 301);
    }
} catch (Throwable $e) {}


// URL rewriting
$params = [];

// Set up the regexes for the params
$paramReplaces['~:@\baction\b~'] = '(?<_action_>[a-z0-9_]+)';
foreach ($config->params as $key => $regex) {
    $paramReplaces['~:\b'.$key.'\b~'] = "(?<$key>$regex)";
}

foreach ($config->routes as $pattern => $internalUri) {

    // Check if pattern contains a param
    // If any convert params to regexes
    if (strpos($pattern, ':') !== false) {
        $pattern = preg_replace(array_keys($paramReplaces), $paramReplaces, $pattern);
    }

    if (preg_match("#^$pattern$#", $controllerUri, $match)) {

        $controllerUri = '/'.ltrim($internalUri, '/');

        foreach ($match as $key => $string) {
            if (!is_numeric($key)) {
                $params[$key] = $string;
            }
        }

        if (@$params['_action_']) {
            $controllerUri = rtrim($controllerUri, '/') . '/' . $params['_action_'];
        }

        // Request match, exit the loop
        break;

    }

}

// Validate the query string
foreach ($_GET as $key => $value) {
    if (isset($config->params[$key])) {
        $rule = $config->params[$key];
        if (!preg_match("#^$rule$#", $value)) {
            abort(exception: new Exception(sprintf('Invalid parameter in query string key: %s', $key)));
        }
    }
}


// Validate the controller URI
if (!preg_match('#^/([a-z0-9][a-z0-9_/]*)?$#', $controllerUri)) {
    abort(exception: new Exception(sprintf('Invalid controller URI: %s', $controllerUri)));
} 
// Add the implicit call to the default action
elseif (!$controllerUri || substr($controllerUri, -1) === '/') {
    $controllerUri .= $config->default_action;
}

// Convert the URI to a controller and method
$controllerUri = ltrim($controllerUri, '/');
$controller = dirname($controllerUri);
$method = basename($controllerUri);
if ($controller === '.') {
    $controller = $config->default_controller;
}
$controller = sprintf($config->controller_class_pattern, $controller);
$method .= '_http';

// Dispatch to the controller method if it exists otherwise display and error 404
if (
    class_exists($controller) 
    && method_exists($controller, $method)
    && ($ref = new ReflectionClass($controller))
    && $ref->isInstantiable() // The class is not abstract
    && $ref->getMethod($method)->isPublic() // The method is public
) {

    // Merge the rewritten parameters to the query string
    if (@$params) {
        $_GET = $params + @$_GET;
    }

    Hook::trigger('before_dispatch');
    // Initialize the controller
    $controller = new $controller;
    $controller->{$method}();  
    Hook::trigger('after_dispatch');
    die;

}

Hook::trigger('dispatch_error');

// Something wrong: return a 404 error page
abort(exception: new Exception(sprintf(
    'Action not found. Controller %s: %s, Action: %s: %s', 
    is_object($controller)? $controller::class : $controller,
    var_export(class_exists($controller), true),
    $method,
    var_export(is_callable([$controller, $method]), true))));
