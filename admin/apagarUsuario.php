<?php

require('../config.php');
$usuarios = new Users;
$status =  $usuarios->verificarStatus();
if($status != 2 && $status != 1) 	die('Você não possui acesso a esta área');

if(!empty($_GET['codpes'])) {
	$usuarios->apagarUsuario($_GET['codpes']);
	header('location:index.php');
} 
else header('Location: index.php');



