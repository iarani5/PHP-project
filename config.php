<?php
session_start( );
$cnx=mysqli_connect('localhost','root','','redmascotera');

function check( ){
	if( !isset($_SESSION['logueado']) ){
		header("Location: index.php?estado=no logueado");
	}
}
function print_f($str){
	$cod=mb_detect_encoding($str,'UTF-8,ISO-8859-1');
	$str=iconv($cod,'UTF-8',$str);
	echo $str;
}
function control( $s ){
	global $cnx;
	return mysqli_real_escape_string($cnx, $s);
}

?>