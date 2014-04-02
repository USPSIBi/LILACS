<?php
header("Content-type: text/html;charset=utf-8");
require('../config.php');
$user = new Users;
$status = $user->verificarStatus();
if($status != 2 && $status != 1) 	die('Você não possui acesso a esta área');
$todos = $user->listarUsuarios();
/*
if(empty($_GET['id'])) {
	header('Location: index.php');
} else {
	$id = $_GET['id'];
}

if($_POST) {
	$usuarios->alterarUsuario($id, $_POST['usuario'], $_POST['senha'], $_POST['admin']);
	header('Location: index.php');
}

$usuario = $db->pegarDado("usuarios", "*", "id = $id");
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link rel="stylesheet" href="../lilacs.css" type="text/css" media="all" />
	<title> </title>
</head>

<body>

<div id="wrapper">
	<div id="header">
	Defesas
	</div>

	<div id="leftsidebar">
	Pensar...
	</div>

<div id="bodycontent">
<h1>Usuários</h1>
<?php foreach ($todos as $value) { ?>
<?php echo $value['codpes']; ?>
<?php echo $value['nome']; ?>
<?php echo $value['email']; ?>
<a href="./alterarUsuario.php?codpes=<?php echo $value['codpes'] ?>"> Editar</a>
<a href="./apagarUsuario.php?codpes=<?php echo $value['codpes'] ?>"> Apagar</a>
<br />

<?php } ?>
</div>
	<div id="footer" class="clear">
	FFLCH
	</div>
</div>

</body>
</html>
