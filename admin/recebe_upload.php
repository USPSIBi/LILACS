<?php

require('../config.php');
$user = new Users;
$status = $user->verificarStatus();
if($status != 2 && $status != 1) 	die('Você não possui acesso a esta área');
$lilacs =  new Lilacs;
	// Pasta onde o arquivo vai ser salvo
	$_UP['pasta'] = './uploads/';
	 
	// Tamanho máximo do arquivo (em Bytes)
	$_UP['tamanho'] = 1024 * 1024 * 200; // 2Mb
	 
	// Array com as extensões permitidas
	$_UP['extensoes'] = array('lilacs');
	 
	// Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
	$_UP['renomeia'] = true;
	 
	// Array com os tipos de erros de upload do PHP
	$_UP['erros'][0] = 'Não houve erro';
	$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
	$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
  $_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
	$_UP['erros'][4] = 'Não foi feito o upload do arquivo';
	 
	// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
	if ($_FILES['arquivo']['error'] != 0) {
	die("Não foi possível fazer o upload, erro:<br />" . $_UP['erros'][$_FILES['arquivo']['error']]);
	exit; // Para a execução do script
	}
	 
	// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
	 
	// Faz a verificação da extensão do arquivo
	$extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
	if (array_search($extensao, $_UP['extensoes']) === false) {
	echo "Por favor, envie arquivos com a extensão lilacs";
	}
	 
	// Faz a verificação do tamanho do arquivo
	else if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
	echo "O arquivo enviado é muito grande, envie arquivos de até 20Mb.";
	}
	 
	// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
	else {
	// Primeiro verifica se deve trocar o nome do arquivo
	if ($_UP['renomeia'] == true) {
	// Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
	$nome_final = $_FILES['arquivo']['name'] . time();
	} else {
	// Mantém o nome original do arquivo
	$nome_final = $_FILES['arquivo']['name'];
	}
	 
	// Depois verifica se é possível mover o arquivo para a pasta escolhida
	if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {
	// Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
		$imports = $lilacs->extract($nome_final,$_UP['pasta'],$_POST['fonte']);
		echo " importados: {$imports[0]}, Não importados: {$imports[1]}" . "<br /><a href=\"../admin\">Clique aqui para Voltar</a>";
	} 
	else {
	// Não foi possível fazer o upload, provavelmente a pasta está incorreta
	echo "Não foi possível enviar o arquivo, tente novamente";
	}
	 
	}
 
	?>
