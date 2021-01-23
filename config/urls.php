<?php
/**
 * Overwrite default controller URI in the url_for functions.
 * 
 * Usually you don't need to edit this file. See config/routing.php instead. 
 */

// User defined url functions in config/routing.php
$urls = [];

// extract the url definitions and push it in $urls;
array_map(
	function($rule) use($urls){
	
		// The definition is in the the second element of the rule definition
		if (count($rules) !== 2) return;
		$reverseUrlFunction = $rules[1];

		// Remove query string form controller uri if present
		$controllerUri = explode('?', $rules[0])[0];

		// Set up the $urls config array
		$urls[$controllerUri] = $reverseUrlFunction;

	}, 
	get('routing'));

// Return the configuration array
return $urls;