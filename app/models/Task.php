<?php

namespace app\models;

use app\core\Model;

class Task extends Model{

	function __construct(){
		parent::__construct();

	}

	function addTask($name,$email,$text){
		$sql = 'INSERT INTO task(name, email, text_task) VALUES ("'.$name.'","'.$email.'","'.$text.'")';

		$this->db->query($sql);
	}

	function getTaskAll(){
		$sql = 'SELECT * FROM task';

		return $this->db->getRow($sql);
	}

	function getTaskId($id) {
		$sql = 'SELECT * FROM task WHERE id = '.$id;

		return $this->db->getRow($sql);
	}

	function setTaskId($id,$desc,$perf,$edit) {
		$sql = 'UPDATE task SET text_task = "'.$desc.'", performed = "'.$perf.'", edited = "'.$edit.'" WHERE id ="'.$id.'"';

		$this->db->query($sql);
	}
}