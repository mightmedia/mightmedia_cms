<?php

$data2 = [];
$res   = mysql_query1( 'SELECT * FROM `' . LENTELES_PRIESAGA . 'page` WHERE `lang`=' . escape( lang() ) . ' ORDER BY `place` ASC', 3600 );
foreach ( $res as $row ) {
	if ( teises( $row['teises'], getSession('level')) && $row['show'] == 'Y' ) {
		$data2[$row['parent']][] = $row;
	} elseif ( teises( $row['teises'], getSession('level')) && $row['show'] == 'N' && $row['file'] != 'view_user.php' ) {
		$data3[$row['parent']][] = $row;
	}
}
$tree        = site_tree( $data2 );
$hidden_tree = site_tree( $data3 );
lentele( $page_pavadinimas, $tree );
lentele( getLangText('tree', 'hidden'), $hidden_tree );
