<?php
ob_start();

if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {
    //Gera um novo nome para o arquivo.
    $file_name = Arquivo::gerarNomeArquivoSistema();//md5( date("dmYhis").rand()).pathinfo($_FILES['upload_file']['name'], PATHINFO_EXTENSION);
    
    //Pega o id do arquivo, para fins de validação.
    $file_id = strip_tags($_POST['upload_file_ids']);
    
    /*
     1 . TODO Adicionar a informação do local de upload dos arquivos dentro de uma configuração.
     */
    //Localização final dos arquivos
    $final_location = 'files/' . $file_name; //Directory to save file plus the file to be saved
    
    
    //Pega as informações e cria um objeto Arquivo.
    $objArquivo = new Arquivo();
    $objArquivo->setNome_real( $_FILES['upload_file']['name']);
    $objArquivo->setNome_sistema( $file_name);
    $objArquivo->setTamanho_arquivo( $_FILES['upload_file']['size']);
    $objArquivo->setTipo_arquivo( $_FILES['upload_file']['type']);
    
    //Pega a data da última modificação enviada junto com o arquivo.
    $ultimaModificacaoArquivo = date_parse( $_POST['last_modified']);
    $objArquivo->setUltima_modificacao( $ultimaModificacaoArquivo['day'].'/'.$ultimaModificacaoArquivo['month'].'/'.$ultimaModificacaoArquivo['year']);
    
    //Move o arquivo para a pasta correta e insere as informações no banco de dados.
    if (move_uploaded_file(strip_tags($_FILES['upload_file']['tmp_name']), $final_location)) {
        
        $objArquivo->inserir();
        
        //Display the file id
        echo $file_id;
        
    } else {
        //Display general system error
        echo 'general_system_error';
    }
}
$contents = ob_get_contents();
ob_end_clean();
return $contents;
?>
