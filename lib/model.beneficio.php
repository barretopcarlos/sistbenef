<?php
function load_tipos_beneficios($elegiveis = false){

    $where_condition    = '';

    if( $elegiveis ):
        $where_condition = " WHERE reembolso = 'sim'";
    endif;

    $sql = "SELECT id,beneficio, criado_por, criado_em, dia_limite, reembolso, gasto_teto,tipo_beneficio
            FROM beneficio_tipos
            {$where_condition}
            ORDER BY id
    ";
    return find_objects_by_sql($sql);
}


function add_beneficio($obj){

    $db = option('db_conn');
    $tipoBeneficio = $obj['tipoBeneficio'];
    $diaLimite = $obj['diaLimite']; 
    $id_usuario = $_SESSION['username'];
    
    if($obj['reembolso'] == 'Sim' ){
        $reembolso = 'sim';
    }elseif($obj['reembolso'] == 'Não'){
        $reembolso = 'nao';
    }

    if($obj['tetoGasto'] == 'Sim' ){
        $tetoGasto = 'sim';
    }elseif($obj['tetoGasto'] == 'Não'){
        $tetoGasto = 'nao';
    }

    $sql="
    INSERT INTO `beneficio_tipos` 
    (`beneficio`,  `criado_em`, `criado_por`, `dia_limite`, `reembolso`, `gasto_teto` )
    VALUES
    ('$tipoBeneficio', NOW(), '$id_usuario','$diaLimite','$reembolso','$tetoGasto'); ";    
    
    $stmt = $db->prepare($sql);
    $resultado = $stmt->execute();

    return $resultado;

}

function att_beneficio($id,$obj) {

    $db = option('db_conn');

    $tipoBeneficio = $obj['beneficio'];
    $diaLimite = $obj['dia_limite']; 


    $reembolso = $obj['modalReembolso']; 
    $tetoGasto = $obj['modalTetoGasto']; 

    $sql = "UPDATE beneficio_tipos SET beneficio = '$tipoBeneficio', dia_limite = '$diaLimite', reembolso = '$reembolso', gasto_teto = '$tetoGasto' WHERE id = '$id'";
    
    $stmt = $db->prepare($sql);
    $resultado = $stmt->execute();
    return $resultado;
}

function load_tipo_documentos(){

    $sql = "SELECT * FROM tipo_documentos ORDER BY tipo asc";
    return find_objects_by_sql($sql);
}

