<?php
/**
 * Set up some constants
 */
// Developement evnviroment
define('IS_DEV', @$_ENV['IS_DEV']);

// Document root
define('ROOT', realpath(__DIR__ . '/../..'));

// Public path
define('PUB', ROOT.'/public');

// The URL of the homepage
define('BASE_URL', rtrim(@$_ENV['BASE_URL'], '/') . '/');