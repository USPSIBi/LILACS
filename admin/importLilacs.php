<?php
header("Content-type: text/html;charset=utf-8");
require('../config.php');
$user = new Users;
$status = $user->verificarStatus();
$lilacs =  new Lilacs;

if($status != 2 && $status != 1) 	die('Você não possui acesso a esta área');


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
	OJS
	</div>

	<div id="leftsidebar">
	Pensar...
	</div>

<div id="bodycontent">
<h1> Importar revistas </h1>

<h3>Faça o upload do arquivo no formato Lilacs</h3>
<form method="post" action="recebe_upload.php" enctype="multipart/form-data">

<label>Fonte: </label>
<select name="fonte">
        <option value="http://www.scielo.br/pdf/" selected="selected"> Scielo </option>
        <option value="http://www.revistasusp.sibi.usp.br/pdf/"> USP </option>
</select>  <br /> <br />


<label>Arquivo</label>
<input type="file" name="arquivo" />
<input type="submit" value="Enviar" />
</form>

<br />

</div>
<div id="footer" class="clear">
	SIBI
</div>
</div>

</body>
</html>
