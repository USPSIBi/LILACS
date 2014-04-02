<?php

class Users {
	private $banco;
	public function __construct(){
		$this->banco = Banco::instanciar();
	}
	//scheme of table: username, email, password, created_at,updated_at,permission
	public function logar($post){
		$post['password'] = md5($post['password']);
		$where = " (`codpes` = '{$post['codpes']}' AND password = '{$post['password']}') ";
		$consulta = $this->banco->listar('users'," codpes ",$where);
		if(!empty($consulta)){
			$_SESSION['sessao'] = 'logado'; 
			$_SESSION['codpes'] = $post['codpes']; 
			$_SESSION['codpes'] = $consulta[0]['codpes']; 
			return true;
		} 
		else return false;
	}

	public function deslogar(){
		unset($_SESSION);
		session_destroy();
	}
	public function verificarStatus(){
		if( isset($_SESSION['sessao']) && $_SESSION['sessao'] == 'logado' ) {
			$codpes = $_SESSION['codpes'];
			$where = " codpes = '$codpes' ";
			$consulta = $this->banco->listar('users'," permission ",$where);
			if(!empty($consulta))  return $consulta[0]['permission'];
			else return 0; 
		}
		else return 0;

	}
	public function cadastrarUsuario($post){
		$post['password'] = md5($post['password']);
		$post['created_at'] = date('Y-m-d H:i:s');
		$post['updated_at'] = date('Y-m-d H:i:s');
		if(empty($post['permission'])) $post['permission'] = 1;
		$this->banco->inserir('users',$post);
	}

	public function listarUsuarios(){
		return $this->banco->listar('users');
	}
	public function verUsuario($codpes){
		$where = " codpes = $codpes";
		return $this->banco->listar('users','*',$where);
	}
	
	public function alterarUsuario($post,$codpes) {
		$post['updated_at'] = date('Y-m-d H:i:s');
		if(empty($post['password'])) {
			unset($post['password']);
		}
		else {
			$post['password'] = md5($post['password']);
		}
		$this->banco->alterar('users',$post,"codpes = $codpes");
	}

	public function apagarUsuario($codpes){
		$where = "codpes = $codpes";
		$this->banco->apagar('users',$where);
	} 
}

//include('../config.php');
//$obj = new Users;

//criar usuário
//$post = array('username'=>'thiago', 'email'=>'baby@htmail.com', 'id_user'=>'1');
//$obj->cadastrarUsuario($post);

//apagar usuário
//$obj->apagarUsuario(14);

//logar usuário
//$post = array('username'=>'thiago','password'=>'123456');
//$teste=$obj->logar($post);
//$teste ? $a="verdadeiro" : $a="falso"; echo "$a <br>";
//print_r($_SESSION);

//deslogar
//$post = array('username'=>'baby','password'=>'123456');
//$teste=$obj->logar($post);
//echo "antes: <br>";
//print_r($_SESSION);
//$obj->deslogar();
//echo "depois <br>";
//print_r($_SESSION);

//verificar status
//echo"<br />" . ($obj->verificarStatus());

//listar Usuários
//echo "<pre>";
//print_r($obj->listarUsuarios());

//alterar Usuario
//$post = array('username'=>'bruno','password'=>'123456');
//$obj-> alterarUsuario($post,21);
?>
