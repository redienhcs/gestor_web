<?php

/*******************************************************************************
 * ÚLTIMA ATUALIZAÇÃO
 * ============
 * Outubro, 01 2013
 *
 *
 * AUTOR
 * =============
 * Anderson Felipe Schneider <hactar@universo.univates.br>
 * 
 * 
 * PROPÓSITO
 * =============
 * Facilitar aobtenção de informações das bases de dados do facebook.
 *
 * 
\*********************************************************************************************************************/

class Facebook {
    
    /**
     * Obtêm a foto de perfil do usuário do facebook informado
     * Uso: $url = Facebook::obterFotoProfile( 'usuarioTeste');
     * 
     * @param $profileName nome do endereço do profile
     * @param $parametros pode conter parametros para o tamanho da imagem
     * @return url da imagem de profile do perfil informado
     */
    static function obterFotoProfile( $profileName, $parametros) {
        $link = 'https://graph.facebook.com/'.$profileName.'/picture?redirect=false&'.$parametros;
        $contents = file_get_contents( $link);
        $contents_json = json_decode( $contents);
        
        return $contents_json->data->url;
    }
}





?>
