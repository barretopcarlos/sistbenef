<?php

function saveNotify($obj){
    $db = option('db_conn');
    $destinatario = $obj['destinatario'];
    $assunto = $obj['assunto'];
    $justificativa = $obj['justificativa'];
    $descricao = $obj['mensagem'];
    $remetente = $_SESSION['username'];
    
    $id_resposta = $obj['id_resposta'];
    $respondido_por =  $_SESSION['username'];

    if ($_SESSION['perfil']=='analista') $remetente = '0';


    if ($id_resposta > 0)
    {
        $sql="
        INSERT INTO `notificacao` 
        (`remetente`, `destinatario`, `assunto`, `descricao` , `justificativa`, `enviado_em`, `id_resposta`, `respondido_em`, `respondido_por` )
        VALUES
        ('$remetente', '$destinatario', '$assunto', '$descricao' , '$justificativa', NOW(),'$id_resposta', NOW(), '$respondido_por' ); ";    
    
    }else{
        $sql="
        INSERT INTO `notificacao` 
        (`remetente`, `destinatario`, `assunto`, `descricao` , `justificativa`, `enviado_em` )
        VALUES
        ('$remetente', '$destinatario', '$assunto', '$descricao' , '$justificativa', NOW() ); ";    
    
    }


    $stmt = $db->prepare($sql);
    $resultado = $stmt->execute();
    return $db->lastInsertId();


}


function saveNotifyFile($id_notificacao, $obj){
    $db = option('db_conn_files');


    $tmpName_file = $obj['file-input']['tmp_name'];
    $conteudo = base64_encode(file_get_contents($tmpName_file));  
    $Name_file         = $obj['file-input']['name'];
    $path_parts = pathinfo($Name_file);
    $extensao = $path_parts['extension'];
    
            //if( !empty($conteudo) ){
                $stmt = $db->prepare("INSERT INTO upload_notificacao (conteudo, extensao, id_notificacao) VALUES ( :conteudo, :extensao, :id_notificacao )");
                $stmt->bindParam(':conteudo', $conteudo, PDO::PARAM_LOB);
                $stmt->bindParam(':extensao', $extensao);  
                $stmt->bindParam(':id_notificacao', $id_notificacao);  
                $stmt->execute() ;
              ///  if ( !$stmt->execute() ){
                 //   $msg .= "ERROR ED0004 Contate o administrador do sistema";
                    
                //}
            //}
}

function load_notificacoes($categoria = '',$params = null){
    $remetente = $_SESSION['username'];
    $where = "";

    if ($categoria == 'enviados')
    {
        $where = " AND remetente='$remetente' and destinatario='0'";
    }elseif ($categoria == 'lidas'){
        $where = " AND (remetente='0' or destinatario='$remetente') and lido='S' ";
    }elseif ($categoria == 'naolidas'){
        $where = " AND (remetente='0' or destinatario='$remetente') and lido='N' ";

    }elseif ($categoria == 'entrada'){
        $where = " AND (remetente='0' and destinatario='$remetente') ";

    }

    if (!empty($params['assuntoEmail']))
    {
        $where .= " AND assunto like '%{$params['assuntoEmail']}%' ";
    }

    if (!empty($params['dataEmail']))
    {
        $where .= " AND (DATE_FORMAT(enviado_em,'%Y-%m-%d') = '{$params['dataEmail']}' OR  DATE_FORMAT(respondido_em,'%Y-%m-%d') = '{$params['dataEmail']}')";
    }

    $sql = "SELECT 
    *, date_format(enviado_em,'%d/%m/%Y %H:%i') as enviado_em,
    SUBSTR(descricao,1,30) as descricao,
    IF (LENGTH(descricao)>30,'...','') AS continuacao,
    IF (LENGTH(justificativa)>30,'...','') AS continuacao_justificativa

    FROM notificacao
    WHERE 1=1
    $where
    ORDER BY id DESC
    ";

    return find_objects_by_sql($sql);

}



function details_notify($id = 0){
    $remetente = $_SESSION['username'];
    $where = "";

    $sql = "SELECT 
    *, date_format(enviado_em,'%d/%m/%Y %H:%i') as enviado_em
    FROM notificacao
    WHERE id='$id'
    AND (remetente='$remetente' OR destinatario='$remetente')";

    return find_objects_by_sql($sql);

}


function details_notify_replys($id = 0){
    $remetente = $_SESSION['username'];
    $where = "";

    $sql = "SELECT 
    *, date_format(enviado_em,'%d/%m/%Y %H:%i') as enviado_em
    , date_format(respondido_em,'%d/%m/%Y %H:%i') as respondido_em
    FROM notificacao
    WHERE id_resposta='$id'
    AND (remetente='$remetente' OR destinatario='$remetente')";

    return find_objects_by_sql($sql);

}


function details_notify_file($id = 0){

    $sql = "SELECT 
    *
    FROM upload_notificacao
    WHERE id_notificacao='$id'";

    return find_objects_by_sql_files($sql);

}
function novasNotificacoes(){
    $remetente = $_SESSION['username'];
    $where = "";

    $sql = "SELECT count(*) as novas
    FROM notificacao
    WHERE destinatario='$remetente'
    and lido='N'
    ORDER BY id DESC";

    return find_objects_by_sql($sql);

}


function verificaSeFoiLida($id){
    $destinatario = $_SESSION['username'];

    $sql = "SELECT lido,destinatario
    FROM notificacao
    WHERE destinatario='$destinatario'
    and id='$id'";

    return find_objects_by_sql($sql);

}


function notificacao_lida($id=''){
    $db = option('db_conn');
    $destinatario = $_SESSION['username'];

    $sql="UPDATE notificacao
    SET lido='S' 
    WHERE id='$id' 
    AND destinatario='$destinatario' ";    
    $stmt = $db->prepare($sql);
    $resultado = $stmt->execute();
    
    return $resultado;
}


function loadDatasNotificacao(){
    $db = option('db_conn');
    $usuario = $_SESSION['username'];
    
    $sql="SELECT DISTINCT 
    DATE_FORMAT(enviado_em,'%Y-%m-%d') AS dt,
    DATE_FORMAT(enviado_em,'%d-%m-%Y') AS dtFormatada
    FROM notificacao
    WHERE (remetente='$usuario' OR destinatario='$usuario')
    AND enviado_em IS NOT NULL
    UNION
    SELECT DISTINCT 
    DATE_FORMAT(respondido_em,'%Y-%m-%d') AS dt,
    DATE_FORMAT(respondido_em,'%d-%m-%Y') AS dtFormatada
    FROM notificacao
    WHERE (remetente='$usuario' OR destinatario='$usuario')
    AND respondido_em IS NOT NULL
    ";


return find_objects_by_sql($sql);
}



?>