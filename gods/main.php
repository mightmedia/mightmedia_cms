<?php

// sys files
$loadSysFilesArray = [
	'custom', // ?
	'users',
	'roles',
	'media',
	'pages',
];

foreach ($loadSysFilesArray as $loadSysFile) {
    require_once ADMIN_ROOT . 'sys/' . $loadSysFile . '/load.php';
}

// load templates and pages
doAction('adminRoutes');

// header data
$headerData = applyFilters('loadRoute');

if(! empty($headerData)) {
	foreach ($headerData as $keyHeaderData => $valueHeaderData) {
		${$keyHeaderData} = $valueHeaderData;
	}
}

// reset vars
// unset($headerData, $keyHeaderData, $valueHeaderData);
//

routeAjax('/' . ADMIN_DIR . '/ajax/$action');

require 'themes/material/index.php';