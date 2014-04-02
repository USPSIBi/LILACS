<?php

require('../config.php');
$user = new Users;
$status = $user->verificarStatus();
$lilacs =  new Lilacs;

if($status != 2 && $status != 1) 	die('Você não possui acesso a esta área');

if(!empty($_GET['issn'])) {
	$lilacs->apagarRevista($_GET['issn']);
	header('Location:revistas.php');
} 
else header('Location:revistas.php');
