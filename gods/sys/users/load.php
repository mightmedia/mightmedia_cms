<?php

// add admin user page
function userRoutes()
{
	// pagination
	newRoute(
		'users.list.pagination', 
		[
			'method'	=> 'get',
			'route'		=> '/' . ADMIN_DIR . '/users/list/page/$page',
			'include'	=> ADMIN_ROOT . 'sys/users/list.php',
			'query'		=> [
				'table' 		=> 'users',
				'pagination'	=> true
			],
			'header'	=> [
				'pageName' => 'Users'
			],
		]
	);
	// list
	newRoute(
		'users.list', 
		[
			'method'	=> 'get',
			'route'		=> '/' . ADMIN_DIR . '/users/list',
			'include'	=> ADMIN_ROOT . 'sys/users/list.php',
			'query'		=> [
				'table' 		=> 'users',
				'pagination'	=> true
			],
			'header'	=> [
				'pageName' => 'Users'
			],
		]
	);
	// edit
	newRoute(
		'users.edit', 
		[
			'method'	=> 'get',
			'route'		=> '/' . ADMIN_DIR . '/users/edit/$id-$slug',
			'include'	=> ADMIN_ROOT . 'sys/users/edit.php',
			'query'		=> [
				'table'	=> 'users',
				'where' => [
					'id' 	=> 'param.id',
				],
				'row' => true
			],
			'header'	=> [
				'pageName' => 'Users'
			],
		]
	);
}

addAction('adminRoutes', 'userRoutes');

function userMenu($data)
{
	$route = '/' . ADMIN_DIR . '/users';

	$data['users'] = [
		'url' 	=> $route,
		'title' => 'Users',
		'icon' 	=> 'person',
		'sub'	=> [
			[
				'url' 	=> $route . '/list',
				'title' => 'Users list',
			],
			[
				'url' 	=> $route . '/create',
				'title' => 'Users new',
			]
		]
	];
	
	return $data;
}

addAction('adminMenu', 'userMenu');

// disdplay users list

// edit user

// create user

// if we need
// require_once 'functions.php';