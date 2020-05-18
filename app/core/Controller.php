<?php

namespace app\core;

use app\core\View;

abstract class Controller {
	public $route;
	public $view;
	public $model;
	public $acl;

	public function __construct($route){
		$this->route = $route;
		if(!$this->checkAcl()){
			if($_POST){
				print json_encode([
					'success'=>false,
					'error'=>'admin'
				]);
				exit();
			}else if($route['controller']=='main'){
				View::redirect('/account/login');
			} else if($route['controller']=='account'){
				View::redirect('/');
			}
		}
		$this->view = new View($route);
		$this->model = $this->loadModel($route['controller']);
	}

	public function loadModel($name){
		$path = 'app\models\\'.ucfirst($name);
		if(class_exists($path)){
			return new $path;
		}
	}

	public function checkAcl(){
		$this->acl = require 'app/acl/'.$this->route['controller'].'.php';

		if (!$this->isAdmin() && $this->isAcl('all')) {
			return true;
		} else if ($this->isAdmin() && $this->isAcl('admin')) {
			return true;
		}
		return false;
	}

	public function isAcl($key){
		return in_array($this->route['action'], $this->acl[$key]);
	}

	public function isAdmin(){
		if(isset($_SESSION['admin'])){
			return $_SESSION['admin'];
		}
		return false;
	}
}