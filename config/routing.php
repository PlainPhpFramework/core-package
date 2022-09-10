<?php

use \pp\Router;

$r = new Router;

// Usage:
// $r->map->add(pathInfo, internalUri)
// $r->controllerMap->add(pathInfoControllerPart, internalUriContollerPart)
// $r->namespaceMap->add(pathInfoNamespacePart, internalUriNamespacePart)
// $r->routes->add('path/{param}', internalUri)

return $r;