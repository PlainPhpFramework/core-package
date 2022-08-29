<?php
/**
 * Bootstrap the app
 */
use pp\Hook;

// Force the PATH_INFO to be consistent in different environments
$_SERVER['PATH_INFO'] = @$_GET['_url'] ?: '/';
unset($_GET['_url']);

// Require env specific config
@include __DIR__.'/../../.env/env.php';

// Set up some constants
require 'config/constants.php';

// Load the composer autoloader
$loader = require 'config/autoload.php';

// Set up the error handling
require 'config/errors.php';

error_reporting(E_ALL);
ini_set('display_errors', 'On'); // display_errors must be set to on in order to catch errors
ini_set('log_errors', 'On');

if (php_sapi_name() !== 'cli') {

    if (IS_DEV) {  // A full featured error handler for dev env
        $whoops = new \Whoops\Run;
        $handler = new \Whoops\Handler\PrettyPageHandler;
        $handler->setEditor('sublime');
        $whoops->pushHandler($handler);
        $whoops->register();

    } else { // A super lightweight error handler for production env

        // Throw exception in case of error
        set_error_handler(function($errno, $errstr, $errfile, $errline) {
            if (error_reporting() & $errno) {
                throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
            }
        });

        // Abort in the case of exceptions
        set_exception_handler(function($e) {
            abort(500, $e);
        });

        // A special case for fatal errors               
        register_shutdown_function(function() {
            $e = error_get_last();
            if (@$e['type'] === E_ERROR) {
                abort(500, new ErrorException($e['message'], 0, $e['type'], $e['file'], $e['line']));
            }
        });

    }

}

// Load the hooks
require 'config/hooks.php';
foreach (array_merge(glob(ROOT.'/packages/hooks/*.php'), glob(ROOT.'/app/hooks/*.php')) as $hook) {
    require 'hooks/'.basename($hook);
}

// Set up the locale
require 'config/locale.php';

// Initialize the "template engine"
ob_start();

// Trigger an hook
Hook::trigger('bootstrap_end');