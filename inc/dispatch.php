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
$canonicalUrl = url_for($controller . '/' . $method, $_GET + $params);
if ($canonicalUrl !== current_url()) {
    redirect($canonicalUrl, $_ENV['IS_DEV']? 302: 301);
}

$controller = sprintf('\\App\\Controller\\%s_controller', str_replace('/', '\\', $controller));
$method .= '_http';

if (class_exists($controller) && method_exists($controller, $method)) {

    Hook::trigger('before_dispatch');

    // Run controller
    $_GET += $params;
    (new $controller)->{$method}();  
    
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
