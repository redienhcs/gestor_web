<?php

require_once './classes/Noticia.php';

class BusNoticia {
    private static $imagesSizes = array( array('fileId'=>'noticia', 'width'=>800, 'height'=>600),
                                        array('fileId'=>'noticia1', 'width'=>127, 'height'=>107)
                                        );
    
    public function alter( $noticia) {
        
        $retorno = false;
	$errosEncontrados = $this->verificarInformacoes( $noticia);
	
	if( !$errosEncontrados ) {
	    
	    $dadosAlteracao = array();
	    
	    $mysql = Mysql::getInstance();
            
	    $dadosAlteracao['noti_titulo']           =   $noticia->getTitulo();
	    $dadosAlteracao['noti_data']             = DateClass::convert( $noticia->getDataNoticia(), '%d/%m/%Y', '%Y/%m/%d');
	    $dadosAlteracao['noti_conteudo']         =   $noticia->getConteudo();
	    $dadosAlteracao['noti_autor']            =   $noticia->getAutor();
            
	    if ( $mysql->update(self::$tableName, $dadosAlteracao , "noti_codigo = '{$noticia->getCodigoNoticia()}' " ) ) {
		$retorno = true;
	    } else {
                $retorno = false;
	    }
	} else {
	    require_once( 'forms/frm_noticia.php' );
	}
        
        return $retorno;
    }

    public function insert( $noticia) {
        $retorno = false;
	$errosEncontrados = $this->verificarInformacoes( $noticia);
        
	if ( !$errosEncontrados) {
	    
	    $mysql = Mysql::getInstance();

	    $dadosInsercao = array();

	    $dadosInsercao['noti_titulo']           =   $noticia->getTitulo();
	    $dadosInsercao['noti_data_insercao']    =   'NOW()';
	    $dadosInsercao['noti_data']             =   DateClass::convert( $noticia->getDataNoticia(), '%d/%m/%Y', '%Y/%m/%d');
	    $dadosInsercao['noti_conteudo']         =   $noticia->getConteudo();
	    $dadosInsercao['noti_autor']            =   $noticia->getAutor();
	    
	    if ( $mysql->insert( self::$tableName, $dadosInsercao)) {
                $retorno = true;
	    } else {
                $retorno = false;
	    }
	}
        
        return $retorno;
    }

    public function delete( $noticia) {
        
        $retorno = false;

	$mysql = Mysql::getInstance();
        
        $sql = 'DELETE FROM '.self::$tableName.' WHERE noti_codigo = \''.$noticia->getCodigoNoticia().'\'';
        
        if ($mysql->execute($sql)) {
            $retorno = true;
        }
        
        return $retorno;
    }

    private function verificarInformacoes( $dados) {
        $errosEncontrados = '';
	if ( !$dados->getTitulo()) {
	    $errosEncontrados .= '<p class="erroEncontrado">Título da notícia não é válido.</p>';
	}
        
        if( !$dados->getDataNoticia()) {
            $errosEncontrados .= '<p class="erroEncontrado">Data da notícia não foi informada.</p>';
        }
        
        if( !$dados->getConteudo()) {
            $errosEncontrados .= '<p class="erroEncontrado">Conteúdo não foi informado.</p>';
        }
        
        if( !$dados->getAutor()) {
            $errosEncontrados .= '<p class="erroEncontrado">Autor da notícia não foi informado.</p>';
        }
	
	return ( $errosEncontrados ) ? $errosEncontrados : false  ;
    }
    
    public function obter( $codigoNoticia) {
        $mysql = Mysql::getInstance();
        
        $objNoticia = new Noticia();
        
        if( $this->verificarNoticia($codigoNoticia)) {
            $sql = ' SELECT noti_titulo , noti_autor, DATE_FORMAT(noti_data,\'%d/%m/%Y\') AS noti_data, noti_conteudo, DATE_FORMAT(noti_data_insercao,\'%d/%m/%Y\') AS noti_data_insercao FROM noticia WHERE noti_codigo = ' . $codigoNoticia;
            $dados = $mysql->selectLine($sql);



            $objNoticia->setCodigoNoticia($codigoNoticia);
            $objNoticia->setAutor($dados['noti_autor']);
            $objNoticia->setConteudo($dados['noti_conteudo']);
            $objNoticia->setDataInsercao($dados['noti_data_insercao']);
            $objNoticia->setDataNoticia($dados['noti_data']);
            $objNoticia->setTitulo($dados['noti_titulo']);
        }
        
        return $objNoticia;
    }
    
    public function buscar ( $noticia = null, $limite = 10, $offset = null) {
        $mysql = Mysql::getInstance();
        
        /*
         1 . TODO Adicionar métodos de busca conforme parâmetros da notícia.
         */

        $sql = ' SELECT noti_codigo, noti_titulo, noti_autor, DATE_FORMAT(noti_data,\'%d/%m/%Y\') AS data_noticia FROM noticia ORDER BY noti_data DESC ';
        
        if( $limite != null ) {
            $sql .= ' LIMIT '.$limite;
        }
        
        if( $offset != null) {
            $sql .= ' OFFSET '.$offset;
        }
        
        return $mysql->select($sql);
    }
    
    public function verificarNoticia( $codigoNoticia) {
        $retorno = false;
        $mysql = Mysql::getInstance();
        
        $sql =  'SELECT count( noti_codigo) FROM noticia WHERE noti_codigo = '.$codigoNoticia;
        $codigoNoticia = $mysql->selectValue( $sql);
        
        if( $codigoNoticia > 0) {
            $retorno = true;
        }
        
        return $retorno;
    }
    
    public function obterTotalDeNoticias() {
        $mysql = Mysql::getInstance();

        $sql = " SELECT count( noti_codigo) as totalNoticias FROM noticia ";
        
        return $mysql->selectValue($sql);
    }

}

?>
