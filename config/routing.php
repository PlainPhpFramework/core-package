<?php
/**
 * URL rewriting rules
 */
return (object) [
	'params' => [
		'slug' => '[a-z0-9-]+',
		'id' => '\d+',
	],
	'routes' => [
		// Examples:
		// '/' => 'homepage/index',
		// '/hello/:slug' => 'default/greet_user',
		// '/controller/:@action' => 'controller/long/name'
	],
	'default_controller' => 'default',
	'default_action' => 'index',
	'controller_class_pattern' => '\App\Controller\%s_controller',
];