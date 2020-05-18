<?php

namespace app\core;

class View{
	public $path;
	public $route;
	public $layout = 'default';

	public function __construct($route) {
		$this->route = $route;
		$this->path = $route['controller'] . '/' . $route['action'];
	}

	public function render($title, $vars = []) {
		$path = 'app/views/'.$this->path.'.php';

		extract($vars);
		if(file_exists($path)){
			ob_start();
			require $path;
			$content = ob_get_clean();
			require 'app/views/layouts/'.$this->layout.'.php';
		} else {
			echo 'Вид не найден'.$this->path;
		}
	}

	public static function errorCode($code_error) {
		$path = 'app/views/errors/'.$code_error.'.php';

		http_response_code($code_error);
		if(file_exists($path)) {
			require $path;
		}
	}

	public static function redirect($url) {
		header('location:'.$url);
	}

}
