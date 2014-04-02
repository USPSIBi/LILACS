<?php
header("Content-type: text/html;charset=utf-8");
require('../config.php');
$user = new Users;
$status = $user->verificarStatus();
if($status != 2 && $status != 1) 	die('Você não possui acesso a esta área');

$obj =  new Xmlojs;
$caminho = './uploads/';

if(!empty($_GET['issn'])) {
	$file = $obj->montaXml($_GET['issn'],$caminho);
	echo " <br />Clique com lado direiro, e depois em salvar como: <a href=\"uploads/$file\" target=\"_blank\"> Baixar XML Gerado </a> " . "<br /><a href=\"../admin\">Clique aqui para Voltar</a>";
} else {
	header('Location:revistas.php');
}


?>

