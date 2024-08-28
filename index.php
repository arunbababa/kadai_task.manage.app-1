<?php

define('FUEL_ENV', 'development');

// Set environment to development if not already set
if (!defined('FUEL_ENV')) {
    define('FUEL_ENV', 'development');
}

// Path to the application directory
$app_path = __DIR__.'/fuel/app/';
// Path to the core directory
$core_path = __DIR__.'/fuel/core/';
// Path to the packages directory
$package_path = __DIR__.'/fuel/packages/';

// Define the paths
define('APPPATH', realpath($app_path).'/');
define('PKGPATH', realpath($package_path).'/');
define('COREPATH', realpath($core_path).'/');

// Bootstrap the application
require APPPATH.'bootstrap.php';

// Execute the main request
$response = Request::forge()->execute()->response();
$response->send(true);
