<?php

/**
 * Classe que representa uma notícia a ser exibida no website.
 *
 * @author Anderson Felipe Schneider <hactar@universo.univates.br>
 */

require_once 'business/busNoticia.php';

class Noticia {
    private $codigo;
    private $dataInsercao,$dataNoticia;
    private $conteudo,$titulo;
    private $autor;
    
    
    function __construct() {
    }
    
    public function getCodigoNoticia() {
        return $this->codigo;
    }
    
    public function setCodigoNoticia( $codigoDaNoticia) {
        $this->codigo = $codigoDaNoticia;
    }
    
    public function getDataInsercao() {
        return $this->dataInsercao;
    }
    
    public function setDataInsercao( $dataInsercao) {
        $this->dataInsercao = $dataInsercao;
    }
    
    public function getDataNoticia( ) {
        return $this->dataNoticia;
    }
    
    public function setDataNoticia( $dataNoticia) {
        $this->dataNoticia = $dataNoticia;
    }
    
    public function getConteudo() {
        return $this->conteudo;
    }
    
    public function setConteudo( $conteudo) {
        $this->conteudo = $conteudo;
    }
    
    public function getTitulo() {
        return $this->titulo;
    }
    
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }
    
    public function getAutor() {
        return $this->autor;
    }
    
    public function setAutor( $autor) {
        $this->autor = $autor;
    }
    
    public function verificarExistencia( $codigoNoticia) {
        return new busNoticia().verificarExistencia( $codigoNoticia);
    }
    
    public function inserir() {
        $retorno = false;
        $busNoticia = new BusNoticia();
        
        if( $busNoticia->insert( $this)) {
            $retorno = true;
        }
        
        return $retorno;
    }
    
    public function alterar() {
        $retorno = false;
        $busNoticia = new BusNoticia();
        
        if ( $this->codigo > 0) {
            if ( $busNoticia->alter($this)) {
                $retorno = true;
            }
        }
        
        
        return $retorno;
    }
    
    public function deletar() {
        $retorno = false;
        
        $busNoticia = new BusNoticia();
        
        if ( $this->codigo > 0) {
            if ( $busNoticia->delete($this)) {
                $retorno = true;
            }
        }
        
        return $retorno;
    }
    
}

?>
