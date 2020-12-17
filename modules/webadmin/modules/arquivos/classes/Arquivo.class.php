<?php

/**
 * Classe que representa um arquivo dentro do sistema.
 *
 * @author Anderson Felipe Schneider <hactar@universo.univates.br>
 */
require_once 'business/BusArquivo.php';

class Arquivo {

    private $codigo;
    private $nome_sistema, $nome_real;
    private $tipo_arquivo;
    private $tamanho_arquivo;
    private $data_insercao, $ultima_modificacao;

    public function __construct() {
        
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function getNome_sistema() {
        return $this->nome_sistema;
    }

    public function setNome_sistema($nome_sistema) {
        $this->nome_sistema = $nome_sistema;
    }

    public function getNome_real() {
        return $this->nome_real;
    }

    public function setNome_real($nome_real) {
        $this->nome_real = $nome_real;
    }

    public function getTipo_arquivo() {
        return $this->tipo_arquivo;
    }

    public function setTipo_arquivo($tipo_arquivo) {
        $this->tipo_arquivo = $tipo_arquivo;
    }

    public function getTamanho_arquivo() {
        return $this->tamanho_arquivo;
    }

    public function setTamanho_arquivo($tamanho_arquivo) {
        $this->tamanho_arquivo = $tamanho_arquivo;
    }

    public function getData_insercao() {
        return $this->data_insercao;
    }

    public function setData_insercao($data_insercao) {
        $this->data_insercao = $data_insercao;
    }

    public function getUltima_modificacao() {
        return $this->ultima_modificacao;
    }

    public function setUltima_modificacao($ultima_modificacao) {
        $this->ultima_modificacao = $ultima_modificacao;
    }

    public static function verificarExistencia($codigoArquivo) {
        return BusArquivo::verificarExistencia($codigoArquivo);
    }

    public static function verificarInformacoes($objArquivo) {
        $errosEncontrados = '';
        if (!$objArquivo->getUltima_modificacao()) {
            $errosEncontrados .= '<p class="erroEncontrado">Título da notícia não é válido.</p>';
        } else if (DateClass::isValid($objArquivo->getUltima_modificacao())) {
            $errosEncontrados .= '<p class="erroEncontrado">Datanotícia não é válido.</p>';
        }

        if (!$objArquivo->getNome_real()) {
            $errosEncontrados .= '<p class="erroEncontrado">Nome do arquivo é inválido.</p>';
        }

        if (!$objArquivo->getNome_sistema()) {
            $objArquivo->setNome_sistema(Arquivo::gerarNomeArquivoSistema());
        }

        return ( $errosEncontrados ) ? $errosEncontrados : false;
    }

    public static function gerarNomeArquivoSistema() {
        return md5(date("dmYhis") . rand()) . '.' . pathinfo($_FILES['upload_file']['name'], PATHINFO_EXTENSION);
        ;
    }

    public function inserir() {
        $retorno = false;
        $busArquivo = new BusArquivo();
        Anhur::flog( 'Antes do insertbus');
        if ($busArquivo->insert($this)) {
            $retorno = true;
        }
        Anhur::flog( 'Depois do insert');

        return $retorno;
    }

    public function alterar() {
        $retorno = false;
        $busArquivo = new BusArquivo();

        if ($this->codigo > 0) {
            if ($busArquivo->alter($this)) {
                $retorno = true;
            }
        }


        return $retorno;
    }

    public function deletar() {
        $retorno = false;

        $busArquivo = new BusArquivo();

        if ($this->codigo > 0) {
            if ($busArquivo->delete($this)) {
                $retorno = true;
            }
        }

        return $retorno;
    }

}

?>
