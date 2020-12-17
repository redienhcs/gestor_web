<?php

//$objBusNoticia = new busNoticia();
$noticiasPorPagina = 10;
//$notificacoes = Notificacoes::getInstance();
$ANHUR = Anhur::getInstance();
$paginacao = $ANHUR->obterPaginacao( $objBusNoticia->obterTotalDeNoticias());
//$links = new Pagination ( $objBusNoticia->obterTotalDeNoticias(), $noticiasPorPagina );



$noticias = $objBusNoticia->buscar( null, $ANHUR->getConf('paginacao')['itens_pagina'], $paginacao->obterOffset() );
echo $paginacao->display(20);
?>
<table id="gridDeNoticias" class="moduleGrid">
    <thead>
        <tr>
            <td>Código</td>
            <td>Título</td>
            <td>Autor</td>
            <td>Data</td>
            <td></td>
            <td></td>
        </tr>
    </thead>
<?php

if( is_array( $noticias)) {
    foreach ( $noticias as $indice => $noticia) {
        echo '<tr>';
        echo '<td>',$noticia['noti_codigo'],'</td>';
        echo '<td>',$noticia['noti_titulo'],'</td>';
        echo '<td>',$noticia['noti_autor'],'</td>';
        echo '<td>',$noticia['data_noticia'],'</td>';
        echo '<td><a href="',  Anhur::assemblyURL().'&action=alterarnoticia&cn=',$noticia['noti_codigo'],'">Alterar</td>';
        echo '<td><a href="',  Anhur::assemblyURL().'&&action=removernoticia&cn=',$noticia['noti_codigo'],'">Remover</td>';
        echo '</tr>';
    }
}
?>
</table>
<?php

echo $paginacao->display();
?>