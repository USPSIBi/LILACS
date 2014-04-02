<?php
header ( "Content-type: text/html;charset=utf-8" );
// header("Content-Type: text/html; charset=ISO-8859-1");
class Lilacs {
	private $banco;
	public function __construct() {
		$this->banco = Banco::instanciar ();
	}
	// recebe o nome do arquivo e caminho no server
	public function extract($file, $caminho, $fonte) {
		$gravados = array ();
		$importados = 0;
		$nao_importados = 0;
		$file = $caminho . $file;
		if (is_file ( $file ) && is_readable ( $file )) {
			$ponteiro = fopen ( $file, "r" );
			$informacao = fread ( $ponteiro, filesize ( $file ) ); // Le o arquivo inteiro para a variável informacao
			fclose ( $ponteiro );
		}
		// Retira TAGS HTML
		$informacao = html_entity_decode ( iconv ( 'ISO-8859-1', 'UTF-8', $informacao ) );
		// Retira TAG do Sanatás
		$informacao = preg_replace ( '/\^x(\d+|\**)/', '', $informacao );
		// divisão por registro, ou documento
		error_log ( $informacao );
		$informacao = explode ( "!ID", $informacao );
		foreach ( $informacao as $register ) {
			// Zerando problemáticos, a cada registro as variáveis devem ser geradas
			$title_article = array ();
			unset ( $line );
			$line = array ();
			unset ( $data_section );
			unset ( $auxiliar );
			unset ( $number_authors );
			unset ( $number_affiliation );
			unset ( $number_indexing );
			unset ( $id_affiliations );
			unset ( $affiliation );
			$vetor_affiliation = array ();
			$author = array ();
			$doi = array ();
			unset ( $afiliacoes_do_autor );
			// Contar números de autores, afiliações e palavras chave
			$number_authors = substr_count ( $register, "!v010!" );
			$number_affiliation = substr_count ( $register, "!v070!" );
			$number_indexing = substr_count ( $register, "!v085!" );
			
			// Divisão de cada registro/documento em várias linhas
			$register = explode ( "\n", $register );
			foreach ( $register as $vetor ) {
				switch (substr ( $vetor, 0, 6 )) {
					// Pegar Títulos dos artigos
					case "!v012!" :
						if (strpos ( $vetor, "^l" )) {
							$auxiliar = str_replace ( "^", "___^", substr ( $vetor, 6 ) );
							$auxiliar = explode ( "___", $auxiliar );
							foreach ( $auxiliar as $vector_article ) {
								if (substr ( $vector_article, 0, 2 ) == "^l")
									$title_article ['idioma'] = trim ( substr ( $vector_article, 2 ) );
								else
									$title_article ['title'] = $vector_article;
							}
							$line ['title_article_' . $this->ajustarLocale ( $title_article ['idioma'] )] = trim ( $title_article ['title'] );
						} 						// se não tiver locale atribui o título para pt_br
						else
							$line ['title_article_pt_br'] = substr ( $vetor, 6 );
						break;
					// abstract em várias línguas
					case "!v083!" :
						$locale = 'pt_br';
						if (strpos ( $vetor, "^l" )) {
							$locale = $this->ajustarLocale ( trim ( substr ( $vetor, strpos ( $vetor, "^l" ) + 2, 2 ) ) );
							$line ['abstract_' . $locale] = trim ( substr ( $vetor, strpos ( $vetor, "^a" ) + 2 ) );
							// em caso de não estar definido locale, procure só pelo ^a eatribui para pt-br
						} else
							$line ['abstract_' . $locale] = trim ( substr ( $vetor, strpos ( $vetor, "^a" ) + 2 ) );
						$this->removerTodasTagsLilacs ( $line ['abstract_' . $locale] );
						break;
					// nomes das seções com locale
					case "!v049!" :
						$data_section = trim ( substr ( $vetor, 6 ) );
						if ($data_section == 'nd')
							$data_section = 'nd' . rand ();
						$line ['code_section_scielo'] = $data_section;
						$data_section = $this->dataSection ( $data_section );
						if (count ( $data_section ) == 0) {
							// $line['title_section_pt_br'] = "nd" . time();
							// $line['code_section_scielo'] = "nd" . time();
						} else
							foreach ( $data_section as $value )
								$line ['title_section_' . $this->ajustarLocale ( $value ['locale'] )] = $value ['name'];
						break;
					// autor
					case "!v010!" :
						$auxiliar = str_replace ( '^', '___^', substr ( $vetor, 6 ) ); // manobra imbecil...
						$auxiliar = explode ( '___', $auxiliar );
						foreach ( $auxiliar as $data_author ) {
							switch (substr ( $data_author, 0, 2 )) {
								case "^n" :
									$nome_completo = explode ( " ", substr ( $data_author, 2 ) );
									$author ['firstname'] = $nome_completo [0];
									unset ( $nome_completo [0] );
									$author ['middlename'] = implode ( " ", $nome_completo );
									break;
								case "^s" :
									$author ['lastname'] = trim ( substr ( $data_author, 2 ) );
									break;
								case "^1" :
									$author ['affiliation'] = trim ( substr ( $data_author, 2 ) );
									break;
							}
						}
						// Tem autores que não tem afiliação A01
						if (! isset ( $author ['affiliation'] ))
							$author ['affiliation'] = 'A01';
						$author = $this->iso2utf8 ( $author );
						$id_gerado = $this->banco->inserir ( 'authors', $author );
						if (isset ( $line ['ids_authors'] ))
							$line ['ids_authors'] .= "-" . $id_gerado;
						else
							$line ['ids_authors'] = $id_gerado;
						break;
					// possíveis afiliações
					case "!v070!" :
						$aux_affiliation = str_replace ( '^', '___^', substr ( $vetor, 6 ) );
						$aux_affiliation = explode ( '___', $aux_affiliation );
						$affiliation ['affiliation'] = $aux_affiliation [0];
						foreach ( $aux_affiliation as $value_aff ) {
							switch (substr ( $value_aff, 0, 2 )) {
								case "^i" :
									$affiliation ['code'] = substr ( $value_aff, 2 );
									break;
								case "^p" :
									$affiliation ['country'] = substr ( $value_aff, 2 );
									break;
								case "^e" :
									$affiliation ['email'] = substr ( $value_aff, 2 );
									break;
								case "^1" :
									$affiliation ['affiliation'] .= "; " . substr ( $value_aff, 2 );
									break;
								case "^2" :
									$affiliation ['affiliation'] .= "; " . substr ( $value_aff, 2 );
									break;
								case "^3" :
									$affiliation ['affiliation'] .= "; " . substr ( $value_aff, 2 );
									break;
								case "^4" :
									$affiliation ['affiliation'] .= "; " . substr ( $value_aff, 2 );
									break;
							}
						}
						// Grava dados da afiliação no banco de dados; recupera $id
						if (isset ( $affiliation ['code'] ))
							$affiliation ['code'] = trim ( $affiliation ['code'] );
						$affiliation = $this->iso2utf8 ( $affiliation );
						$id_gerado = $this->banco->inserir ( 'affiliation', $affiliation );
						if (isset ( $line ['ids_affiliation'] ))
							$line ['ids_affiliation'] .= "-" . $id_gerado;
						else
							$line ['ids_affiliation'] = $id_gerado;
						break;
					case "!v085!" :
						if (strpos ( $vetor, "^l" ))
							$line ['' . $this->ajustarLocale ( trim ( substr ( $vetor, strpos ( $vetor, "^l" ) + 2, 2 ) ) )] [] = trim ( substr ( substr ( $vetor, strpos ( $vetor, "^k" ) + 2 ), 0, - 4 ) );
						break;
					case "!v237!" :
						$doi [237] = trim ( substr ( $vetor, 6 ) );
						break;
					case "!v880!" :
						$doi [880] = trim ( substr ( $vetor, 6 ) );
						break;
					case "!v881!" :
						$doi [881] = trim ( substr ( $vetor, 6 ) );
						break;
					case "!v891!" :
						$doi [891] = trim ( substr ( $vetor, 6 ) );
						break;
					
					default :
						$line [substr ( $vetor, 0, 6 )] = substr ( $vetor, 6 );
						break;
				}
			}
			if (isset ( $doi [237] ))
				$line ['doi'] = trim ( $doi [237] );
			else if (isset ( $doi [881] ))
				$line ['doi'] = '10.1590/' . trim ( $doi [881] );
			else if (isset ( $doi [891] ))
				$line ['doi'] = '10.1590/' . trim ( $doi [891] );
			else if (isset ( $doi [880] ))
				$line ['doi'] = '10.1590/' . trim ( $doi [880] );
			
			if (! isset ( $affiliation ) && isset ( $line ['ids_authors'] )) {
				$affiliation ['code'] = 'A01';
				$affiliation ['affiliation'] = "Cadastrado sem afilo no Scielo";
				$id_gerado = $this->banco->inserir ( 'affiliation', $affiliation );
				$line ['ids_affiliation'] = $id_gerado;
			}
			$gravados [] = $this->record_db ( $line, $fonte );
		}
		foreach ( $gravados as $teste ) {
			if ($teste)
				++ $importados;
			else
				++ $nao_importados;
		}
		$this->apagarRevista ( '' );
		return array (
				$importados,
				$nao_importados - 1 
		);
	}
	public function record_db($line, $fonte) {
		$issue = array ();
		$pages = array ();
		$issue = array ();
		unset ( $mes );
		unset ( $day );
		// echo "<pre>";
		// print_r($line);
		if (isset ( $line ['title_article_pt_br'] ))
			$issue ['title_article_pt_br'] = trim ( $line ['title_article_pt_br'] );
		if (isset ( $line ['title_article_es'] ))
			$issue ['title_article_es'] = trim ( $line ['title_article_es'] );
		if (isset ( $line ['title_article_en'] ))
			$issue ['title_article_en'] = trim ( $line ['title_article_en'] );
		if (isset ( $line ['title_article_fr'] ))
			$issue ['title_article_fr'] = trim ( $line ['title_article_fr'] );
		if (isset ( $line ['title_article_de'] ))
			$issue ['title_article_de'] = trim ( $line ['title_article_de'] );
		if (isset ( $line ['title_article_it'] ))
			$issue ['title_article_it'] = trim ( $line ['title_article_it'] );
		if (isset ( $line ['abstract_pt_br'] ))
			$issue ['abstract_pt_br'] = trim ( $line ['abstract_pt_br'] );
		if (isset ( $line ['abstract_es'] ))
			$issue ['abstract_es'] = trim ( $line ['abstract_es'] );
		if (isset ( $line ['abstract_en'] ))
			$issue ['abstract_en'] = trim ( $line ['abstract_en'] );
		if (isset ( $line ['abstract_fr'] ))
			$issue ['abstract_fr'] = trim ( $line ['abstract_fr'] );
		if (isset ( $line ['abstract_de'] ))
			$issue ['abstract_de'] = trim ( $line ['abstract_de'] );
		if (isset ( $line ['abstract_it'] ))
			$issue ['abstract_it'] = trim ( $line ['abstract_it'] );
			// Manobra burra
		if (isset ( $line ['title_section_pt_br'] ))
			$issue ['title_section_pt_br'] = utf8_decode ( trim ( $line ['title_section_pt_br'] ) );
		if (isset ( $line ['title_section_es'] ))
			$issue ['title_section_es'] = utf8_decode ( trim ( $line ['title_section_es'] ) );
		if (isset ( $line ['title_section_en'] ))
			$issue ['title_section_en'] = utf8_decode ( trim ( $line ['title_section_en'] ) );
		if (isset ( $line ['title_section_fr'] ))
			$issue ['title_section_fr'] = utf8_decode ( trim ( $line ['title_section_fr'] ) );
		if (isset ( $line ['title_section_de'] ))
			$issue ['title_section_de'] = utf8_decode ( trim ( $line ['title_section_de'] ) );
		if (isset ( $line ['code_section_scielo'] ))
			$issue ['code_section_scielo'] = trim ( $line ['code_section_scielo'] );
		if (isset ( $line ["!v030!"] ))
			$issue ['nome_revista'] = $line ["!v030!"];
		if (isset ( $line ["!v031!"] ))
			$issue ['volume'] = trim ( $line ['!v031!'] );
		if (isset ( $line ["!v032!"] ))
			$issue ['numero'] = trim ( $line ['!v032!'] );
		if (isset ( $line ['doi'] ))
			$issue ['doi'] = trim ( $line ['doi'] );
			// indexing
		if (isset ( $line ['indexing_pt_br'] ))
			$issue ['indexing_pt_br'] = implode ( ';', $line ['indexing_pt_br'] );
		if (isset ( $line ['indexing_es'] ))
			$issue ['indexing_es'] = implode ( ';', $line ['indexing_es'] );
		if (isset ( $line ['indexing_en'] ))
			$issue ['indexing_en'] = implode ( ';', $line ['indexing_en'] );
		if (isset ( $line ['indexing_fr'] ))
			$issue ['indexing_fr'] = implode ( ';', $line ['indexing_fr'] );
		if (isset ( $line ['indexing_de'] ))
			$issue ['indexing_de'] = implode ( ';', $line ['indexing_de'] );
		if (isset ( $line ['indexing_it'] ))
			$issue ['indexing_it'] = implode ( ';', $line ['indexing_it'] );
			// verificar com josi: v111-v112-v113-v114-v065
		if (isset ( $line ['!v065!'] )) {
			$issue ['year'] = substr ( $line ['!v065!'], 0, 4 );
			$year = substr ( $line ['!v065!'], 0, 4 );
			if (substr ( $line ['!v065!'], 4, 2 ) == "00")
				$mes = "01";
			else
				$mes = substr ( $line ['!v065!'], 4, 2 );
			if (substr ( $line ['!v065!'], 6, 2 ) == "00")
				$day = "01";
			else
				$day = substr ( $line ['!v065!'], 6, 2 );
			$issue ['date_published_article'] = $year . "-" . $mes . "-" . $day;
			$issue ['date_published_issue'] = $year . "-" . $mes . "-" . $day;
		}
		if (isset ( $line ['!v040!'] ))
			$issue ['article_language'] = trim ( $line ['!v040!'] );
		if (isset ( $line ['!v121!'] ))
			$issue ['ordem_no_issue'] = trim ( $line ['!v121!'] );
		if (isset ( $line ['!v014!'] )) {
			$pages = explode ( "^", $line ['!v014!'] );
			$page1 = intval ( trim ( substr ( $pages [1], 1 ) ) );
			$page2 = intval ( trim ( substr ( $pages [2], 1 ) ) );
			if ($page1 > 0 && $page2 > 0) {
				$issue ['pages'] = min ( $page1, $page2 ) . "-" . max ( $page1, $page2 );
			} else
				$issue ['pages'] = trim ( substr ( $pages [1], 1 ) ) . "-" . trim ( substr ( $pages [2], 1 ) );
		}
		if (isset ( $line ['!v702!'] )) {
			$auxiliar = array ();
			$auxiliar = explode ( "\\", $line ['!v702!'] );
			if (sizeof ( $auxiliar ) > 3) {
				unset ( $auxiliar [0] );
				unset ( $auxiliar [1] );
				unset ( $auxiliar [2] );
			}
			$issue ['url_pdf'] = implode ( "/", $auxiliar );
			$issue ['url_pdf'] = str_replace ( 'xml', 'pdf', str_replace ( '/markup', '', str_replace ( 'htm', 'pdf', str_replace ( 'html', 'pdf', $issue ['url_pdf'] ) ) ) );
			$issue ['url_pdf'] = $fonte . trim ( $issue ['url_pdf'] );
		}
		// Pega o ISSN da revista
		if (isset ( $line ["!v936!"] )) {
			$tag_issn = $line ['!v936!'];
			$tag_issn = explode ( "___", str_replace ( '^', '___^', $tag_issn ) );
			foreach ( $tag_issn as $issn ) {
				switch (substr ( $issn, 0, 2 )) {
					case "^i" :
						$issue ['issn'] = trim ( substr ( $issn, 2 ) );
						break;
				}
			}
		}
		if (isset ( $line ['ids_affiliation'] ))
			$issue ['ids_affiliation'] = $line ['ids_affiliation'];
		if (isset ( $line ['ids_authors'] ))
			$issue ['ids_authors'] = $line ['ids_authors'];
			// Manda tudo para o banco de dados
		if (! empty ( $issue )) {
			if (! isset ( $issue ['title_article_pt_br'] ))
				$issue ['title_article_pt_br'] = "TITULO NULO"; // Psico USP não tem nome no editorial...
			if (! isset ( $issue ['title_article_en'] ))
				$issue ['title_article_en'] = "TITULO NULO"; // Psico USP não tem nome no editorial...
			$issue = $this->iso2utf8 ( $issue );
			return $this->banco->inserir ( 'issue', $issue );
		}
	}
	// Converte para utf8 @!!abstract_
	function iso2utf8($vetor_iso) {
		foreach ( $vetor_iso as $key => $iso88591 ) {
			// aproveitar para substituir caracteres problemáticos no XML
			$iso88591 = str_replace ( "&", "&amp;", $iso88591 );
			$iso88591 = str_replace ( "<", "&lt;", $iso88591 );
			$iso88591 = str_replace ( ">", "&gt;;", $iso88591 );
			$iso88591 = str_replace ( "\"", "&quot;", $iso88591 );
			$iso88591 = str_replace ( "'", "&apos;", $iso88591 );
			$utf8 [$key] = $iso88591;
		}
		return $utf8;
	}
	// busca nome e locale da seção
	public function dataSection($code) {
		$onde = " code = '$code' ";
		return $this->banco->listar ( 'sections', 'name, locale', "$onde" );
	}
	public function apagarRevista($issn) {
		$where = "issn = '$issn' or issn is null or issn = ''";
		$this->banco->apagar ( 'issue', $where );
	}
	function ajustarLocale($input) {
		$retorno = 'pt_br';
		switch ($input) {
			case 'pt' :
				$retorno = 'pt_br';
				break;
			case "es" :
				$retorno = 'es';
				break;
			case "en" :
				$retorno = 'en';
				break;
			case "fr" :
				$retorno = 'fr';
				break;
			case "de" :
				$retorno = 'de';
				break;
			case "it" :
				$retorno = 'it';
				break;
		}
		return $retorno;
	}
	function removerTodasTagsLilacs(&$string) {
		$string = preg_replace ( '/\^l.*/', '', $string );
	}
}