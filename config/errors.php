<?php
/**
 * Config the path of the error logs
 */
ini_set('error_log', sprintf(ROOT . '/env/logs/php_errors-%s.txt', date('Y-m-d')));