<?php

function link_to($params = null) {
    $params = func_get_args();
    $name = array_shift($params);
    $url = call_user_func_array('url_for', $params);

    return "<a href=\"$url\">$name</a>";
}



function option_tag($id, $title, $act_id) {
    $s = '<option value="' . $id . '"';
    $s .= ($id == $act_id) ? ' selected="true"' : '';
    $s .= '>' . $title . '</option>';
    return $s;
}


function mask($val, $mask){
    $maskared = '';
    $k = 0;
    
    
    $is_compative = substr_count($mask, "#") == strlen($val) ?: false;
    
    if( $is_compative ):
        
        for ($i = 0; $i <= strlen($mask) - 1; ++$i) {
            if ($mask[$i] == '#') {
                if (isset($val[$k])) {
                    $maskared .= $val[$k++];
                }
            } else {
                if ( isset($mask[$i])  ) {
                    $maskared .= $mask[$i];
                }
            }
        }
    else:
        $maskared = $val;
    endif;

    return $maskared;
}

function dataBoasVindas(){
    setlocale(LC_TIME, 'pt_BR.utf8');
    $dataAtual = new DateTime();
    $meses = [
        1 => 'Janeiro',
        2 => 'Fevereiro',
        3 => 'Março',
        4 => 'Abril',
        5 => 'Maio',
        6 => 'Junho',
        7 => 'Julho',
        8 => 'Agosto',
        9 => 'Setembro',
        10 => 'Outubro',
        11 => 'Novembro',
        12 => 'Dezembro'
    ];
    return $dataAtual->format('d \d\e ') . $meses[(int)$dataAtual->format('n')] . $dataAtual->format(' \d\e Y');
}