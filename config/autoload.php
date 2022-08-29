<?php
$loader = require ROOT . '/vendor/autoload.php';

$includePaths = explode(PATH_SEPARATOR, get_include_path());

// Add to the include paths all the installed packages
$packagePaths = array_map(
	fn($path) => ROOT . '/packages/' . $path, 
	\Composer\InstalledVersions::getInstalledPackagesByType('plainphp-package'))
;

$includePaths = array_unique(array_merge($includePaths, $packagePaths));

set_include_path(implode(PATH_SEPARATOR, $includePaths));

return $loader;