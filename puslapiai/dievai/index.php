<?php

/**
 * @Projektas: MightMedia TVS
 * @Puslapis: www.coders.lt
 * @$Author$
 * @copyright CodeRS ©2008
 * @license GNU General Public License v2
 * @$Revision$
 * @$Date$
 **/

if ($_SERVER['PHP_SELF'] == 'index.php') {
	die($lang['system']['notadmin']);
}
include_once ("priedai/prisijungimas.php");
if (!isset($_SESSION['username'])) {
	admin_login_form();
}
// Jei lanktytojas neprisijungęs arba, jei nėra administratorius
elseif (!defined("LEVEL") || LEVEL > 1 || !defined("OK") || !isset($_SESSION['username'])) {
	redirect("?home");
}

if (isset($url['a']) && isnum($url['a']) && $url['a'] > 0) { $aid = (int)$url['a']; } else {	$aid = 0; }
if (isset($url['id']) && isnum($url['id']) && $url['id'] > 0) { $id = (int)$url['id']; } else {	$id = 0; }

if ($conf['keshas'] && isset($_POST) && !empty($_POST) && sizeof($_POST) > 0) {
	//išvalom keshą jeigu ijungtas
	if(($count = count($glob = glob("sandeliukas/*.php"))) > 0) {
	    foreach($glob as $v) {
			unlink($v);
	    }
	}
}

$glob = glob('puslapiai/dievai/*.php');

$text = "<table border=\"0\"><tr><td><div class=\"btns\">\n";
foreach($glob as $id => $file) {
	$file = basename($file,'.php');
	$admin_pages[$id] = $file;
	$admin_pagesid[$file] = $id;
	if ((isset($conf['puslapiai'][$file.'.php']['id']) || in_array($file, array('config','meniu','logai','paneles','vartotojai','komentarai','banai','balsavimas'))) && !in_array($file, array('index','pokalbiai'))) {
		$text .= "<a href=\"?id," . $url['id'] . ";a,{$id}\" class=\"btn\"><span style=\"min-width:95px;\"><img src=\"images/admin/{$file}.png\" alt=\"".(isset($lang['admin'][$file])?$lang['admin'][$file]:$file)."\" title=\"".(isset($lang['admin'][$file])?$lang['admin'][$file]:$file)."\" /><br />".(isset($lang['admin'][$file])?$lang['admin'][$file]:$file)."</span></a>";
	}
}
$text .= "</div><br style=\"clear:left\"/></td></tr></table>\n";

lentele($lang['user']['administration'],$text);

// Įkeliamas puslapis
if (isset($url['a']) && file_exists(dirname(__file__) . "/" . $admin_pages[(int)$url['a']].'.php') && isset($_SESSION['username']) && $_SESSION['level'] == 1 && defined("OK")) {
	include_once (dirname(__file__) . "/" . $admin_pages[(int)$url['a']].'.php');
} else {
	lentele('MightMedia TVS Naujienos', '<iframe src="http://code.assembla.com/mightmedia/subversion/node/blob/naujienos.html" width="100%" height="100" frameborder="0"></iframe>');
	include_once (dirname(__file__) . "/pokalbiai.php");
}

?>