<?php


function get_folhas(){
    $sql = "SELECT * FROM folha_pagamento";
    return find_objects_by_sql($sql);
}

function folha_aberta(){

    $sql = "SELECT
                *
            FROM folha_pagamento
            WHERE status = 'aberto'
    ";
    $resultado = find_objects_by_sql($sql);

    return count($resultado) > 1 ?: false;
}

function folha_aberta_by_id($id_folha){

    $where_condition    =  [];
    $parse_condition    =  [];

    $where_condition[] = "status = :status";
    $parse_condition[":status"] = 'aberto';

    if( !empty($id_folha) ):
        $where_condition[] = "id = :id";
        $parse_condition[":id"] = $id_folha;
    endif;

    $where_condition = implode(" AND ", $where_condition);

    $sql = "SELECT
                *
            FROM folha_pagamento
            WHERE {$where_condition}
    ";
    $resultado = find_objects_by_sql($sql, $parse_condition);

    return count($resultado) > 0 ?: false;
}

function folha_aberta_by_tipo($tipo){

    if( !in_array($tipo, ['mensal', 'suplementar']) ):
        throw new Exception("O tipo não está entre os parâmetros esperados!");
        return false;
    endif;

    $where_condition    =  [];
    $parse_condition    =  [];

    $where_condition[] = "status = :status";
    $parse_condition[":status"] = 'aberto';

    $where_condition[]              = "tipo_folha = :tipo_folha";
    $parse_condition[":tipo_folha"] = $tipo;

    $where_condition = implode(" AND ", $where_condition);

    $sql = "SELECT
                *
            FROM folha_pagamento
            WHERE {$where_condition}
    ";
    $resultado = find_objects_by_sql($sql, $parse_condition);

    return count($resultado) > 0 ?: false;
}

function folha_existe_by_comp($comp){

    $where_condition    =  [];
    $parse_condition    =  [];

    $where_condition[] = "competencia = :competencia";
    $parse_condition[":competencia"] = $comp;

    $where_condition = implode(" AND ", $where_condition);

    $sql = "SELECT
                *
            FROM folha_pagamento
            WHERE {$where_condition}
    ";
    $resultado = find_objects_by_sql($sql, $parse_condition);

    return count($resultado) > 0 ?: false;
}

function get_folha_existe_by_comp($comp){

    $where_condition    =  [];
    $parse_condition    =  [];

    $where_condition[] = "competencia = :competencia";
    $parse_condition[":competencia"] = $comp;

    $where_condition = implode(" AND ", $where_condition);

    $sql = "SELECT
                *
            FROM folha_pagamento
            WHERE {$where_condition}
    ";

    return find_object_by_sql($sql, $parse_condition);
}

function get_all_folhas_pagamentos($only_open = false){

    $where_condition    = [];
    $parse_data         = [];

    if( $only_open ):
        $where_condition[] = " status = 'aberto'";
    endif;

    $where_condition = count($where_condition) > 0  ?  "WHERE TRUE AND " . implode(" AND ", $where_condition) : '';

    $sql = "SELECT
                *
            FROM folha_pagamento
            {$where_condition}
            ORDER BY competencia ASC
    ";
    $resultado  = find_objects_by_sql($sql, $parse_data);
    $html       = '';

        forEach( $resultado AS $row ):
            //$data_label = [ $row->numeracao, $row->competencia, $row->tipo_folha, $row->status ];
            $data_label = [ $row->numeracao, $row->competencia, $row->tipo_folha ];
            $data_label = array_filter($data_label);
            $data_label = implode(" - ", $data_label);

            $is_this_selected = $row->tipo_folha == "mensal" && $row->status == "aberto" ? "selected" : '';

            $html .= "
                <option value='{$row->id}' {$is_this_selected}>{$data_label}</option>
            ";
        endforeach;

    return $html;
}

function get_infos_folha_pagamento($id_folha){
    $sql = "SELECT
                *
            FROM folha_pagamento
            WHERE id = '{$id_folha}'
    ";
    
    return find_object_by_sql($sql);
}

function folha_pagamento_create($obj){
    $responsavel_abertura = $_SESSION['username'];

    $data        = [
        "tipo_folha"            => $obj->tipo_folha,
        "competencia"           => $obj->competencia,
        "data_abertura"         => $obj->data_abertura,
        "responsavel_abertura"  => $responsavel_abertura,
        "status"                => "aberto"

    ];
    $colunas = array_keys($data);
    $resultado = create_object( (Object) $data, "folha_pagamento", $colunas);
    flush_folhas_pagamentos_numeros($obj->competencia);
    return $resultado > 0 ? "ok"  : $resultado;
}

function flush_folhas_pagamentos_numeros($comp){

    ################ PROCURANDO AS FOLHAS ################
        $sql = "SELECT
                    *
                FROM folha_pagamento
                WHERE competencia = :comp AND tipo_folha = 'suplementar' AND status = 'aberto'
                ORDER BY id
        ";

        $parse_data = [
            ":comp" => $comp
        ];

        $result = find_objects_by_sql($sql, $parse_data);
    ################ //PROCURANDO AS FOLHAS ################


    ################ RESET ################
        $result_reset = update_all_object( (Object) ["numeracao" => null], "folha_pagamento", ["numeracao"], ["competencia" => $comp, "tipo_folha" => 'suplementar']);
    ################ //RESET ################


    ################ SETANDO A NUMERAÇÃO ################
        if( count($result) > 1 ):
            $numero = 0;
            forEach( $result AS $row ):
                $numero++;
                $id_folha = $row->id;
    
                $data = (Object) [
                    "id"        => $id_folha,
                    "numeracao" => $numero
                ];
    
                update_object($data, 'folha_pagamento', ['numeracao']);
            endforeach;
        endif;
    ################ //SETANDO A NUMERAÇÃO ################


    return;

}

function folha_pagamento_update_status($obj){
    
    $data       = (Object) [
        "id"        => $obj->id_folha,
        "status"    => $obj->status
    ];
    $result = update_object($data, 'folha_pagamento', ['status']);

         ################ PROCURANDO AS FOLHAS ################
            $sql = "SELECT
                        *
                    FROM folha_pagamento
                    WHERE id = :id AND tipo_folha = 'suplementar'
            ";

            $parse_data = [
                ":id" => $obj->id_folha
            ];

            $data_infos = find_object_by_sql($sql, $parse_data);

            if( $data_infos ):
                flush_folhas_pagamentos_numeros($data_infos->competencia);
            endif;
        ################ //PROCURANDO AS FOLHAS ################


    return $result ? "ok" : $result;
}
?>