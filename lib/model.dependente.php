<?php

function get_deficiencia(){
    $sql = "SELECT * FROM deficiencia ORDER BY id";
    return find_objects_by_sql($sql);
}

function get_dependentes($idFuncional){
    
    $sql = "SELECT 
    id, nome 
    FROM dependente
    WHERE id_funcional = $idFuncional
    AND id NOT IN (SELECT id_dependente FROM deficiencia_dependente)";
                                         
   return find_objects_by_sql($sql);
    
}


function add_deficiencia($obj){

    $db = option('db_conn');
    $usuario = $_SESSION['username'];

    $id_dependente = $obj['dependente'];
    $id_deficiencia = $obj['tipoDeficiencia']; 

    $sql="
    INSERT INTO `deficiencia_dependente` 
    (`id_dependente`,  `id_deficiencia`, `cadastrado_por`)
    VALUES
    ('$id_dependente', '$id_deficiencia','$usuario'); ";    
    
    $stmt = $db->prepare($sql);
    $resultado = $stmt->execute();

    return $resultado;

}


function load_deficiencias_dependentes($idFuncional){

    $sql = "SELECT dd.id, dd.id_dependente,de.nome, dd.id_deficiencia,df.descricao,dd.cadastro_deficiencia_data, dd.cadastrado_por
    FROM deficiencia_dependente dd
    INNER JOIN dependente de ON dd.id_dependente = de.id
    INNER JOIN deficiencia df ON dd.id_deficiencia = df.id
    WHERE de.id_funcional = $idFuncional;
    ";
    return find_objects_by_sql($sql);
}


function load_tipos_deficiencias(){

    $sql = "SELECT * FROM deficiencia";
    return find_objects_by_sql($sql);
}


function att_deficiencia($id,$obj) {

    $db = option('db_conn');

    $id = $obj['id'];
    $id_dependente = $obj['modalIdDependente'];
    $id_deficiencia = $obj['modalDeficiencia'];
    $usuario = $_SESSION['username']; 

    $sql = "UPDATE deficiencia_dependente SET id_dependente = '$id_dependente', id_deficiencia = '$id_deficiencia', cadastrado_por = '$usuario' WHERE id = '$id'";
    
    $stmt = $db->prepare($sql);
    $resultado = $stmt->execute();
    return $resultado;
}


function delete_deficiencia($id){
    $db = option('db_conn');

    $where_condition    = [':id' => $id];

    $sql = "delete FROM deficiencia_dependente WHERE id = :id";
    return find_object_by_sql($sql, $where_condition);
}