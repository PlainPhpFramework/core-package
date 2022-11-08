<?php
/**
 * Dispatch the request to the controller or display a 404 error page
 */
use pp\Hook;

Hook::trigger('dispatch_start');

// Routing config
$router = require 'config/routing.php';

list($controller, $method) = $router->dispatch($_SERVER['PATH_INFO'], $params);

// Redirect to the canonical URL
$canonicalUrl = url_for([$controller, substr($method, 0, -5)], (array) $_GET + (array) $params);
if ($canonicalUrl !== current_url($_GET)) {
    redirect($canonicalUrl, $_ENV['IS_DEV']? 302: 301);
}

if (class_exists($controller) && method_exists($controller, $method)) {

    Hook::trigger('before_dispatch');

    // Run controller
    if ($params) {
        $_GET += $params;
    }
    (new $controller)->{$method}();  
    
    Hook::trigger('after_dispatch');
    die;

} elseif ('/' !== substr($_SERVER['PATH_INFO'], -1)) {
    redirect(url($_SERVER['PATH_INFO'] . '/', $_GET));
}


Hook::trigger('dispatch_error');

// Something wrong: return a 404 error page
abort(exception: new Exception(sprintf(
    'Action not found. Controller %s: %s, Action: %s: %s', 
    is_object($controller)? $controller::class : $controller,
    var_export(class_exists($controller), true),
    $method,
    var_export(is_callable([$controller, $method]), true))));
