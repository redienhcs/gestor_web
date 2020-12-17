<?php

//$objBusNoticia = new busNoticia();
$itensPorPagina = 10;
//$notificacoes = Notificacoes::getInstance();
$ANHUR = Anhur::getInstance();
$paginacao = $ANHUR->obterPaginacao( $objBusArquivo->obterTotalDeRegistros());
//$links = new Pagination ( $objBusNoticia->obterTotalDeNoticias(), $noticiasPorPagina );



$arquivos = $objBusArquivo->buscar( null, $ANHUR->getConf('paginacao')['itens_pagina'], $paginacao->obterOffset() );
ob_start();
echo $paginacao->display(20);
?>
<table id="gridDeArquivos" class="moduleGrid">
    <thead>
        <tr>
            <td>Nome arquivo</td>
            <td>Última modificação</td>
            <td>Tamanho</td>
            <td>Data Inserção</td>
            <td>Tipo</td>
            <td></td>
            <td></td>
        </tr>
    </thead>
<?php

if( is_array( $arquivos)) {
    foreach ( $arquivos as $indice => $arquivo) {
        echo '<tr>';
        echo '<td>',$arquivo['arqu_nome_real'],'</td>';
        echo '<td>',$arquivo['ultima_modificacao'],'</td>';
        echo '<td>',$arquivo['arqu_tamanho'],'</td>';
        echo '<td>',$arquivo['data_insercao'],'</td>';
        echo '<td>',$arquivo['arqu_tipo'],'</td>';
        echo '<td><a href="',  Anhur::assemblyURL().'&action=alterarnoticia&cn=',$arquivo['arqu_codigo'],'">Alterar</td>';
        echo '<td><a href="',  Anhur::assemblyURL().'&&action=removernoticia&cn=',$arquivo['arqu_codigo'],'">Remover</td>';
        echo '</tr>';
    }
}
?>
</table>
<?php

echo $paginacao->display();

$contents = ob_get_contents();
ob_end_clean();

return $contents;
?>