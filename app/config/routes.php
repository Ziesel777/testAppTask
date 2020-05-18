<?php

return [
	'account/login' => [
		'controller' => 'account',
		'action' => 'login'
	],
	'account/logout' => [
		'controller' => 'account',
		'action' => 'logout'
	],
	'account/user' => [
		'controller' => 'account',
		'action' => 'user'
	],
	'account/isadmin' => [
		'controller' => 'account',
		'action' => 'isAdmin'
	],
	'' => [
		'controller' => 'main',
		'action' => 'index'
	],
	'addtask' => [
		'controller' => 'main',
		'action' => 'addTask'
	],
	'gettask' => [
		'controller' => 'main',
		'action' => 'getTask'
	],
	'getidtask' => [
		'controller' => 'main',
		'action' => 'getTaskId'
	],
	'setidtask' => [
		'controller' => 'main',
		'action' => 'setTaskId'
	],
];