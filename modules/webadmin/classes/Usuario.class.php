<?php

/**
 * Classe representativa de um usuário.
 *
 * @author Anderson Felipe Schneider <hactar@universo.univates.br>
 */

require_once 'business/BusUsuario.class.php';

class Usuario {
    private $usua_codigo, $usua_pess_codigo, $usua_iteracoes;
    private $usua_salto, $usua_hash;
    
    public function getUsua_codigo() {
        return $this->usua_codigo;
    }

    public function getUsua_pess_codigo() {
        return $this->usua_pess_codigo;
    }

    public function getUsua_iteracoes() {
        return $this->usua_iteracoes;
    }

    public function getUsua_salto() {
        return $this->usua_salto;
    }

    public function getUsua_hash() {
        return $this->usua_hash;
    }

    public function setUsua_codigo($usua_codigo) {
        $this->usua_codigo = $usua_codigo;
    }

    public function setUsua_pess_codigo($usua_pess_codigo) {
        $this->usua_pess_codigo = $usua_pess_codigo;
    }

    public function setUsua_iteracoes($usua_iteracoes) {
        $this->usua_iteracoes = $usua_iteracoes;
    }

    public function setUsua_salto($usua_salto) {
        $this->usua_salto = $usua_salto;
    }

    public function setUsua_hash($usua_hash) {
        $this->usua_hash = $usua_hash;
    }
    
    public function verificarExistencia( $codigousuario) {
        return new busUsuario().verificarExistencia( $codigousuario);
    }
    
    public function inserir() {
        $retorno = false;
        $busUsuario = new BusUsuario();
        
        if( $busUsuario->insert( $this)) {
            $retorno = true;
        }
        
        return $retorno;
    }
    
    public function alterar() {
        $retorno = false;
        $busUsuario = new BusUsuario();
        
        if ( $this->codigo > 0) {
            if ( $busUsuario->alter($this)) {
                $retorno = true;
            }
        }
        
        
        return $retorno;
    }
    
    public function deletar() {
        $retorno = false;
        
        $busUsuario = new BusUsuario();
        
        if ( $this->codigo > 0) {
            if ( $busUsuario->delete($this)) {
                $retorno = true;
            }
        }
        
        return $retorno;
    }
    
    
}

?>
