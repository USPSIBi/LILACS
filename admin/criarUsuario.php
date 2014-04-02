<?php

require('../config.php');
$usuarios = new Users;
$status = $usuarios->verificarStatus();
if($status != 2 && $status != 1) 	die('Você não possui acesso a esta área');

if(!empty($_POST)){
	$usuarios->cadastrarUsuario($_POST);
	header('location:index.php');
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link rel="stylesheet" href="../defesas.css" type="text/css" media="all" />
	<title> </title>
</head>

<body>


<div id="wrapper">
	<div id="header">
	Defesas
	</div>

	<div id="leftsidebar">
	Pensar
	</div>

<div id="bodycontent">
<form action="criarUsuario.php" method="POST">
<label>Número USP: </label> <br /> 
<input type="text" name="codpes" />  <br />

<label>Nome completo: </label> <br /> 
<input type="text" name="nome" />  <br />

<label>Senha: </label> <br /> 
<input type="password"  name="password"><br />
 
<label>Email: </label><br />
<input type="text"  name="email"> <br />

<label> Administrador? </label>
<select name="permission"> 
  <option value="2"> Sim </option>
  <option value="1" selected="selected"> Não </option>
</select>
 
<br />
<input type="submit" value="Criar Usuario" >
</form>
</div>
	<div id="footer" class="clear">
	FFLCH
	</div>
</div>


</body>
</html>
