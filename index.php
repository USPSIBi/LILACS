<?php

require('config.php');
$users = new Users;

$status = $users->verificarStatus();
if($status) header('location:./admin/index.php');


if(!empty($_POST)){
	$log = $users->logar($_POST);
	if($log) header('location:./admin/index.php');
	else header('location:./index.php');	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
    <head>
        <title> Lilacs->OJS </title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
				<link rel="stylesheet" href="defesas.css" type="text/css" media="all" />
    </head>

<body>

<div id="wrapper">
	<div id="header">
	Lilacs->OJS
	</div>

	<div id="leftsidebar">
	<form action="index.php" method="POST">

	<label>N. USP </label> <br />
	<input type="text" name="codpes" /><br />
 
	<label>Senha </label> <br />
	<input type="password" name="password" /><br />
 
	<input type="submit" value="Logar" >
	</form>
	</div>

	<div id="bodycontent">
	Sou um guardador de rebanhos. <br />
O rebanho é os meus pensamentos <br />
E os meus pensamentos são todos sensações. <br />
Penso com os olhos e com os ouvidos <br />
E com as mãos e os pés <br />
E com o nariz e a boca. <br /><br />

Em: <b>Poemas Completos de Alberto Caeiro </b>
	</div>


	<div id="footer" class="clear">
	SIBI - USP
	</div>
</div>

</body>
</html>
