<?php
//header("Content-type: text/html;charset=utf-8");

class Sections
{ 
	private $banco;
	public function __construct() {
		$this->banco = Banco::instanciar();
	}

	// recebe o nome do arquivo e caminho no server
	public function importSection($file,$caminho) {
		$file = $caminho . $file ;
		if ( is_file( $file ) && is_readable( $file ) ){
			$ponteiro = fopen ($file, "r");
			while ($informacao = fgetcsv($ponteiro, filesize($file), ",")) {
				$informacao[0] = trim($informacao[0]);
				$post = array('code'=>"$informacao[0]",'locale'=>"$informacao[1]",'name'=>"$informacao[2]"); 
				$this->banco->inserir('sections',$post);
			}
			fclose($ponteiro);
	  }

	}
	public function dataSection($code) {
		$onde = " code = '$code' ";
		return $this->banco->listar('sections','name, locale', "$onde");
	}
}



include('../config.php');
$obj = new Sections;

$caminho = "/code/git/serradas/dados/";
$file = "portal_ojs_secoes.csv";
$obj->importSection($file,$caminho);

//$data = $obj->name('RLAE020');
//echo "<pre>";
//print_r($data);

?>
