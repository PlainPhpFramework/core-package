<?php
/**
 * Return an instance of the database object
 */
$db = new \pp\Db($_ENV['DB_DSN'], $_ENV['DB_USERNAME'], @$_ENV['DB_PASSWORD']);
return $db;