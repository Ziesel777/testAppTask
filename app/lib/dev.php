<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

function debug($data){
	echo '<pre>';
	var_dump($data);
	echo '</pre>';
}

function clg($data){
	echo '<script>';
	echo 'console.log('. json_encode( $data ) .')';
	echo '</script>';
}
