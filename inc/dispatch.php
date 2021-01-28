<?php
/**
 * Dispatch the request to the controller or display a 404 error page
 */

Hook::trigger('dispatch_start');

// User defined rules
$rewrites = require 'config/routing.php';

// Controller URI
$controllerUri = $_SERVER['PATH_INFO'];

// In the case of requests to rewritten controllers, try redirecting to the new canonical URL 
try {
    $canonical = url_for($controllerUri, $_GET);
    $canonicalControllerUri = parse_url(str_replace(url(), '/', $canonical), PHP_URL_PATH);
    if ($canonicalControllerUri !== $controllerUri) {
        redirect($canonical, 301);
    }
} catch (Exception $e) {}


// URL rewriting
$query = '';
foreach ($rewrites as $pattern => $rule) {
    // The replacement is the first element of the routing rule
    $replacement = $rule[0];
    $rewrittenUri = preg_replace("#^$pattern$#", $replacement, $controllerUri);
    // A rule is matching
    if ($rewrittenUri !== $controllerUri) {
        // Update controllerUri and query string
        $rewrittenUri = parse_url($controllerUri);
        $controllerUri = @$rewrittenUri['path'];
        $query = @$rewrittenUri['query'];
        break;
    }
}


// Validate the controller URI
if (!preg_match('#^[a-z0-9_/]+$#', $controllerUri)) {
    abort(exception: new Exception(sprintf('Invalid controller URI: %s', $controllerUri)));
} 
// Add the implicit call to the index action
elseif (!$controllerUri || substr($controllerUri, -1) === '/') {
    $controllerUri .= 'index';
}
// Avoid the explicit call to the index action
elseif (substr($_SERVER['PATH_INFO'], -5) === 'index') {
    abort(exception: new Exception(sprintf('Explicit call to the index action: %s', $_SERVER['PATH_INFO'])));
}


// Convert the URI to a controller and method
$controllerUri = ltrim($controllerUri, '/');
$controller = dirname($controllerUri);
$method = basename($controllerUri);
if ($controller === '.') {
    $controller = 'default';
}
$controller = 'App\\Controller\\'.$controller.'_http';


// Dispatch to the controller method is it exists otherwise display and error 404
if (class_exists($controller) && method_exists($controller, $method)) {

    // Merge the rewritten parameters to the query string
    if (@$query) {
        parse_str($query, $params);
        $_GET = $params + @$_GET;
    }

    // Initialize the controller
    $controller = new $controller;

    // Check if the action is callable
    if (is_callable([$controller, $method])) {
        (new $controller)->{$method}();  
        Hook::trigger('dispatch_success');
        die;
    }
}

Hook::trigger('dispatch_error');

// Something wrong: return a 404 error page
abort(exception: new Exception(sprintf(
    'Action not found. Controller %s: %s, Action: %s: %s', 
    is_object($controller)? $controller::class : $controller,
    var_export(class_exists($controller), true),
    $method,
    var_export(is_callable([$controller, $method]), true))));
