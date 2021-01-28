<?php
/**
 * Core packages hooks
 */

use pp\Hook;

// Add a basic HTTP cache
Hook::$on['dispatch_success'][] = function () {

	if (http_response_code() === 200) {

		$etag = '"'.md5(ob_get_contents()).'"';
		$userEtag = @$_SERVER['HTTP_IF_NONE_MATCH']?: false;
		header("ETag: $etag");
		header("Cache-Control: private, must-revalidate");

		if ($userEtag && $userEtag === $etag) {
			http_response_code(304);
			exit;
		}

	}

};