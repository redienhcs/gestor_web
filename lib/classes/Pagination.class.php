<?php
/*******************************************************************************
 * ÚLTIMA ATUALIZAÇÃO
 * =============
 * Outubro, 02 2013
 *
 * AUTOR
 * =============
 * Anderson Felipe Schneider <hactar@universo.univates.br>
 * 
 * DESCRIÇÃO
 * =============
 * Prevê métodos para criar paginação em páginas de registros.
 * 
 * PROPÓSITO
 * =============
 * Provêr facilidades para criar paginação de resultados.
 *
 * USO
 * =============
 * $links = new Pagination ( $objBusNoticia->obterTotalDeNoticias(), 10);
 * echo $links->display();
 * 
\*********************************************************************************************************************/
/*
 2. TODO Adicionar meios de mudar o nome das variáveis GET.
 */
class Pagination {

    private $num_pages = 1;
    private $start = 0;
    private $display;
    private $start_display;

    /**
     * Constrói um elemento de paginação conforme os parâmetros apresentados.
     * 
     * @param int/String $query Número de registros quer serão páginados ou a query que retorna o número de registros
     * @param int $display Número de registros que será mostrado por página.
     * @return Pagination Retorna um objeto paginação que deverá ser usado para gerar a visualização.
     */
    function __construct($query, $display = 10) {
        if (!empty($query)) {
            
            $this->display = $display;
            
            if (isset($_GET['display']) && is_numeric($_GET['display']))
                $this->display = (int) $_GET['display'];
            
            if (isset($_GET['np']) && is_numeric($_GET['np']) && $_GET['np'] > 0) {
                $this->num_pages = (int) $_GET['np'];
            } else {
                if (is_numeric($query)) {
                    $num_records = $query;
                } else {
                    $result = db_query($query);
                    if ($result->num_rows > 1 || strstr($query, 'COUNT') === false) {
                        $num_records = $result->num_rows;
                    } else {
                        $row = $result->fetch_row();
                        $num_records = $row[0];
                    }
                }
                if ($num_records > $this->display)
                    $this->num_pages = ceil($num_records / $this->display);
            }
            
            if (isset($_GET['s']) && is_numeric($_GET['s']) && $_GET['s'] > 0)
                $this->start = (int) $_GET['s'];
            $this->start_display = " LIMIT {$this->start}, {$this->display}";
        }
    }
    
    /**
     * Constrói uma div com os elementos da paginação.
     * 
     * @param int $split Descrição
     * @return String html da paginacao
     */
    public function display($split = 5) {
        $html = '';
        
        //Se só existe uma página então não tem paginação.
        if ($this->num_pages <= 1)
            return $html;
        
        $url = Anhur::assemblyURL();//$this->url('add', '', 'np', $this->num_pages);
        
        $current_page = ($this->start / $this->display) + 1;
        
        $begin = $current_page - $split;
        $end = $current_page + $split;

        if ($begin < 1) {
            $begin = 1;
            $end = $split * 2;
        }

        if ($end > $this->num_pages) {
            $end = $this->num_pages;
            $begin = $end - ($split * 2);
            $begin++; // add one so that we get double the split at the end
            if ($begin < 1)
                $begin = 1;
        }
        if ($current_page != 1) {
            $html .= '<a class="first" title="First" href="' . $this->url('add', $url, 's', 0) . '">&laquo;</a>';
            $html .= '<a class="prev" title="Previous" href="' . $this->url('add', $url, 's', $this->start - $this->display) . '">Previous</a>';
        } else {
            $html .= '<span class="disabled first" title="First">&laquo;</span>';
            $html .= '<span class="disabled prev" title="Previous">Previous</span>';
        }
        for ($i = $begin; $i <= $end; $i++) {
            if ($i != $current_page) {
                $html .= '<a title="' . $i . '" href="' . $this->url('add', $url, 's', ($this->display * ($i - 1))) . '">' . $i . '</a>';
            } else {
                $html .= '<span class="current">' . $i . '</span>';
            }
        }
        if ($current_page != $this->num_pages) {
            $html .= '<a class="next" title="Next" href="' . $this->url('add', $url, 's', $this->start + $this->display) . '">Next</a>';
            $last = ($this->num_pages * $this->display) - $this->display;
            $html .= '<a class="last" title="Last" href="' . $this->url('add', $url, 's', $last) . '">&raquo;</a>';
        } else {
            $html .= '<span class="disabled next" title="Next">Next</span>';
            $html .= '<span class="disabled last" title="Last">&raquo;</span>';
        }
        return '<div class="pagination">' . $html . '</div>';
    }

    public function limit() {
        return $this->start_display;
    }

    public function url($action = '', $url = '', $key = '', $value = NULL) {
        $protocol = ($_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
        if (empty($url))
            $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        
        if ($action == 'ampify')
            return $this->ampify($url);
        $url = str_replace('&amp;', '&', $url);
        if (empty($action) && empty($key)) { // clean the slate
            $url = explode('?', $url);
            return $url[0]; // no amps to convert
        }
        $fragment = parse_url($url, PHP_URL_FRAGMENT);
        if (!empty($fragment)) {
            $fragment = '#' . $fragment; // to add on later
            $url = str_replace($fragment, '', $url);
        }
        if ($key == '#') {
            if ($action == 'delete')
                $fragment = '';
            elseif ($action == 'add')
                $fragment = '#' . urlencode($value);
            return $this->ampify($url . $fragment);
        }
        $url = preg_replace('/(.*)(\?|&)' . $key . '=[^&]+?(&)(.*)/i', '$1$2$4', $url . '&');
        $url = substr($url, 0, -1);
        //echo $url.' - teste<br />';
        $value = urlencode($value);
        if ($action == 'delete') {
            return $this->ampify($url . $fragment);
        } elseif ($action == 'add') {
            if (strpos($url, '?') === false) {
                return ($url . '?' . $key . '=' . $value . $fragment); // no amps to convert
            } else {
                return $this->ampify($url . '&' . $key . '=' . $value . $fragment);
            }
        }
    }
    
    private function ampify($string) {
        return str_replace(array('&amp;', '&'), array('&', '&amp;'), $string);
    }
    
    /**
     * Calcula o offset da busca sql
     * @return int numero do offset que será utilizado na busca.
     */
    static function obterOffset() {
        $retorno = 0;
        if (isset($_GET['s']) && is_numeric($_GET['s'])) {
            $retorno = (int) strip_tags(trim($_GET['s']));
        }
        
        return $retorno;
    }

}
?>

