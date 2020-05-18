<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Task;

class MainController extends Controller{
	public $m_task;

	function __construct($route){
		parent::__construct($route);

		$this->m_task = new Task;
	}

	public function indexAction() {
		$vars = [
			'isAdmin'=>$this->isAdmin(),
		];

		$this->view->render('Главная страница', $vars);
	}

	public function addTaskAction() {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$desc = $_POST['desc'];

		if($name && $desc && $email){
			$this->m_task->addTask($name, $email, $desc);

			print json_encode(['success'=>true]);
		} else {
			print json_encode(['success'=>false]);
		}
	}

	public function getTaskAction() {
		$tasksAll = $this->m_task->getTaskAll();

		header('Content-Type: application/json');
		print json_encode($tasksAll);
	}

	public function getTaskIdAction() {
		$id = $_POST['id'];

		if($id){
			$task = $this->m_task->getTaskId($id);

			header('Content-Type: application/json');
			print json_encode([
				'data'=>$task[0]
			]);
		}
	}

	public function setTaskIdAction() {
		$id = $_POST['id'];
		$desc = $_POST['desc'];
		$perf = $_POST['perf'];
		$edit = $_POST['edit'];

		if($id && $desc){
			$this->m_task->setTaskId($id, $desc, $perf, $edit);

			print json_encode(['success'=>true]);
		} else {
			print json_encode([
				'success'=>false
			]);
		}
	}
}