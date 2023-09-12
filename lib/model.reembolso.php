<?php

function addSolicitacaoReembolso($obj){
    $db = option('db_conn');


    $sql="INSERT INTO solicitacao
            (
                protocolo_id,
                colaborador,
                colaborador_nome,
                dependente,
                dependente_nome,
                valor,
                competencia,
                status,
                id_folha,
                valor_teto_id,
                valor_disponivel,
                data_cadastro,
                observacao,
                beneficio_tipos_id,
                beneficiario,
                tipo_documento,
                lancamento_contratual_id,
                moeda_id,
                cpf_cnpj_cr
            )
            VALUES (
                     {$obj['protocoloId']},
                     {$obj['colaborador']},
                    '{$obj['colaboradorNome']}', 
                    '{$obj['dependente']}',
                    '{$obj['dependenteNome']}',
                     {$obj['valor']},
                    '{$obj['competenciaReembolso']}',
                    '{$obj['status']}',
                     {$obj['idFolha']},
                     {$obj['valorTetoId']},
                     {$obj['valorDisponivel']},
                    '{$obj['dataCadastro']}',
                    '{$obj['observacao']}',
                     {$obj['beneficioTiposId']},
                     '{$obj['beneficiario']}',
                     {$obj['tipoDocumento']},
                     {$obj['lancamentoContratualId']},
                     {$obj['moedaId']},
                     '{$obj['cpf_cnpj_cr']}'
                    ); 
        ";

    $stmt = $db->prepare($sql);
    $resultado = $stmt->execute();

    /**
     * Pega o ID da solicitação
    */
    $sql = "SELECT MAX(id) AS lastId FROM solicitacao";
    $result = find_object_by_sql($sql);

    return json_encode(array("success" => $resultado, "solicitacaoId"=>$result->lastId));

}


function loadContratoDependentePorBeneficio($cpfRequerente,$idDependente,$idBeneficio) {

    $sql = "SELECT 
                id,total, identificacao_contrato 
            FROM lancamento_contratual
           -- WHERE colaborador = :cpfRequerente AND dependente = :dependente AND beneficio_tipos_id = :idBeneficio
            WHERE dependente = :dependente AND beneficio_tipos_id = :idBeneficio
            ORDER BY total DESC
    ";

   // $result = find_objects_by_sql($sql, array(':cpfRequerente' => $cpfRequerente, ':dependente' => $idDependente, ':idBeneficio' => $idBeneficio));
    $result = find_objects_by_sql($sql, array(':dependente' => $idDependente, ':idBeneficio' => $idBeneficio));

    return empty($result) == false ? $result : '';
}

function get_valor_teto($beneficioId){

    $where_condition    =  [];
    $parse_condition    =  [];

    $where_condition[] = "id_tipo_beneficio = :id";
    $parse_condition[":id"] = $beneficioId;

    $where_condition = implode(" AND ", $where_condition);

    $sql = "SELECT
                *
            FROM valor_teto
            WHERE {$where_condition}
    ";

    return find_object_by_sql($sql, $parse_condition);
}


