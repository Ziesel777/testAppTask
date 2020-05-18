<?php

namespace app\lib;

use PDO;

class Db {
	protected $db;

	function __construct(){
		$config = require 'app/config/db.php';

		$this->db = new PDO('mysql:host='.$config['host'].';dbname='.$config['dbname'], $config['user'], $config['pass']);
	}

	public function query($sql, $params =[]) {
		$stmt = $this->db->prepare($sql, $params);
		// debug($sql);

		if(!empty($params)) {
			foreach($params as $key => $val) {
				$stmt->bindValue(':'.$key, $val);
			}
		}
		$stmt->execute();

		return $stmt;
	}

	public function getRow($sql, $params =[]) {
		$res = $this->query($sql, $params);
		return $res->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getColumn($sql, $params =[]) {
		$res = $this->query($sql, $params);
		return $res->fetchColumn();
	}
}
