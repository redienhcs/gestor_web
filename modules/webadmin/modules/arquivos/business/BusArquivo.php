<?php

require_once './classes/Arquivo.class.php';

class BusArquivo {
    private static $tableName = 'arquivo';
    private static $imageFolder = 'images';
    private static $imagesSizes = array( array('fileId'=>'noticia', 'width'=>800, 'height'=>600),
                                        array('fileId'=>'noticia1', 'width'=>127, 'height'=>107)
                                        );
    
    public function alter( $objArquivo) {
        
        $retorno = false;
	$errosEncontrados = Arquivo::verificarInformacoes( $objArquivo);
	
	if( !$errosEncontrados ) {
	    
	    $dadosAlteracao = array();
	    
	    $mysql = Mysql::getInstance();
            
	    $dadosAlteracao['arqu_nome_sistema']         =   $objArquivo->getNome_sistema();
	    $dadosAlteracao['arqu_nome_real']            =   $objArquivo->getNome_sistema();
	    $dadosAlteracao['arqu_tipo']                 =   $objArquivo->getTipo_arquivo();
	    $dadosAlteracao['arqu_tamanho']              =   $objArquivo->getTamanho_arquivo();
	    $dadosAlteracao['arqu_data_insercao']        =   $objArquivo->getData_insercao();
	    $dadosAlteracao['arqu_ultima_modificacao']   =   $objArquivo->getUltima_modificacao();
            
	    if ( $mysql->update(self::$tableName, $dadosAlteracao , " arqu_codigo = '{$objArquivo->getCodigo()}' " ) ) {
		$retorno = true;
            }
	}
        
        return $retorno;
    }

    public function insert( $objArquivo) {
        $retorno = false;
	$errosEncontrados = Arquivo::verificarInformacoes( $objArquivo);
        
	if ( !$errosEncontrados) {
	    
	    $mysql = Mysql::getInstance();

	    $dadosInsercao = array();

	    $dadosInsercao['arqu_nome_sistema']         =   $objArquivo->getNome_sistema();
	    $dadosInsercao['arqu_nome_real']            =   $objArquivo->getNome_real();
	    $dadosInsercao['arqu_tipo']                 =   $objArquivo->getTipo_arquivo();
	    $dadosInsercao['arqu_tamanho']              =   $objArquivo->getTamanho_arquivo();
	    $dadosInsercao['arqu_data_insercao']        =   'NOW()';
	    $dadosInsercao['arqu_ultima_modificacao']   =   DateClass::convert( $objArquivo->getUltima_modificacao(), '%d/%m/%Y', '%Y/%m/%d');;
            
            
	    
	    if ( $mysql->insert( self::$tableName, $dadosInsercao)) {
                $objArquivo->setCodigo( $mysql->getLastInsertId());
//                if( ) {
//                    
//                }
                $retorno = true;
	    }
	}
        
        return $retorno;
    }

    public function delete( $objArquivo) {
        
        $retorno = false;

	$mysql = Mysql::getInstance();
        
        $sql = 'DELETE FROM '.self::$tableName.' WHERE arqu_codigo = \''.$objArquivo->getCodigo().'\'';
        
        if ($mysql->execute($sql)) {
            $retorno = true;
        }
        
        return $retorno;
    }
    
    public function obter( $codigoArquivo) {
        $mysql = Mysql::getInstance();
        
        $objArquivo = new Arquivo();
        
        if( $this->verificarExistencia($codigoArquivo)) {
            $sql = ' SELECT arqu_codigo, arqu_nome_sistema, arqu_nome_real,arqu_tipo,arqu_tamanho, DATE_FORMAT(arqu_data_insercao,\'%d/%m/%Y\') AS arqu_insercao, DATE_FORMAT(arqu_ultima_modificacao,\'%d/%m/%Y\') AS arqu_data_ultima_modificacao FROM arquivo WHERE arqu_codigo = ' . $codigoArquivo;
            $dados = $mysql->selectLine($sql);



            $objArquivo->setCodigo($codigoArquivo);
            $objArquivo->setData_insercao($dados['arqu_insercao']);
            $objArquivo->setNome_real($dados['arqu_nome_real']);
            $objArquivo->setNome_sistema($dados['arqu_nome_sistema']);
            $objArquivo->setTamanho_arquivo($dados['arqu_tamanho']);
            $objArquivo->setTipo_arquivo($dados['arqu_tipo']);
            $objArquivo->setUltima_modificacao($dados['arqu_data_ultima_modificacao']);
        }
        
        return $objArquivo;
    }
    
    public function buscar ( $arquivo = null, $limite = 10, $offset = null) {
        $mysql = Mysql::getInstance();
        
        /*
         1 . TODO Adicionar métodos de busca conforme parâmetros da notícia.
         */

        $sql = ' SELECT arqu_codigo, arqu_nome_real, arqu_tipo,arqu_tamanho, DATE_FORMAT(arqu_data_insercao,\'%d/%m/%Y\') AS data_insercao, DATE_FORMAT(arqu_ultima_modificacao,\'%d/%m/%Y\') AS ultima_modificacao FROM arquivo ORDER BY arqu_nome_real ';
        
        if( $limite != null ) {
            $sql .= ' LIMIT '.$limite;
        }
        
        if( $offset != null) {
            $sql .= ' OFFSET '.$offset;
        }
        
        return $mysql->select($sql);
    }
    
    public function verificarExistencia( $codigoArquivo) {
        $retorno = false;
        $mysql = Mysql::getInstance();
        
        $sql =  'SELECT count( arqu_codigo) FROM arquivo WHERE arqu_codigo = '.$codigoArquivo;
        $codigoArquivo = $mysql->selectValue( $sql);
        
        if( $codigoArquivo > 0) {
            $retorno = true;
        }
        
        return $retorno;
    }
    
    public static function obterTotalDeRegistros() {
        $mysql = Mysql::getInstance();

        $sql = " SELECT count( arqu_codigo) as totalArquivos FROM arquivo ";
        
        return $mysql->selectValue($sql);
    }
    
    public static function gravarAssociacaoDeArquivo( $objArquivo, $associacao) {
        $retorno = false;
        
        $mysql = Mysql::getInstance();

        $dadosInsercao = array();

        $dadosInsercao['arquivo_arqu_codigo'] = $objArquivo->getCodigo();
        $dadosInsercao[$associacao['coluna']] = $associacao['codigo'];
        
        if ($mysql->insert( 'arquivo_'.$associacao['tableName'], $dadosInsercao)) {
            $retorno = true;
        }
        
        return $retorno;
    }
}

?>
