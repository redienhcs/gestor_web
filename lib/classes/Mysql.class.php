<?php
/*******************************************************************************
 * ÚLTIMA ATUALIZAÇÃO
 * =============
 * Outubro, 01 2013
 *
 * AUTOR
 * =============
 * Anderson Felipe Schneider <hactar@universo.univates.br>
 * 
 * DESCRIÇÃO
 * =============
 * Prevê métodos para operações de banco de dados
 * 
 * PROPÓSITO
 * =============
 * Provêr facilidades para manipulação de banco de dados.
 *
 * USO
 * =============
 * $mysql = Mysql::getInstance();
 * 
\*********************************************************************************************************************/

class Mysql {

    private $conexao = false;
    private $tabelas = array();
    private $colunas = array();
    private $username = null;
    private $password = null;
    private $server = null;
    private $database = null;
    private $connection = null;
    private $errors;
    private $debug = false;

    private static $instance = null;

    public function getDebug() {
	return $this->debug;
    }

    public function setDebug($debug) {
	$this->debug = $debug;
    }

    public function getLastInsertId() {
	return mysql_insert_id();
    }

    private function log() {
	if ($this->debug) {
	    //Se tiver erro adicionar o erro também
	    //new dbug( func_get_args() );
	}
    }

    public function getConnection() {
	return $this->connection;
    }

    public function setConnection($connection) {
	$this->connection = $connection;
    }

    public static function getInstance( $data = null ) {
	return self::$instance;
    }
    
    public function __construct($dadosConexao = null) {

	if (is_array($dadosConexao)) {
	    $this->username =	$dadosConexao['username'];
	    $this->server   =	$dadosConexao['server'];
	    $this->password =	$dadosConexao['password'];
	    $this->database =	$dadosConexao['database'];
	}

	$this->connection = mysql_connect($this->server, $this->username, $this->password);
	if ($this->connection) {
	    mysql_select_db($this->database);
	}

        mysql_query("SET NAMES 'utf8'");
	
	$this->errors = mysql_error();

	self::$instance = $this;
    }

    public function disconnect() {

	if (!$this->connection) {
	    return true;
	}

	return mysql_close($this->connection);
    }

    public function execute($query) {
	if (!$this->connection) {
	    return false;
	}

	$result = mysql_query($query, $this->connection);

	$this->log('Function execute', $query, $result);

	return $result;
    }

    public function executar($query) {

	if (!$this->connection) {
	    return false;
	}

	return mysql_query($query, $this->connection);
    }

    public function getError() {
	return mysql_error($this->connection);
    }

    public function getErrorNumber() {
	return mysql_errno($this->connection);
    }

    public function select($query, $col_index = false, $rowIndex  = false ) {
	return $this->selectMultiLine($query, $col_index, $rowIndex);
    }

    public function selectMultiLine($query, $col_index = false , $rowIndex = false ) {

	$result = $this->execute($query);

	if (!$result) {
	    return false;
	}

	$rt = array();
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	    
	    if ($col_index) {
		$rt[current($row)] = $row;
	    } else {
		if( $rowIndex ) {
		    $rt[$row[$rowIndex]] = $row;
		} else {
		    $rt[] = $row;
		    
		}
	    }
	}

	mysql_free_result($result);
	return $rt;
    }

    public function selectValue($query) {
	$result = $this->execute($query);

	if (!$result) {
	    return false;
	}

	list($rt) = mysql_fetch_array($result, MYSQL_NUM);

	mysql_free_result($result);

	return $rt;
    }

    public function selectLine($query) {
	$result = $this->execute($query);

	if (!$result) {
	    return false;
	}

	$rt = array();
	$row = mysql_fetch_array($result, MYSQL_ASSOC);

	if ($row) {
	    $rt = $row;
	}

	mysql_free_result($result);

	return $rt;
    }

    public function processValueResult($result) {
	if (!$result) {
	    return false;
	}

	list($rt) = mysql_fetch_array($result, MYSQL_NUM);

	mysql_free_result($result);

	return $rt;
    }

    public function insert($table, $dados) {
	if (is_object($dados)) {
	    $dados = get_object_vars($dados);
	}

	if (!is_array($dados) || count($dados) == 0) {
	    return false;
	}

	$values_resevados = array('NOW()', 'NULL');

	$sql = "";

	$count = count($dados);
	$sql .= "INSERT INTO $table (";
	foreach ($dados as $key => $value) {
	    $sql .= $key;
	    if (--$count > 0) {
		$sql .= ", ";
	    }
	}

	$sql .= ") ";

	$count = count($dados);

	$sql .= "VALUES (";
	foreach ($dados as $key => $value) {

	    if (in_array(strtoupper($value), $values_resevados)) {
		$sql .= "$value";
	    } else {
		$sql .= "'$value'";
	    }
	    if (--$count > 0) {
		$sql .= ", ";
	    }
	}
	$sql .= ") ";

	return $this->execute($sql);
    }

    public function update($tabela, $dados, $where = null) {
	if (is_object($dados)) {
	    $dados = get_object_vars($dados);
	}

	if (!is_array($dados) || count($dados) == 0) {
	    return false;
	}

	$values_resevados = array('NOW()', 'NULL');

	$sql = "";

	$count = count($dados);
	$sql .= "UPDATE $tabela SET ";
	foreach ($dados as $key => $value) {
	    if (in_array(strtoupper($value), $values_resevados)) {
		$sql .= "$key = $value";
	    } else {
		$sql .= "$key = '$value'";
	    }
	    if (--$count > 0) {
		$sql .= ", ";
	    }
	}

	if ($where) {
	    $sql .= " WHERE $where";
	}
        
	return $this->executar($sql);
    }

    public function delete($tabela, $where = null) {
	$sql = "DELETE FROM $tabela";
	if ($where) {
	    $sql .= " WHERE $where";
	}
	return $this->execute($sql);
    }

    public function beginTransaction() {
	return $this->execute("BEGIN");
    }

    public function cancelTransaction() {
	return $this->execute("ROLLBACK");
    }

    public function cancelTansaction() {
	return $this->cancelTransaction();
    }

    public function finishTransaction() {
	return $this->execute("COMMIT");
    }

    public  function finishTansaction() {
	return $this->finishTransaction();
    }
    
    public static function anti_sql_injection($string) {
        $string = get_magic_quotes_gpc() ? stripslashes($string) : $string;

        $string = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($string) : mysql_escape_string($string);

        return $string;
    }

}
//new Mysql($_CFG['database_conf']);

?>
