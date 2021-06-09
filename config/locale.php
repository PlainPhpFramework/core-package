<?php

namespace App;

/**
 * Set up the gettext variables
 */
function setLocale($locale) {

	defined('LC_MESSAGES') && \setlocale(LC_MESSAGES, $locale); // Linux
	putenv("LC_ALL={$locale}"); // windows
	bindtextdomain("messages", APP."/locale");
	textdomain("messages");

}

// List of of Supported Timezones: https://www.php.net/manual/en/timezones.php
// By default use the server timezone
\date_default_timezone_set(\date_default_timezone_get());

// Set the default locale (only if you need to use gettext)
// \App\setLocale('en');