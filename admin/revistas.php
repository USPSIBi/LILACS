<?php
header("Content-type: text/html;charset=utf-8");
require('../config.php');
$user = new Users;
$status = $user->verificarStatus();
$obj_xml =  new Xmlojs;
$revistas = $obj_xml->listarISSN();

if($status != 2 && $status != 1) 	die('Você não possui acesso a esta área');


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
	OJS
	</div>

	<div id="leftsidebar">
	Pensar...
	</div>

<div id="bodycontent">
<h1> Banco de dados de Revistas</h1>


<table cellspacing="2" cellpadding="5" border="1">

<?php foreach ($revistas as $value) { ?>
<tr>
	<td> 		<?php echo $value['issn']  ?> </td>
	<td>	<?php echo $value['nome_revista'] ?> </td>
	<td> <a href="./exportXml.php?issn=<?php echo $value['issn'] ?>"> Exportar XML Full </a> </td>
	<td> <a href="./apagarRevista.php?issn=<?php echo $value['issn'] ?>"> Apagar revista! </a> </td>
	</td>
</tr>
<?php
}
?>

</table>

</div>
<div id="footer" class="clear">
	SIBI
</div>
</div>

</body>
</html>
