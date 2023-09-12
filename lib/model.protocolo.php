<?php

/**************************************************************************
 * Geração de um novo código de protocolo
***************************************************************************/
function generate_protocolo(){
    $str = md5(rand()).md5(date("YHms")).md5($_SESSION['username']);
    $str = md5($str);
    $result = date("Ym").'.'.$str;
    return $result;
}

/**************************************************************************
 * Criar novo protocolo
***************************************************************************/
function new_protocolo($id_tipo_beneficio,$cpf = ''){
    try {
        $db = option('db_conn');
        $protocolo = generate_protocolo();
        $username = $_SESSION['username'];

        $stmt = $db->prepare("INSERT INTO protocolo (id_tipo_beneficio, protocolo, id_usuario,cpf, data_criacao) VALUES ( :beneficio, :protocolo, :id_usuario,:cpf, NOW() )");
        $stmt->bindParam(':beneficio', $id_tipo_beneficio);
        $stmt->bindParam(':protocolo', $protocolo);
        $stmt->bindParam(':id_usuario', $username);
        $stmt->bindParam(':cpf', $cpf);

        $result = $stmt->execute();

        $id = $db->lastInsertId();
        if ($result){
            return array('id' => $id, 'protocolo' => $protocolo);
        }else{
            return null;
        }
    }catch (Exception $ex){
        return $ex->getTrace();
    }

}


function getByProtocolo($protocolo){
    $db = option('db_conn');
    $where_condition    = [
        ':protocolo'       => $protocolo
    ];
    $sql = "SELECT * FROM educacao WHERE protocolo = :protocolo";
    $result = find_objects_by_sql($sql, $where_condition);
    return $result;

}

function deleteProtocoloFail($id){
    $db = option('db_conn');

    $where_condition    = [':id' => $id];

    $sql = "delete FROM protocolo WHERE id = :id";
    return find_object_by_sql($sql, $where_condition);
}



function getProtocoloLancamentoReembolso($id){
    $db = option('db_conn');
    $where_condition    = [
        ':id'       => $id
    ];
    $sql = "SELECT protocolo,colaborador FROM educacao WHERE id = :id";
    $result = find_objects_by_sql($sql, $where_condition);
    return $result;

}