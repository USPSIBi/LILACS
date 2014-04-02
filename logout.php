<?php

require('config.php');

$usuarios = new Users;
$status=$usuarios->verificarStatus();
if(!$status) die ('Vc nao esta logado');

$usuarios->deslogar();
header('location:index.php');


