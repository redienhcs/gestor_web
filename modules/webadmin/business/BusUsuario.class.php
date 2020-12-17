<?php

require_once 'classes/Usuario.class.php';



class BusUsuario {
    
    public static $tableName = 'usuario';
    
    
    function __construct() {
        $anhur = Anhur::getInstance();
        new Mysql( $anhur->getConf('database_conf'));
    }
    
    public function alter( $objUsuario) {
        $retorno = false;
        
	$errosEncontrados = $this->verificarInformacoes( $objUsuario);
	
	if( !$errosEncontrados ) {
	    
	    $dadosAlteracao = array();
	    
	    $mysql = Mysql::getInstance();
            
	    $dadosAlteracao['usua_salto']           =   $objUsuario->getUsua_salto();
            $dadosAlteracao['usua_iteracoes']           =   $objUsuario->getUsua_iteracoes();
            $dadosAlteracao['usua_hash']           =   $objUsuario->getUsua_hash();
            $dadosAlteracao['usua_pess_codigo']           =   $objUsuario->getUsua_pess_codigo();
            
	    if ( $mysql->update(self::$tableName, $dadosAlteracao , "usua_codigo = '{$objUsuario->getUsua_codigo()}' " ) ) {
		$retorno = true;
	    } else {
                Anhur::clog( 'Erro na alteração dos dados do usuário');
                Anhur::clog( $mysql->getError());
                $retorno = false;
	    }
	}
        
        return $retorno;
    }

    public function insert( $objUsuario) {
        $retorno = false;
	$errosEncontrados = $this->verificarInformacoes( $objUsuario);
        
	if ( !$errosEncontrados) {
	    
	    $mysql = Mysql::getInstance();

	    $dadosInsercao = array();

	    $dadosInsercao['usua_salto']           =   $objUsuario->getUsua_salto();
            $dadosInsercao['usua_iteracoes']           =   $objUsuario->getUsua_iteracoes();
            $dadosInsercao['usua_hash']           =   $objUsuario->getUsua_hash();
            $dadosInsercao['usua_pess_codigo']           =   $objUsuario->getUsua_pess_codigo();
	    /*
             4 . TODO acho que vai dar um erro com o self::$tableName
             */
            $dadosAlteracao = '';
	    if ( $mysql->insert( self::$tableName, $dadosAlteracao)) {
                $retorno = true;
	    } else {
                Anhur::clog( 'Erro na inserção dos dados do usuário');
                Anhur::clog( $mysql->getError());
                
                $retorno = false;
	    }
	}
        
        return $retorno;
    }

    public function delete( $usuario) {
        
        $retorno = false;

	$mysql = Mysql::getInstance();
        
        $sql = 'DELETE FROM '.self::$tableName.' WHERE usua_codigo = \''.$usuario->getCodigoUsuario().'\'';
        
        if ($mysql->execute($sql)) {
            $retorno = true;
        }
        
        return $retorno;
    }

    private function verificarInformacoes( $dados) {
        $errosEncontrados = '';
        
        /*
         0 . TODO Verificar informações do usuário.
         */
	
	return ( $errosEncontrados ) ? $errosEncontrados : false  ;
    }
    
    public function obter( $codigoUsuario) {
        $mysql = Mysql::getInstance();
        
        $objUsuario = new Usuario();
        
        if( $this->verificarUsuario($codigoUsuario)) {
            $sql = ' SELECT * from '.self::$tableName.' WHERE usua_codigo = ' . $codigoUsuario;
            $dados = $mysql->selectLine($sql);

            $objUsuario->setUsua_codigo($codigoUsuario);
            $objUsuario->setUsua_hash($dados['usua_hash']);
            $objUsuario->setUsua_iteracoes($dados['usua_iteracoes']);
            $objUsuario->setUsua_pess_codigo($dados['usua_pess_codigo']);
            $objUsuario->setUsua_salto($dados['usua_salto']);
        }
        
        return $objUsuario;
    }
    
    public function buscar ( $limite = 10, $offset = null) {
        $mysql = Mysql::getInstance();

        $sql = ' SELECT * FROM usuario ORDER BY noti_data DESC ';
        
        if( $limite != null ) {
            $sql .= ' LIMIT '.$limite;
        }
        
        if( $offset != null) {
            $sql .= ' OFFSET '.$offset;
        }
        
        return $mysql->select($sql);
    }
    
    public function verificarUsuario( $codigoUsuario) {
        $retorno = false;
        $mysql = Mysql::getInstance();
        
        $sql =  'SELECT count( usua_codigo) FROM usuario WHERE usua_codigo = '.$codigoUsuario;
        $totalEncontrado = $mysql->selectValue( $sql);
        
        if( $totalEncontrado > 0) {
            $retorno = true;
        }
        
        return $retorno;
    }
    
    public function obterTotalDeUsuarios() {
        $mysql = Mysql::getInstance();

        $sql = " SELECT count( usua_codigo) as totalUsuarios FROM usuario ";
        
        return $mysql->selectValue($sql);
    }

}

?>
