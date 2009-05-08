<?php

if (!isset($_SESSION))
	session_start();

$rootas='../../../';
include_once($rootas.'priedai/conf.php');

include_once($rootas.'lang/lt.php');

include_once ($rootas."priedai/prisijungimas.php");
if (!isset($_SESSION['username'])) {
    admin_login_form();
}

//Extra login
if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER']!=$admin_name || $_SERVER['PHP_AUTH_PW']!=$admin_pass) {
	header("WWW-Authenticate: Basic realm=\"AdminAccess\"");
	header("HTTP/1.0 401 Unauthorized");
	die(klaida("Admin pri�jimas u�draustas","J�s m�ginate patekti � tik administratoriams skirt� viet�. Betkokie m�ginimai atsp�ti slapta�od� yra registruojami. <br/>p.s. Neken�iu bom�� ir tai faktas"));
}


/**
 * Damn Small Rich Text Editor v0.2.4 for jQuery
 * by Roi Avidan <roi@avidansoft.com>
 * Demo: http://www.avidansoft.com/dsrte/
 * Released under the GPL License
 *
 * Includes a minified version of AjaxFileUpload plugin for jQuery, taken from: http://www.phpletter.com/DOWNLOAD/
 *
 * This file handles the Server Side file upload logic.
 *
 */

/**
 * This function is used to translate strings, so your Editor may appear multi-lingual.
 * Currently, that logic is not implemented - I'm leaving it to you.
 * And yes... the name's inspirted by Drupal ;)
 *
 * @param $str
 *   String to translate.
 * @return
 *   Translated string.
 */
function t( $str )
{
    return $str;
}

/**
 * Helper function to convert arrays into JavaScript structures (JSON).
 * Uses PHP's function if available.
 *
 * @param $arr
 *   Array to convert to JSON.
 * @return
 *   JSON string representation for given array.
 */
function to_json( $arr )
{
    if ( function_exists( 'json_encode' ) )
        return json_encode( $arr );

    $str = array();
    foreach ( $arr as $key => $val )
        $str[] = is_bool( $val ) ? "\"$key\":".($val ? "true" : "false") : "\"$key\":\"$val\"";

    return "{".implode( ",", $str )."}";
}

// where you want to save your uploaded images
$uploadPath = $rootas.'siuntiniai/images';
if ($_FILES["file"]["type"] == "image/gif"
|| $_FILES["file"]["type"] == "image/jpeg"
|| $_FILES["file"]["type"] == "image/pjpeg"
|| $_FILES["file"]["type"] == "image/png"
){

// get the one and only file element from the FILES array
$file = current( $_FILES );

// verify upload was successful...
if ( $file['error'] == UPLOAD_ERR_OK )
{
    // and move the file to it's destination
    if ( !@move_uploaded_file( $file['tmp_name'], "$uploadPath/$file[name]" ) )
    {
        $error = t( "Can't move uploaded file into the $uploadPath directory" );
    }
}
else
{
    switch ( $file['error'] )
    {
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            $error = t( 'File is too big.' );
            break;

        case UPLOAD_ERR_PARTIAL:
            $error = t( 'File was only partially uploaded.' );
            break;

        case UPLOAD_ERR_NO_FILE:
            $error = t( 'No file was uploaded.' );
            break;

        case UPLOAD_ERR_NO_TMP_DIR:
            $error = t( 'Missing a temporary upload folder.' );
            break;

        case UPLOAD_ERR_CANT_WRITE:
            $error = t( 'Failed to write file to disk.' );
            break;

        case UPLOAD_ERR_EXTENSION:
            $error = t( 'File upload stopped by extension.' );
            break;
    }
}
// print results for AJAX handler
echo to_json( array( 'error' => @$error, 'path' => 'siuntiniai/images', 'file' => $file['name'], 'tmpfile' => $file['tmp_name'], 'size' => $file['size'] ) );
}
?>