function salvaComprovanteSolicitacao($files,$solicitacaoId){
    $db_files = option('db_conn_files');
    try{

        ################## FAZENDO UPLOAD DOS ARQUIVOS ##################
        $have_comprovantePagamento  = isset($files['comprovantePagamento']) && !empty($files['comprovantePagamento']['name']) ? true : false;
        $have_boleto                = isset($files['boleto']) && !empty($files['boleto']['name']) ? true : false;
        $have_outros                = isset($files['outros']) && !empty($files['outros']['name']) ? true : false;


        if($have_comprovantePagamento):
            $tmpName_comprovante    = $files['comprovantePagamento']['tmp_name'];
            $fp_comprovante         = base64_encode(file_get_contents($tmpName_comprovante));
            $documento              = $files['comprovantePagamento']['name'];
            $info_do_arquivo        = pathinfo($files['comprovantePagamento']['name']);
            $extensao = $info_do_arquivo['extension'];

            $stmt = $db_files->prepare(
                                        "INSERT INTO upload_anexos 
                                            (conteudo, id_solicitacao,documento,extensao) 
                                        VALUES (:conteudo, :solicitacaoId, :documento,:extensao)");

            $stmt->bindParam(':conteudo', $fp_comprovante, PDO::PARAM_LOB);
            $stmt->bindParam(':solicitacaoId', $solicitacaoId);
            $stmt->bindParam(':documento', $documento);
            $stmt->bindParam(':extensao', $extensao);

            if ( !$stmt->execute() ):
                return json_encode(array("success" => false, "msg" => "ERROR ED0001 Contate o administrador do sistema"));
            endif;
        endif;

        if($have_boleto):
            $tmpName_boleto         = $files['boleto']['tmp_name'];
            $fp_boleto              = base64_encode(file_get_contents($tmpName_boleto));
            $documento              = $files['boleto']['name'];
            $info_do_arquivo = pathinfo($files['boleto']['name']);
            $extensao = $info_do_arquivo['extension'];

            $stmt = $db_files->prepare(
                "INSERT INTO upload_anexos 
                                            (conteudo, id_solicitacao,documento,extensao) 
                                        VALUES (:conteudo, :solicitacaoId, :documento,:extensao)");
            $stmt->bindParam(':conteudo', $fp_boleto, PDO::PARAM_LOB);
            $stmt->bindParam(':solicitacaoId', $solicitacaoId);
            $stmt->bindParam(':documento', $documento);
            $stmt->bindParam(':extensao', $extensao);

            if ( !$stmt->execute() ):
                return json_encode(array("success" => false, "msg" => "ERROR ED0002 Contate o administrador do sistema"));
            endif;

        endif;

        if($have_outros):
            $tmpName_outros         = $files['outros']['tmp_name'];
            $fp_outros              = base64_encode(file_get_contents($tmpName_outros));
            $documento              = $files['outros']['name'];
            $info_do_arquivo = pathinfo($files['outros']['name']);
            $extensao = $info_do_arquivo['extension'];

            $stmt = $db_files->prepare(
                "INSERT INTO upload_anexos 
                                            (conteudo, id_solicitacao,documento,extensao) 
                                        VALUES (:conteudo, :solicitacaoId, :documento,:extensao)");
            $stmt->bindParam(':conteudo', $fp_outros, PDO::PARAM_LOB);
            $stmt->bindParam(':solicitacaoId', $solicitacaoId);
            $stmt->bindParam(':documento', $documento);
            $stmt->bindParam(':extensao', $extensao);
            if ( !$stmt->execute() ):
                return json_encode(array("success" => false, "msg" => "ERROR ED0003 Contate o administrador do sistema"));
            endif;

        endif;

        ################## //FAZENDO UPLOAD DOS ARQUIVOS ##################

    }catch(Exception $e){
        return json_encode(array("success" => false, "msg" => $e->getMessage()));
    }

    return json_encode(array("success" => true, "msg" => "ok"));
}

function load_beneficiarios($idFuncional, $tipoBeneficio = ''){

    $where_condition    =  [];
    $parse_condition    =  [];


    if($tipoBeneficio == "educacao"){
        $where_condition = " a.educacao = 'S'";
    }else{
        $where_condition = " a.saude = 'S'";
    }

    $sql = " SELECT b.cpf, b.nome,b.id_funcional
            FROM beneficiario b
            inner JOIN auxiliado a ON a.dependente = b.cpf 
            WHERE b.id_funcional = '{$idFuncional}' AND {$where_condition}
            
            UNION ALL
            
            SELECT 
                d.cpf, d.nome,d.id_reg
            FROM dependente d
            inner JOIN auxiliado a ON a.dependente = d.cpf 
            WHERE d.id_funcional = '$idFuncional' AND {$where_condition}";

    return find_objects_by_sql($sql);
}