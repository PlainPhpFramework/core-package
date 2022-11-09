<?php
/**
 * Start a new session
 */
session_name('ppsid');

$_SESSION['csrf-token'] = bin2hex(random_bytes(32));

return session_start();