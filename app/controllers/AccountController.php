<?php

namespace app\controllers;

use app\core\Controller;
use app\models\User;
use app\core\View;

class AccountController extends Controller{
	public $m_user;

	function __construct($route){
		parent::__construct($route);

		$this->m_user = new User;
	}

	public function loginAction() {
		// debug($this->isAdmin());
		$this->view->render('Авторизация');
	}

	public function logoutAction() {
		unset($_SESSION['admin']);
		View::redirect('/');
	}

	public function userAction() {
		$name = $_POST['name'];
		$pass = $_POST['pass'];

		$user = [
			'name'=>$name,
			'pass'=>$pass
		];

		$users = $this->m_user->getUsersAll();
		// $isUser=$this->isUser($user, $users);

		if($name && $pass){
			if($this->isUser($user, $users)){
				$_SESSION['admin']=true;
				print json_encode(['success'=>true]);
			} else {
				print json_encode(['success'=>false]);
			}
		} else {
			print json_encode(['success'=>false]);
		}
	}

	public function isAdminAction(){
		print json_encode($this->isAdmin());
	}

	function isUser($user,$users) {
		foreach ($users as $key => $item) {
			if ($item['name']!=$user['name']) {
				continue;
			} else if($item['pass']!=$user['pass']) {
				break;
			} else {
				return true;
			}
		}

		return false;
	}
}