<?php
header ( "Content-type: text/html;charset=utf-8" );
class Xmlojs {
	private $banco;
	public function __construct() {
		$this->banco = Banco::instanciar ();
	}
	// recebe o nome do arquivo e caminho no server $campos='*',$where=null, $order=null, $limite=null)
	public function montaXml($issn, $caminho) {
		// zera variáveis
		unset ( $num_vol_ano );
		unset ( $todos_num_vol_ano );
		unset ( $num_vol_ano_data );
		
		// Traz tudo do banco baseado no issn
		$where = " issn = '$issn' ";
		$order = " year ASC, date_published_issue ASC, ordem_no_issue ASC ";
		$tudo = $this->banco->listar ( 'issue', '*', $where, $order );
		
		// Abre arquivo
		$file_nome = "issn_" . time () . ".xml";
		$file = $caminho . $file_nome;
		$ponteiro = fopen ( $file, "w" );
		fwrite ( $ponteiro, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" );
		fwrite ( $ponteiro, "<!DOCTYPE issue PUBLIC \"-//PKP//OJS Articles and Issues XML//EN\" \"http://pkp.sfu.ca/ojs/dtds/native.dtd\"> \n" );
		fwrite ( $ponteiro, "<issues>" );
		// Lê todos num_vol_ano do banco
		foreach ( $tudo as $dados ) {
			if (isset ( $todos_num_vol_ano )) {
				$verify = trim ( $dados ['numero'] ) . trim ( $dados ['volume'] ) . trim ( $dados ['year'] );
				if (! (in_array ( $verify, $todos_num_vol_ano ))) {
					$todos_num_vol_ano [] = trim ( $dados ['numero'] ) . trim ( $dados ['volume'] ) . trim ( $dados ['year'] );
					$num_vol_ano_data [$verify] = array (
							$dados ['numero'],
							$dados ['volume'],
							$dados ['year'],
							$dados ['date_published_issue'] 
					);
				}
			} else {
				$verify = trim ( $dados ['numero'] ) . trim ( $dados ['volume'] ) . trim ( $dados ['year'] );
				$todos_num_vol_ano [] = trim ( $dados ['numero'] ) . trim ( $dados ['volume'] ) . trim ( $dados ['year'] );
				$num_vol_ano_data [$verify] = array (
						$dados ['numero'],
						$dados ['volume'],
						$dados ['year'],
						$dados ['date_published_issue'] 
				);
			}
		}
		
		foreach ( $todos_num_vol_ano as $num_vol_ano ) {
			$section_atual = array ();
			// cabeçalho do issue
			fwrite ( $ponteiro, "\n<issue identification=\"num_vol_year\" published=\"true\" current=\"false\"> \n" );
			fwrite ( $ponteiro, "<volume>{$num_vol_ano_data[$num_vol_ano][1]}</volume>\n" );
			fwrite ( $ponteiro, "<number>{$num_vol_ano_data[$num_vol_ano][0]}</number>\n" );
			fwrite ( $ponteiro, "<year>{$num_vol_ano_data[$num_vol_ano][2]}</year>\n" );
			fwrite ( $ponteiro, "<date_published>{$num_vol_ano_data[$num_vol_ano][3]}</date_published>\n " );
			fwrite ( $ponteiro, "<open_access/>\n" );
			
			foreach ( $tudo as $doc ) {
				// zerando variáveis desse documento
				unset ( $ids_authors );
				$ids_authors = array ();
				unset ( $ids_affiliation );
				$ids_affiliation = array ();
				unset ( $affiliation );
				$mail = array ();
				
				$this_num_vol_ano = trim ( $doc ['numero'] ) . trim ( $doc ['volume'] ) . trim ( $doc ['year'] );
				// monta o Issue
				if ($this_num_vol_ano == $num_vol_ano) {
					// cambalaxo loko
					if (! isset ( $doc ['code_section_scielo'] ))
						$doc ['code_section_scielo'] = 'x';
					if (! isset ( $doc ['code_section_scielo'] ))
						$doc ['code_section_scielo'] = 'x';
					if (! isset ( $doc ['code_section_scielo'] ))
						$doc ['code_section_scielo'] = 'x';
					if (! isset ( $doc ['code_section_scielo'] ))
						$doc ['code_section_scielo'] = 'x';
					if (! isset ( $doc ['code_section_scielo'] ))
						$doc ['code_section_scielo'] = 'x';
					
					if (! isset ( $section_atual ['code_section_scielo'] ))
						$section_atual ['code_section_scielo'] = 'y';
					if (! isset ( $section_atual ['code_section_scielo'] ))
						$section_atual ['code_section_scielo'] = 'y';
					if (! isset ( $section_atual ['code_section_scielo'] ))
						$section_atual ['code_section_scielo'] = 'y';
					if (! isset ( $section_atual ['code_section_scielo'] ))
						$section_atual ['code_section_scielo'] = 'y';
					if (! isset ( $section_atual ['code_section_scielo'] ))
						$section_atual ['code_section_scielo'] = 'y';
						// coloca todos artigos em cada seção
					if ((! isset ( $section_atual ['code_section_scielo'] ) && ! isset ( $section_atual ['code_section_scielo'] ) && ! isset ( $section_atual ['code_section_scielo'] ) && ! isset ( $section_atual ['code_section_scielo'] ) && ! isset ( $section_atual ['code_section_scielo'] )) || ((trim ( $section_atual ['code_section_scielo'] ) != trim ( $doc ['code_section_scielo'] )) && (trim ( $section_atual ['code_section_scielo'] ) != trim ( $doc ['code_section_scielo'] )) && (trim ( $section_atual ['code_section_scielo'] ) != trim ( $doc ['code_section_scielo'] )) && (trim ( $section_atual ['code_section_scielo'] ) != trim ( $doc ['code_section_scielo'] )) && (trim ( $section_atual ['code_section_scielo'] ) != trim ( $doc ['code_section_scielo'] )))) {
						// desfaz o cabalaxo loko
						if ($doc ['code_section_scielo'] == 'x')
							unset ( $doc ['code_section_scielo'] );
						if ($doc ['code_section_scielo'] == 'x')
							unset ( $doc ['code_section_scielo'] );
						if ($doc ['code_section_scielo'] == 'x')
							unset ( $doc ['code_section_scielo'] );
						if ($doc ['code_section_scielo'] == 'x')
							unset ( $doc ['code_section_scielo'] );
						if ($doc ['code_section_scielo'] == 'x')
							unset ( $doc ['code_section_scielo'] );
						
						if ($section_atual ['code_section_scielo'] == 'y')
							unset ( $section_atual ['code_section_scielo'] );
						if ($section_atual ['code_section_scielo'] == 'y')
							unset ( $section_atual ['code_section_scielo'] );
						if ($section_atual ['code_section_scielo'] == 'y')
							unset ( $section_atual ['code_section_scielo'] );
						if ($section_atual ['code_section_scielo'] == 'y')
							unset ( $section_atual ['code_section_scielo'] );
						if ($section_atual ['code_section_scielo'] == 'y')
							unset ( $section_atual ['code_section_scielo'] );
							
							// se tiver uma seção definida anteriormente, fecha seção!
						if (isset ( $section_atual ['code_section_scielo'] ) || isset ( $section_atual ['code_section_scielo'] ) || isset ( $section_atual ['code_section_scielo'] ) || isset ( $section_atual ['code_section_scielo'] ) || isset ( $section_atual ['code_section_scielo'] ))
							fwrite ( $ponteiro, "</section>\n" );
						
						if (isset ( $doc ['code_section_scielo'] ))
							$section_atual ['code_section_scielo'] = $doc ['code_section_scielo'];
						if (isset ( $doc ['code_section_scielo'] ))
							$section_atual ['code_section_scielo'] = $doc ['code_section_scielo'];
						if (isset ( $doc ['code_section_scielo'] ))
							$section_atual ['code_section_scielo'] = $doc ['code_section_scielo'];
						if (isset ( $doc ['code_section_scielo'] ))
							$section_atual ['code_section_scielo'] = $doc ['code_section_scielo'];
						if (isset ( $doc ['code_section_scielo'] ))
							$section_atual ['code_section_scielo'] = $doc ['code_section_scielo'];
						
						fwrite ( $ponteiro, "<section>\n" );
						if (isset ( $doc ['code_section_scielo'] ))
							fwrite ( $ponteiro, "<title locale=\"pt_BR\">{$doc['code_section_scielo']}</title>\n" );
						if (isset ( $doc ['code_section_scielo'] ))
							fwrite ( $ponteiro, "<title locale=\"es_ES\">{$doc['code_section_scielo']}</title>\n" );
						if (isset ( $doc ['code_section_scielo'] ))
							fwrite ( $ponteiro, "<title locale=\"en_US\">{$doc['code_section_scielo']}</title>\n" );
						if (isset ( $doc ['code_section_scielo'] ))
							fwrite ( $ponteiro, "<title locale=\"fr_CA\">{$doc['code_section_scielo']}</title>\n" );
						if (isset ( $doc ['code_section_scielo'] ))
							fwrite ( $ponteiro, "<title locale=\"de_DE\">{$doc['code_section_scielo']}</title>\n" );
						$this->montaDoc ( $doc, $ponteiro, $num_vol_ano_data, $num_vol_ano );
					} else
						$this->montaDoc ( $doc, $ponteiro, $num_vol_ano_data, $num_vol_ano );
				}
			}
			fwrite ( $ponteiro, "</section>\n" );
			fwrite ( $ponteiro, "</issue>\n" );
		}
		
		fwrite ( $ponteiro, "</issues>\n" );
		fclose ( $ponteiro );
		return $file_nome;
	}
	public function montaDoc($doc, $ponteiro, $num_vol_ano_data, $num_vol_ano) {
		// Linguagem do documento
		if (isset ( $doc ['article_language'] ))
			fwrite ( $ponteiro, "<article language=\"{$doc['article_language']}\"> \n" );
			// Doi da Scielo
		if (isset ( $doc ['doi'] ))
			fwrite ( $ponteiro, "<id type=\"doi\"> {$doc['doi']} </id> \n" );
			// Título do documento em várias línguas
		if (isset ( $doc ['ordem_no_issue'] ))
			fwrite ( $ponteiro, "<!--ordem no issue: {$doc['ordem_no_issue']} --> \n" );
		if (isset ( $doc ['title_article_pt_br'] ))
			fwrite ( $ponteiro, "<title locale=\"pt_BR\"> {$doc['title_article_pt_br']} </title>\n" );
		if (isset ( $doc ['title_article_es'] ))
			fwrite ( $ponteiro, "<title locale=\"es_ES\"> {$doc['title_article_es']} </title>\n" );
		if (isset ( $doc ['title_article_en'] ))
			fwrite ( $ponteiro, "<title locale=\"en_US\"> {$doc['title_article_en']} </title>\n" );
		if (isset ( $doc ['title_article_fr'] ))
			fwrite ( $ponteiro, "<title locale=\"fr_CA\"> {$doc['title_article_fr']} </title>\n" );
		if (isset ( $doc ['title_article_de'] ))
			fwrite ( $ponteiro, "<title locale=\"de_DE\"> {$doc['title_article_de']} </title>\n" );
		if (isset ( $doc ['title_article_it'] ))
			fwrite ( $ponteiro, "<title locale=\"it_IT\"> {$doc['title_article_it']} </title>\n" );
			// Resumos em várias línguas
		if (isset ( $doc ['abstract_pt_br'] ))
			fwrite ( $ponteiro, "<abstract locale=\"pt_BR\"> {$doc['abstract_pt_br']} </abstract>\n" );
		if (isset ( $doc ['abstract_es'] ))
			fwrite ( $ponteiro, "<abstract locale=\"es_ES\"> {$doc['abstract_es']} </abstract>\n" );
		if (isset ( $doc ['abstract_en'] ))
			fwrite ( $ponteiro, "<abstract locale=\"en_US\"> {$doc['abstract_en']} </abstract>\n" );
		if (isset ( $doc ['abstract_fr'] ))
			fwrite ( $ponteiro, "<abstract locale=\"fr_CA\"> {$doc['abstract_fr']} </abstract>\n" );
		if (isset ( $doc ['abstract_de'] ))
			fwrite ( $ponteiro, "<abstract locale=\"de_DE\"> {$doc['abstract_de']} </abstract>\n" );
		if (isset ( $doc ['abstract_it'] ))
			fwrite ( $ponteiro, "<abstract locale=\"it_IT\"> {$doc['abstract_it']} </abstract>\n" );
		if (isset ( $doc ['ids_authors'] ))
			$ids_authors = explode ( '-', $doc ['ids_authors'] );
		if (isset ( $doc ['ids_affiliation'] ))
			$ids_affiliation = explode ( '-', $doc ['ids_affiliation'] );
			
			// indexing
		fwrite ( $ponteiro, "<indexing>\n" );
		if (isset ( $doc ['indexing_pt_br'] ))
			fwrite ( $ponteiro, "<subject locale=\"pt_BR\"> {$doc['indexing_pt_br']} </subject>\n" );
		if (isset ( $doc ['indexing_es'] ))
			fwrite ( $ponteiro, "<subject locale=\"es_ES\"> {$doc['indexing_es']} </subject>\n" );
		if (isset ( $doc ['indexing_en'] ))
			fwrite ( $ponteiro, "<subject locale=\"en_US\"> {$doc['indexing_en']} </subject>\n" );
		if (isset ( $doc ['indexing_fr'] ))
			fwrite ( $ponteiro, "<subject locale=\"fr_CA\"> {$doc['indexing_fr']} </subject>\n" );
		if (isset ( $doc ['indexing_de'] ))
			fwrite ( $ponteiro, "<subject locale=\"de_DE\"> {$doc['indexing_de']} </subject>\n" );
		if (isset ( $doc ['indexing_it'] ))
			fwrite ( $ponteiro, "<subject locale=\"it_IT\"> {$doc['indexing_it']} </subject>\n" );
		fwrite ( $ponteiro, "</indexing>\n" );
		
		// autor e afiliação
		if (isset ( $ids_authors ) && isset ( $ids_affiliation )) {
			// pega dados de afiliação, pais e email
			foreach ( $ids_affiliation as $id_affiliation ) {
				$where = " id_affiliation = '$id_affiliation' ";
				$affiliations = $this->banco->listar ( 'affiliation', '*', $where );
				// monta vetor de uma posição com a string xml, o índice é o código scielo A01 etc...
				if (isset ( $affiliations [0] ['code'] )) {
					if (isset ( $affiliations [0] ['affiliation'] ))
						$affiliation [$affiliations [0] ['code']] = " <affiliation>{$affiliations[0]['affiliation']}</affiliation> \n";
					if (isset ( $affiliations [0] ['country'] ))
						$affiliation [$affiliations [0] ['code']] .= "<country>{$affiliations[0]['country']}</country> \n";
					if (isset ( $affiliations [0] ['email'] ))
						$mail [$affiliations [0] ['code']] = "<email>{$affiliations[0]['email']}</email> \n";
				}
			}
			// inseri todos autores
			foreach ( $ids_authors as $id_author ) {
				$where = " id_author = '$id_author' ";
				$authors = $this->banco->listar ( 'authors', '*', $where );
				fwrite ( $ponteiro, "<author>\n" );
				if (isset ( $authors [0] ['firstname'] ))
					fwrite ( $ponteiro, "<firstname>{$authors[0]['firstname']}</firstname>\n" );
				if (isset ( $authors [0] ['middlename'] ))
					fwrite ( $ponteiro, "<middlename>{$authors[0]['middlename']}</middlename>\n" );
				if (isset ( $authors [0] ['lastname'] ))
					fwrite ( $ponteiro, "<lastname>{$authors[0]['lastname']}</lastname>\n" );
				if (isset ( $authors [0] ['affiliation'] )) {
					$codigos_afiliacoes = explode ( ' ', $authors [0] ['affiliation'] );
					foreach ( $codigos_afiliacoes as $values ) {
						fwrite ( $ponteiro, $affiliation [$values] );
					}
					if (isset ( $mail [$codigos_afiliacoes [0]] ))
						fwrite ( $ponteiro, "{$mail[$codigos_afiliacoes[0]]}" );
					else
						fwrite ( $ponteiro, "<email>padrao@usp.br</email>\n" );
				}
				fwrite ( $ponteiro, "</author>\n" );
			}
		}
		if (isset ( $doc ['pages'] ))
			fwrite ( $ponteiro, "<pages> {$doc['pages']} </pages>\n" );
		fwrite ( $ponteiro, "<date_published> {$num_vol_ano_data[$num_vol_ano][3]} </date_published>\n " );
		
		// PDF em Gallery <href src="mygalley.pdf" mime_type="application/pdf"/>
		unset ( $galley );
		if (isset ( $doc ['article_language'] )) {
			if (trim ( $doc ['article_language'] ) == 'en')
				$galley = "<galley locale=\"en_US\">";
			if (trim ( $doc ['article_language'] ) == 'pt')
				$galley = "<galley locale=\"pt_BR\">";
			if (trim ( $doc ['article_language'] ) == 'es')
				$galley = "<galley locale=\"es_ES\">";
			if (trim ( $doc ['article_language'] ) == 'fr')
				$galley = "<galley locale=\"fr_CA\">";
			if (trim ( $doc ['article_language'] ) == 'de')
				$galley = "<galley locale=\"de_DE\">";
			if (trim ( $doc ['article_language'] ) == 'it')
				$galley = "<galley locale=\"it_IT\">";
		} else
			$galley = "<galley>";
		fwrite ( $ponteiro, "$galley \n <label> PDF </label> \n 	
				<file>  <href src=\"{$doc['url_pdf']}\" mime_type=\"application/pdf\"/> </file> \n </galley>\n" );
		
		unset ( $url_pt );
		unset ( $url_es );
		unset ( $url_en );
		unset ( $url_fr );
		unset ( $url_de );
		unset ( $header_response );
		
		$url_pt = substr ( $doc ['url_pdf'], 0, strrpos ( $doc ['url_pdf'], "/" ) ) . '/pt_' . substr ( $doc ['url_pdf'], strrpos ( $doc ['url_pdf'], "/" ) + 1 );
		$header_response = get_headers ( $url_pt, 1 );
		if (strpos ( $header_response [0], "404" ) === false) {
			fwrite ( $ponteiro, "<galley locale=\"pt_BR\">\n <label>PDF</label> \n 
					<file>  <href src=\"$url_pt\" mime_type=\"application/pdf\"/> </file> \n </galley>\n" );
			unset ( $header_response );
		}
		$url_es = substr ( $doc ['url_pdf'], 0, strrpos ( $doc ['url_pdf'], "/" ) ) . '/es_' . substr ( $doc ['url_pdf'], strrpos ( $doc ['url_pdf'], "/" ) + 1 );
		$header_response = get_headers ( $url_es, 1 );
		if (strpos ( $header_response [0], "404" ) === false) {
			fwrite ( $ponteiro, "<galley locale=\"es_ES\">\n <label>PDF</label> \n 
					<file>  <href src=\"$url_es\" mime_type=\"application/pdf\"/> </file> \n </galley>\n" );
			unset ( $header_response );
		}
		$url_en = substr ( $doc ['url_pdf'], 0, strrpos ( $doc ['url_pdf'], "/" ) ) . '/en_' . substr ( $doc ['url_pdf'], strrpos ( $doc ['url_pdf'], "/" ) + 1 );
		$header_response = get_headers ( $url_en, 1 );
		if (strpos ( $header_response [0], "404" ) === false) {
			fwrite ( $ponteiro, "<galley locale=\"en_US\">\n <label>PDF</label> \n 
					<file>  <href src=\"$url_en\" mime_type=\"application/pdf\"/> </file> \n </galley>\n" );
			unset ( $header_response );
		}
		
		$url_fr = substr ( $doc ['url_pdf'], 0, strrpos ( $doc ['url_pdf'], "/" ) ) . '/fr_' . substr ( $doc ['url_pdf'], strrpos ( $doc ['url_pdf'], "/" ) + 1 );
		$header_response = get_headers ( $url_fr, 1 );
		if (strpos ( $header_response [0], "404" ) === false) {
			fwrite ( $ponteiro, "<galley locale=\"fr_CA\">\n <label>PDF</label> \n 
					<file>  <href src=\"$url_fr\" mime_type=\"application/pdf\"/> </file> \n </galley>\n" );
			unset ( $header_response );
		}
		
		$url_de = substr ( $doc ['url_pdf'], 0, strrpos ( $doc ['url_pdf'], "/" ) ) . '/de_' . substr ( $doc ['url_pdf'], strrpos ( $doc ['url_pdf'], "/" ) + 1 );
		$header_response = get_headers ( $url_de, 1 );
		if (strpos ( $header_response [0], "404" ) === false) {
			fwrite ( $ponteiro, "<galley locale=\"de_DE\">\n <label>PDF</label> \n 
					<file>  <href src=\"$url_de\" mime_type=\"application/pdf\"/> </file> \n </galley>\n" );
			unset ( $header_response );
		}
		
		$url_it = substr ( $doc ['url_pdf'], 0, strrpos ( $doc ['url_pdf'], "/" ) ) . '/it_' . substr ( $doc ['url_pdf'], strrpos ( $doc ['url_pdf'], "/" ) + 1 );
		$header_response = get_headers ( $url_de, 1 );
		if (strpos ( $header_response [0], "404" ) === false) {
			fwrite ( $ponteiro, "<galley locale=\"it_IT\">\n <label>PDF</label> \n 
					<file>  <href src=\"$url_de\" mime_type=\"application/pdf\"/> </file> \n </galley>\n" );
			unset ( $header_response );
		}
		
		fwrite ( $ponteiro, "</article>\n" );
	}
	public function listarISSN() {
		return $this->banco->listar ( 'issue', ' distinct issn,nome_revista' );
	}
}

//include('../config.php');
//$obj = new Xmlojs;
//$caminho = "/code/git/serradas/dados/saidas/";
//$issn = "0104-1169"; 
//$issn = "0103-6564"; 
//$obj->montaXml($issn,$caminho);




