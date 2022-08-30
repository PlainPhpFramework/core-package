<?php

set_include_path(__DIR__ . '/..');

require __DIR__.'/../inc/bootstrap.php';

// List of package config directories
$configPaths = array_map(
	fn($path) => ROOT . '/packages/' . $path . '/config/*', 
	\Composer\InstalledVersions::getInstalledPackagesByType('plainphp-package'))
;


// Copy the configs in the app directory
foreach ($configPaths as $config) {
	$filesToMove = glob($config);

	foreach ($filesToMove as $file) {
	    $target = ROOT .'/app/config/'.basename($file);
	    if (file_exists($target)) {
	        continue;
	    } else {
	        copy($file, $target);
	    }
	}

}

