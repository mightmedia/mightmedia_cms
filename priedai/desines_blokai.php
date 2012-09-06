<?php

/**
 * @Projektas: MightMedia TVS
 * @Puslapis: www.coders.lt
 * @$Author: FDisk $
 * @copyright CodeRS ©2008
 * @license GNU General Public License v2
 * @$Revision: 482 $
 * @$Date: 2010-03-21 00:06:16 +0200 (Sun, 21 Mar 2010) $
 **/

$sql_p = mysql_query1( "SELECT * FROM `" . LENTELES_PRIESAGA . "panel` WHERE `align`='R' AND `lang` = " . escape( lang() ) . " ORDER BY `place` ASC", 120 );

foreach ( $sql_p as $row_p ) {
	if ( teises( $row_p['teises'], $_SESSION['level'] ) ) {
		if ( is_file( "blokai/" . $row_p['file'] ) ) {
			include_once ( "blokai/" . $row_p['file'] );
			if ( !isset( $title ) ) {
				$title = $row_p['panel'];
			}
			if ( $row_p['show'] == 'Y' && isset( $text ) && !empty( $text ) && isset( $_SESSION['level'] ) && teises( $row_p['teises'], $_SESSION['level'] ) ) {
				lentele_r( $title, $text );
				unset( $title, $text );
			} elseif ( isset( $text ) && !empty( $text ) && $row_p['show'] == 'N' && isset( $_SESSION['level'] ) && teises( $row_p['teises'], $_SESSION['level'] ) ) {
				echo $text;
				unset( $text, $title );
			} else {
				unset( $text, $title );
			}
		} else {
			echo lentele_r( "{$lang['system']['error']}", "{$lang['system']['nopanel']}.", $row_p['file'] );
		}
	}
}
unset( $sql_p, $row_p );

?>