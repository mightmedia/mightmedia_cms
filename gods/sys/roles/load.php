<?php

// add admin user page
function roleRoutes()
{
	// pagination
	newRoute(
		'roles.list.pagination', 
		[
			'method'	=> 'get',
			'route'		=> '/' . ADMIN_DIR . '/roles/list/page/$page',
			'include'	=> ADMIN_ROOT . 'sys/roles/list.php',
			'query'		=> [
				'table' 		=> 'roles',
				'pagination'	=> true
			],
			'header'	=> [
				'pageName' => 'Roles'
			],
		]
	);
	// list
	newRoute(
		'roles.list', 
		[
			'method'	=> 'get',
			'route'		=> '/' . ADMIN_DIR . '/roles/list',
			'include'	=> ADMIN_ROOT . 'sys/roles/list.php',
			'query'		=> [
				'table' 		=> 'roles',
				'pagination'	=> true
			],
			'header'	=> [
				'pageName' => 'Roles'
			],
		]
	);
	// edit
	newRoute(
		'roles.edit', 
		[
			'method'	=> 'get',
			'route'		=> '/' . ADMIN_DIR . '/roles/edit/$id-$slug',
			'include'	=> ADMIN_ROOT . 'sys/roles/edit.php',
			'query'		=> [
				'table'	=> 'roles',
				'where' => [
					'id' 	=> 'param.id',
				],
				'row' => true
			],
			'header'	=> [
				'pageName' => 'roles'
			],
		]
	);
}

addAction('adminRoutes', 'roleRoutes');

function rolesMenu($data)
{
	$route = '/' . ADMIN_DIR . '/roles';

	$data['roles'] = [
		'url' 	=> $route,
		'title' => 'Roles',
		'icon' 	=> 'group',
		'sub'	=> [
			[
				'url' 	=> $route . '/list',
				'title' => 'Roles list',
			],
			[
				'url' 	=> $route . '/create',
				'title' => 'Roles new',
			]
		]
	];
	
	return $data;
}

addAction('adminMenu', 'rolesMenu');

// disdplay users list

// edit user

// create user

// if we need
// require_once 'functions.php';

function rolesStyles()
{
	echo '<!-- Multi Select Css -->
    <link href="' . adminUrl('themes/material/plugins/multi-select/css/multi-select.css') . '" rel="stylesheet">';
}

addAction('adminStyles', 'rolesStyles');

function rolesScripts()
{
	?>
	<!-- Multi Select JS -->
    <script src="<?php echo adminUrl('themes/material/plugins/multi-select/js/jquery.multi-select.js') ?>"></script>
	
	<script>
		//Multi-select
		$('#optgroup').multiSelect({ selectableOptgroup: true });
	</script>
	
<?php
}

addAction('adminScripts', 'rolesScripts');