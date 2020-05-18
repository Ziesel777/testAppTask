<?php
require 'app/lib/dev.php';

use app\core\Router;

// debug($_SERVER);
// phpinfo();

spl_autoload_register(function($class) {
	$path = str_replace('\\', '/', $class.'.php');

	// $path = strtolower($path);
	if (file_exists($path)) {
		require $path;
	}
});

session_start();

$router = new Router;
$router->run();