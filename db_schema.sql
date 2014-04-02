/* A importação será das mais novas para as mais antigas 

*/

CREATE TABLE IF NOT EXISTS affiliation (
	id_affiliation INTEGER NOT NULL AUTO_INCREMENT,
	code VARCHAR(30),
  affiliation VARCHAR(65534) DEFAULT NULL,  
	country VARCHAR(30), 
	email VARCHAR(60000),
	PRIMARY KEY(id_affiliation)
)
TYPE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE IF NOT EXISTS authors (
	id_author INTEGER NOT NULL AUTO_INCREMENT,
	firstname VARCHAR(2000), 
	middlename VARCHAR(2000) DEFAULT NULL,
	lastname VARCHAR(2000),
  affiliation TEXT DEFAULT NULL,  
	PRIMARY KEY(id_author)
)
TYPE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE IF NOT EXISTS sections (
	code VARCHAR(30), 
	locale VARCHAR(100), 
	name VARCHAR(255)
)
TYPE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE IF NOT EXISTS issue (
	id_issue INTEGER NOT NULL AUTO_INCREMENT,
	issn VARCHAR(90),
	nome_revista VARCHAR(1000),
  volume VARCHAR(600), 
	numero VARCHAR(600),
	year VARCHAR(600),
	date_published_issue DATE,
	code_section_scielo TEXT, 
	title_section_pt_br TEXT DEFAULT NULL,
	title_section_es TEXT DEFAULT NULL,
	title_section_en TEXT DEFAULT NULL,
	title_section_fr TEXT DEFAULT NULL,
	title_section_de TEXT DEFAULT NULL,
	title_section_it TEXT DEFAULT NULL,
	article_language TEXT,
	doi TEXT,
	ordem_no_issue INTEGER,  
	title_article_pt_br TEXT DEFAULT NULL,
	title_article_es TEXT DEFAULT NULL,
	title_article_en TEXT DEFAULT NULL,
	title_article_fr TEXT DEFAULT NULL,
	title_article_de TEXT DEFAULT NULL,	
	title_article_it TEXT DEFAULT NULL,	
	abstract_pt_br TEXT DEFAULT NULL,   
	abstract_es TEXT DEFAULT NULL,
	abstract_en TEXT DEFAULT NULL,	
	abstract_fr TEXT DEFAULT NULL,
	abstract_de TEXT DEFAULT NULL,
	abstract_it TEXT DEFAULT NULL,
	indexing_pt_br TEXT DEFAULT NULL,   
	indexing_es TEXT DEFAULT NULL,
	indexing_en TEXT DEFAULT NULL,	
	indexing_fr TEXT DEFAULT NULL,
	indexing_de TEXT DEFAULT NULL,
	indexing_it TEXT DEFAULT NULL,
	ids_affiliation TEXT DEFAULT NULL,
	ids_authors TEXT DEFAULT NULL,
	pages TEXT DEFAULT NULL,
	date_published_article DATE,
	url_pdf TEXT DEFAULT NULL,
	PRIMARY KEY(id_issue)
)
TYPE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE IF NOT EXISTS users (
	codpes INTEGER NOT NULL,
	nome VARCHAR(50),
	password VARCHAR(60),
	email VARCHAR(60),
	permission INTEGER DEFAULT 0,
	created_at DATETIME,
	updated_at DATETIME
)
TYPE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

INSERT INTO users(codpes,nome,password,email,permission) VALUES ('123456','admin','[MEU_HASH_MD5_AQUI]','admin@domain.com',1);
