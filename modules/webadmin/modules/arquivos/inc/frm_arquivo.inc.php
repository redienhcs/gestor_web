<?php
$exTools = externalTools::getInstance();
$exTools->addNewJavascript( '' , 'lib/uploader.js');
$exTools->addNewJavascript('$(document).ready(function()
            {
                // Call the main function
                new multiple_file_uploader
                        ({
                            form_id: "frmUploadArquivo", // Form ID
                            autoSubmit: true,
                            server_url: "'.Anhur::assemblyURL().'&action=uploadfile&ajaxRequest=true" // PHP file for uploading the browsed files

                                    // To modify the design and display of the browsed file,
                                    // Open the file named js/vpb_uploader.js and search for the following: /* Display added files which are ready for upload */
                                    // You can modify the design and display of browsed files and also the CSS file as wish.
                        });
            });');
ob_start();
?>
<form name="frmUploadArquivo" id="frmUploadArquivo" action="javascript:void(0);" enctype="multipart/form-data">
    <input type="file" name="btnUploadMultiplo" id="btnUploadMultiplo" multiple="multiple" value="Selecionar arquivos"  />
    <input type="submit" value="Enviar" class="btnEnviarArquivos" />
</form>

<!-- Uploaded Files Displayer Area -->	
<div id="arquivos_adicionados" class="main_wrapper">
    <div id="file_displayer_header"> 
        <div id="file_names"><div style="width:365px; float:left;">Nome dos arquivos</div><div style="width:90px; float:left;">Estado</div></div>
        <div id="file_size">Tamanho</div>
        <div id="last_date_modified">Última modificação</div><br clear="all" />
    </div>
    <input type="hidden" id="added_class" value="vpb_blue">
    <span id="arquivos_removidos"></span>
</div>
<?php

$contents = ob_get_contents();
ob_end_clean();

return $contents;
?>
