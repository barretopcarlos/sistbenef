<?php

function load_mural($tipo = null, $categoria = null){
    $where = "";
    if (!empty($tipo)) $where =" AND m.id_beneficio_tipos = '$tipo' ";
    if (!empty($categoria)) $where =" AND m.tipo = '$categoria' ";

    $sql = "SELECT 
    m.*,b.beneficio
    FROM mural AS m
    LEFT JOIN beneficio_tipos AS b ON m.id_beneficio_tipos = b.id
    WHERE 1=1
    $where
    ";

    return find_objects_by_sql($sql);
}



function add_mural($obj){
    $db = option('db_conn');
    $msg = '';
    $descricao = $obj['descricao']; 
    $tipoBeneficio = $obj['tipoBeneficio']; 
    $categoria = $obj['categoria']; 
    $id_usuario = $_SESSION['username'];


    $sql="
    INSERT INTO `mural` 
    (`id_beneficio_tipos`, `descricao`, `data_cadastro`, `id_usuario`, `tipo` )
    VALUES
    ('$tipoBeneficio', '$descricao', NOW(), '$id_usuario','$categoria'); ";    
    $stmt = $db->prepare($sql);
    $resultado = $stmt->execute();
    

    return $resultado;

}


function updateMural($id, $obj){
    $db = option('db_conn');
    $msg = '';
    $descricao = $obj['descricao']; 
    $id_usuario = $_SESSION['username'];


    $sql="
    UPDATE `mural` 
    SET descricao='$descricao'
    WHERE id='$id' ";    
    $stmt = $db->prepare($sql);
    $resultado = $stmt->execute();
    

    return $resultado;

}


function deleteMural($id){
    $db = option('db_conn');
    $msg = '';

    $sql="
    DELETE FROM `mural` 
    WHERE id='$id' ";    
    $stmt = $db->prepare($sql);
    $resultado = $stmt->execute();
    

    return $resultado;

}

?>