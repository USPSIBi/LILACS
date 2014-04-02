<?php
header("Content-type: text/html;charset=utf-8");
require('../config.php');
$usuarios = new Users;
$status = $usuarios->verificarStatus();
if($status != 2 && $status != 1) 	die('Você não possui acesso a esta área');

if(!empty($_GET['codpes'])) {
	$user = $usuarios->verUsuario($_GET['codpes']);
	if(!$user) die("Número USP não cadastrado");
}


if(!empty($_POST)){
	$usuarios->alterarUsuario($_POST,$_GET['codpes']);
	header('location:index.php');
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link rel="stylesheet" href="../defesas.css" type="text/css" media="all" />
	<title></title>
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
<form action="alterarUsuario.php?codpes=<?php echo $_GET['codpes'] ?>" method="POST">
<?php foreach ($user as $dados) { ?>

<label>Número USP </label> <br /> 
<input type="text" name="codpes" value="<?php echo $dados['codpes']; ?>" />  <br />

<label>Nome</label> <br /> 
<input type="text" name="nome" value="<?php echo $dados['nome']; ?>" />  <br />

<label>Senha: </label> <br /> 
<input type="password"  name="password"> Deixe em branco para manter a senha atual<br />
 
<label>Email: </label><br />
<input type="text"  name="email" value="<?php echo $dados['email']; ?>" /> <br />

<label> Administrador? </label>
<select name="permission"> 
  <option value="2" <?php if($dados['permission']==2) echo 'selected="selected"'; ?> >Sim</option>
  <option value="1" <?php if($dados['permission']==1) echo 'selected="selected"'; ?> >Não</option>
</select>
 
<?php } ?>
<br />
<input type="submit" value="Aplicar Alterações" >
</form>
</div>

	<div id="footer" class="clear">
	FFLCH
	</div>
</div>

</body>
</html>
