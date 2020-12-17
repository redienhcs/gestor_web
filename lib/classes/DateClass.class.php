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
 * Provêr funções para a obtenção, controle e formatação de datas.
 *
 * 
\*********************************************************************************************************************/

class DateClass {

    static function toArray($date, $currentFormat = '%d/%m/%Y') {
        $chars = explode(',', 'Y,m,d');

        $tmp = $currentFormat;
        $tmp = str_replace('/', '\/', $tmp);
        foreach ($chars as $char) {
            $tmp = str_replace("%{$char}", "(?<{$char}>[0-9]+)", $tmp);
        }
        $tmp = preg_match("/{$tmp}/", $date, $matches);

        foreach ($chars as $char) {
            @$array[$char] = $matches[$char];
        }

        $array['w'] = date('w', mktime(0, 0, 0, $array['m'], $array['d'], $array['Y']));

        return $array;
    }

    static function arrayToDate($array, $format) {
        $chars = explode(',', 'Y,m,d,F,l');
        $tmp = $format;
        foreach ($chars as $char) {
            /*
              2. TODO Verificar erro com undefined index nesta função.
             */
            @$tmp = str_replace("%{$char}", $array[$char], $tmp);
        }
        return $tmp;
    }

    static function getDay($date, $currentFormat) {
        $array = DateClass::toArray($date, $currentFormat);
        return $array['d'];
    }

    static function getMonth($date, $currentFormat = null) {
        $array = DateClass::toArray($date, $currentFormat);
        return $array['m'];
    }

    static function getMonthName($date, $currentFormat = null) {
        $array = DateClass::toArray($date, $currentFormat);
        return $array['F'];
    }

    static function getYear($date, $currentFormat) {
        $array = DateClass::toArray($date, $currentFormat);
        return $array['Y'];
    }
    
    static function getWeek($date, $currentFormat) {
        $array = DateClass::toArray($date, $currentFormat);
        return $array['w'];
    }

    static function isValid($date, $currentFormat = '%d/%m/%Y') {
        $array = DateClass::toArray($date, $currentFormat);
        return checkdate($array['m'], $array['d'], $array['Y']);
    }

    static function convert($date, $currentFormat, $newFormat) {
        if (strlen($date) == 0)
            return $date;
        $array = DateClass::toArray($date, $currentFormat);
        return DateClass::arrayToDate($array, $newFormat);
    }

    static function getDate($datetime, $outputFormat) {
        return date($outputFormat, strtotime($datetime));
    }

}

?>
