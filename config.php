<?php
header ( "Content-type: text/html;charset=utf-8" );
define('DBHOST','localhost');
define('DBNAME','lilacs');
define('DBUSER','lilacs');
define('DBSENHA','lilacs');

session_start();

function __autoload($classe) {
	if(file_exists("app/$classe.php") ){
		require_once("app/$classe.php");
	} else {	
		require_once("classes/$classe.class.php");
	}
}
