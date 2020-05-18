<?php

namespace app\models;

use app\core\Model;

class User extends Model{

	function __construct(){
		parent::__construct();

	}

	function addUser($name,$pass){
		$sql = 'INSERT INTO users(name, pass) VALUES ("'.$name.'","'.$pass.'")';

		$this->db->query($sql);
	}

	function getUsersAll(){
		$sql = 'SELECT * FROM users';

		return $this->db->getRow($sql);
	}
}