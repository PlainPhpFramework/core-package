<?php
/**
 * User defined hooks
 */

use pp\Hook;

// Usage
/*
Hook::$on[event_name][] = function (&$foo, &$bar) { // You can reference variables if you need to change their values
	// Return false if you need to stop propagations
	return false;
}
*/