<?php
/**
 * PHPUnit Bootstrap File
 * Initializes test environment and autoloading
 */

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Define project root
define('PROJECT_ROOT', dirname(dirname(__FILE__)));

// Autoload classes if using PSR-4 or similar
// require_once PROJECT_ROOT . '/vendor/autoload.php';

// Include configuration (use test config if available)
if (file_exists(PROJECT_ROOT . '/config.test.php')) {
    require_once PROJECT_ROOT . '/config.test.php';
} else {
    require_once PROJECT_ROOT . '/config.php';
}

// Set test timezone
date_default_timezone_set('UTC');
?>
