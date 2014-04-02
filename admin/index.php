<?php
# Informa qual o conjunto de caracteres será usado.
header('Content-Type: text/html; charset=utf-8');

require('../config.php');
$usuario = new Users;
$status = $usuario->verificarStatus();
if($status != 2 && $status != 1) 	die('Você não possui acesso a esta área');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<script type="text/javascript" src="../js/jquery1.7.1.js"></script>
	<script type="text/javascript" src="../js/custom/js/jquery-ui-1.8.17.custom.min.js"></script>
	<script type="text/javascript" src="../js/defesas.js"></script>
	<script type="text/javascript" src="../js/ui.datepicker-pt-BR.js"></script>
	<link rel="stylesheet" href="../js/custom/css/start/jquery-ui-1.8.17.custom.css" type="text/css" media="all" />
	<link rel="stylesheet" href="../defesas.css" type="text/css" media="all" />
	<title> Lilacs->OJS </title>
</head>

<body>

<div id="wrapper">
	<div id="header">
	Lilacs->OJS
	</div>

	<div id="leftsidebar">
	<ul class="menu">
		<li>Usuários</li>
			<ul class="menu">
				<li class="expanded"><a href="./criarUsuario.php">Criar novo usuário</a></li>
				<li class="expanded"><a href="./verUsuarios.php">Listar Usuários</a></li>
			</ul>

		<li>SIBI</li>
		<ul class="menu">
			<li class="expanded"><a href="./importLilacs.php">Importar Lilacs</a></li>
			<li class="expanded"><a href="./revistas.php"> Revistas </a></li>
		</ul>

		<li><a href="../logout.php">Sair</a></li>
	</ul>
	</div>

	<div id="bodycontent">
	<h3>Falta fazer: </h3> 
		<ul>
			<li>Título nulo - ok</li>
			<li>PDF em outras línguas</li>
			<li>DOI</li>
			<li>ahed na v085</li>
			<li>apagar autor, afiliações</li>
			<li> corrigir afiliações múltiplas </li>
			<li> tabelas logs </li>
		</ul>
	</div>

	<div id="footer" class="clear">
	FFLCH
	</div>
</div>

</body>
</html>
