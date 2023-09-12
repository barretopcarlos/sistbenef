<?php

function loadFuncionarios($cpf='') {
    if (!empty($cpf))
    {
        //ve apenas a respeito do seu perfil
        $jsonurl      = BASEURL_RH."/?/funcionario/listBeneficiario/$cpf";    

    }else{
        $jsonurl      = BASEURL_RH."/?/funcionario/listAll";    
    }

    $json         = file_get_contents($jsonurl);
    $jsonDecode     = json_decode($json, false);

    return $jsonDecode;       
}

function loadDependentes($id) {
    $jsonurl        = BASEURL_RH."/?/funcionario/listAllDepend/".$id;    
    $json           = file_get_contents($jsonurl);
    $jsonDecode     = json_decode($json, false);
        return $jsonDecode;    
}


function getContaBancaria($cpf=''){
    $jsonurl      = BASEURL_RH."/?/funcionario/loadConta/$cpf";    
    $json         = file_get_contents($jsonurl);
    $jsonDecode     = json_decode($json, false);
    return $jsonDecode;       

}

function getEstadoCivil($cpf=''){
    $jsonurl      = BASEURL_RH."/?/funcionario/loadEstadoCivil/$cpf";    
    $json         = file_get_contents($jsonurl);
    $jsonDecode     = json_decode($json, false);
    return $jsonDecode;       

}


function getNomeDependente($id) {
    $sql = "SELECT 
        nome_dependente
    FROM lancamento_contratual
    WHERE dependente = :id
    LIMIT 1
    ";


    $result = find_objects_by_sql($sql, array(':id' => $id));
    return $result[0];
}

function loadContratosDependente($dependenteId) {
    $sql = "SELECT 
                conteudo 
            FROM upload_educacao_{$tipo}
            WHERE id_educacao = :id
            ORDER BY id DESC
            LIMIT 1
    ";

    $result = find_objects_by_sql_files($sql, array(':id' => $id));
    $jsonDecode     = json_decode($result[0], false);
        return $jsonDecode;    
}

function loadPdf($id, $tipo) {

    $sql = "SELECT 
                conteudo 
            FROM upload_{$tipo}
            WHERE id_educacao = :id
            ORDER BY id DESC
            LIMIT 1
    ";

    $result = find_objects_by_sql_files($sql, array(':id' => $id));
    return $result;
    
}
   


function loadFile($id, $tipo) {

    $sql = "SELECT 
                * 
            FROM upload_{$tipo}
            WHERE id_educacao = :id
            ORDER BY id DESC
            LIMIT 1
    ";

    $result = find_objects_by_sql_files($sql, array(':id' => $id));
    return $result;
    
}
    
function updateStatus($id,$status) {   
     return update_object((object) array("id" => $id , "status" => $status), "educacao", array("status"));
    
}

function createHistoryStatus($id,$status,$observacao) {   
     return create_object((object) array("id_educacao"=>$id,"status" => $status , "observacao" => $observacao , "data_registro"=> date('Y-m-d H:i:s')), 
             "educacao_historico_status", array("id_educacao","status","observacao","data_registro"));
    
} 


function create_education_obj($education_data) {
    return create_object($education_data, 'educacao', add_columns());
}

function create_education_objs($education_data,$education_files, $aplicarFormatoMoeda = true) {  

    if ($aplicarFormatoMoeda){
        foreach ($education_data->valor as $k=>$v)
        $education_data->valor[$k] = moeda($v);

        foreach ($education_data->valor_disponivel as $k=>$v)
            $education_data->valor_disponivel[$k] = moeda($v);
    }
    

    return create_objects($education_data, 'educacao', add_columns_all()
            ,$education_files,$education_data->valor);// ultima variavel count insert
}

function edit_education_obj($education_data, $education_data_files){
    $data_search    = listEducationForEdit($education_data->idd_registro);
    $msg            = '';
    
    try{

        if( empty($data_search) ):
            throw new Exception("O lançamento não foi encontrado");
        endif;

        if( $data_search->status_folha_pagamento != "aberto" ):
            throw new Exception("Não foi possível editar pois a folha de benefício do lançamento não está  mais aberta!");
        endif;

        if( !verifica_valor_disponivel_valor_solicitado($data_search->colaborador, $data_search->competencia, $education_data->valor, $education_data->idd_registro) ):
            throw new Exception("O valor excede o limite mensal!");
        endif;
    
        ################## SALVADO O HISTÓRICO ##################
            $valores = [
                'id_educacao'   => $education_data->idd_registro,
                'observacao'    => $education_data->observacao,
                'valor_antigo'  => $data_search->valor,
                'valor_novo'    => $education_data->valor
            ];
            $chaves = array_keys($valores);
            create_object( (Object) $valores, 'educacao_historico_alteracao_valor', $chaves);
        ################## //SALVADO O HISTÓRICO ##################
    
        ################## ATUALIZANDO O REQUERIMENTO ##################
            $data_to_update = [
                "id"    => $education_data->idd_registro,
                "valor" => moeda($education_data->valor)
            ];
            $result = update_object( (Object) $data_to_update, 'educacao', ['valor']);
        ################## //ATUALIZANDO O REQUERIMENTO ##################
    
        ################## FAZENDO UPLOAD DOS ARQUIVOS ##################
            $have_boleto        = isset($education_data_files->name['boleto']) && !empty($education_data_files->name['boleto']) ? true : false;
            $have_comprovante   = isset($education_data_files->name['comprovante']) && !empty($education_data_files->name['comprovante']) ? true : false;
            $have_outros        = isset($education_data_files->name['outros']) && !empty($education_data_files->name['outros']) ? true : false;
    
            if( $have_boleto || $have_comprovante || $have_outros ):
                $db_files = option('db_conn_files');
    
                if( $have_boleto ):
                    $tmpName_boleto         = $education_data_files->tmp_name['boleto'];  
                    $fp_boleto              = base64_encode(file_get_contents($tmpName_boleto)); 
    
                    $stmt                   = $db_files->prepare("INSERT INTO upload_educacao_boletos (conteudo, id_educacao) VALUES ( :boleto, :id_metadada )");
                    $stmt->bindParam(':boleto', $fp_boleto, PDO::PARAM_LOB);
                    $stmt->bindParam(':id_metadada', $education_data->idd_registro);  
                    if ( !$stmt->execute() ):
                        throw new Exception("ERROR ED0002 Contate o administrador do sistema");
                    endif;   
                endif;
        
                if( $have_comprovante ):
                    $tmpName_comprovante    = $education_data_files->tmp_name['comprovante'];
                    $fp_comprovante         = base64_encode(file_get_contents($tmpName_comprovante));

                    $stmt = $db_files->prepare("INSERT INTO upload_educacao_comprovantes (conteudo, id_educacao) VALUES ( :comprovante, :id_metadada )");
                    $stmt->bindParam(':comprovante', $fp_comprovante, PDO::PARAM_LOB);
                    $stmt->bindParam(':id_metadada', $education_data->idd_registro);  
                    if ( !$stmt->execute() ):
                        throw new Exception("ERROR ED0003 Contate o administrador do sistema");
                    endif;
                endif;
        
                if( $have_outros ):
                    $tmpName_outros         = $education_data_files->tmp_name['outros'];
                    $fp_outros              = base64_encode(file_get_contents($tmpName_outros));

                    $stmt = $db_files->prepare("INSERT INTO upload_educacao_outros (conteudo, id_educacao) VALUES ( :outros, :id_metadada )");
                    $stmt->bindParam(':outros', $fp_outros, PDO::PARAM_LOB);
                    $stmt->bindParam(':id_metadada', $education_data->idd_registro);  
                    if ( !$stmt->execute() ):
                        throw new Exception("ERROR ED0003 Contate o administrador do sistema");
                    endif;
                endif;
            endif;

        ################## //FAZENDO UPLOAD DOS ARQUIVOS ##################

        $msg = "ok";
    }catch(Exception $e){
        $msg = $e->getMessage();
    }

    return $msg;
}

function load_historico_alteracoes_education($id_education){
    $sql = "SELECT
                observacao, 
                valor_antigo, 
                valor_novo, 
                data_registro,
                'valor' AS tipo
            FROM educacao_historico_alteracao_valor
            WHERE id_educacao = :id_education
                UNION
            SELECT
                observacao,
                '' AS valor_antigo,
                status AS valor_novo,
                data_registro,
                'status' AS tipo
            FROM educacao_historico_status
            WHERE id_educacao = :id_education
            ORDER BY data_registro DESC
    ";

    return find_objects_by_sql($sql, [ ':id_education'   => $id_education]);
    
}


function create_education_obj_files($education_files = array(),$education_data = array()) {
    return create_object_files($education_files, 
            create_education_obj($education_data));
}


function listEducationConsolidated() {    
    return find_objects_by_sql("SELECT sum(valor) as valor,colaborador , colaborador_nome , competencia ,status
FROM beneficios.educacao group by competencia, colaborador ,status");
     
}

function listEducation($status = '') {   
$where = '';

    if (!empty($status))
    {
        $where = " WHERE folha_pagamento.status = '$status' ";
    }else{
        $where = " WHERE folha_pagamento.status <> 'fechado' ";  
    }

    $sql = "SELECT 
                educacao.*,
                (
                    SELECT
                        COUNT(educacao_historico_alteracao_valor.id)
                FROM educacao_historico_alteracao_valor
                    WHERE educacao_historico_alteracao_valor.id_educacao = educacao.id
                ) AS qtd_alteracoes_valor,
                
                (
                        SELECT
                            COUNT(educacao_historico_status.id)
                        FROM educacao_historico_status
                        WHERE educacao_historico_status.id_educacao = educacao.id
                )AS qtd_alteracoes_status,
                folha_pagamento.status AS status_folha, folha_pagamento.tipo_folha
            FROM educacao
            LEFT JOIN folha_pagamento ON folha_pagamento.id = educacao.id_folha
            $where
            ORDER BY educacao.id desc";

    return find_objects_by_sql($sql);
     
}

function listEducationComp($comp='' , $status = '', $status_folha = '') {
    
    $where_condition = '';

    if( !empty($comp) ){
        $where_condition = " AND educacao.competencia = '$comp' ";
    }

    if( !empty($status) ){
        $where_condition.= " AND  educacao.status = '$status' ";
    }

    if( !empty($status_folha) ){
        $where_condition.= " AND  folha_pagamento.status = '$status_folha' ";
    }else{
        $where_condition.= " AND  folha_pagamento.status <> 'fechado' ";
    }

    $sql = "SELECT 
                educacao.*,
                (
                    SELECT
                        COUNT(educacao_historico_alteracao_valor.id)
                FROM educacao_historico_alteracao_valor
                    WHERE educacao_historico_alteracao_valor.id_educacao = educacao.id
                ) AS qtd_alteracoes_valor,
                
                (
                        SELECT
                            COUNT(educacao_historico_status.id)
                        FROM educacao_historico_status
                        WHERE educacao_historico_status.id_educacao = educacao.id
                )AS qtd_alteracoes_status,
                folha_pagamento.status AS status_folha, folha_pagamento.tipo_folha
            FROM educacao
            LEFT JOIN folha_pagamento ON folha_pagamento.id = educacao.id_folha
            WHERE 1=1 
            {$where_condition}
            ORDER BY educacao.id desc
    ";

    
     return find_objects_by_sql($sql);    
}

function listCompetence() {
    return find_objects_by_sql("SELECT distinct (competencia)FROM educacao;");
}

function listStatus(){
    return find_objects_by_sql("SELECT DISTINCT(status) FROM educacao;");
}

function listEducationForEdit($id){
    $sql                = "SELECT
                               A.*,
                                (
                                    SELECT 
                                        B.observacao
                                    FROM educacao_historico_alteracao_valor B
                                    WHERE B.id_educacao = A.id
                                    ORDER BY B.id DESC
                                    LIMIT 1
                                ) AS observacao_ultima_edicao,
                                B.status AS status_folha_pagamento
                            FROM educacao A
                            INNER JOIN folha_pagamento AS B ON B.id = A.id_folha
                            WHERE A.id = :id AND  ( A.status <> 'deferido' OR A.status IS NULL )
    ";
    $where_condition    = [
        ':id'       => $id
    ];

    $data = find_object_by_sql($sql, $where_condition);

    return $data;
}

function make_author_objj($params, $obj = null) {
    return make_model_object($params, $obj);
}

function add_columns() {
    return array('colaborador','valor','dependente','colaborador_nome','competencia', 'id_folha','protocolo');
}

function add_columns_all() {
    return array('valor','competencia','dependente','colaborador_nome','colaborador', 'id_folha', 'valor_disponivel', 'id_valor_teto','protocolo');
}

function phpAlert($msg) {
    echo '<script defer>Swal.fire(" ", "' . $msg . '")</script>';
}

function moeda($get_valor) {
        $source     = array('.', ',');
        $replace    = array('', '.');
        $valor      = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
        return $valor; //retorna o valor formatado para gravar no banco
}


function get_valor_maximo_allowed(){

    $sql = "SELECT
                valor
            FROM valor_teto
            WHERE id_tipo_beneficio='1'
            ORDER BY id DESC
            LIMIT 1
    ";
    $resultado = find_object_by_sql($sql);
    $resultado = !empty($resultado) ? $resultado->valor : 0;

    return (float) $resultado;

}

function get_id_teto_atual(){
     $sql = "SELECT
                id
            FROM valor_teto
            WHERE id_tipo_beneficio='1'
            ORDER BY id DESC
            LIMIT 1
    ";
    $resultado = find_object_by_sql($sql);
    $resultado = !empty($resultado) ? $resultado->id : 0;
    
    return $resultado;
}

function get_infos_teto_atual($tipo=''){
     $sql = "SELECT
                id,
                valor,
                data_cadastro,
                'ok' AS status
            FROM valor_teto
            WHERE id_tipo_beneficio='$tipo'
            ORDER BY id DESC
            LIMIT 1
    ";
    $resultado = find_object_by_sql($sql);
    $resultado = !empty($resultado) ? $resultado : (Object) [ 'status' => 'Não existe folha teto disponível' ];
    
    return $resultado;
}

function verifica_valor_maximo_dependentes($id_colaborador, $comp){

    $sql = "SELECT
                SUM(valor) AS valor_total
            FROM educacao
            WHERE colaborador = :numero_colaborador AND competencia = :comp
    ";
    $where_condition = [
        ":numero_colaborador"   => $id_colaborador,
        ":comp"                 => $comp
    ];

    $data                           = find_object_by_sql($sql, $where_condition);
    $valor_total                    = (float) $data->valor_total;
    
    $valor_maximo_allowed           = get_valor_maximo_allowed();
    return ($valor_total >= $valor_maximo_allowed ) ? false : true;

}

function verifica_valor_disponivel_valor_solicitado($id_colaborador, $comp, $valor_solicitado, $id = ''){


    $conditions = [
        "colaborador = :numero_colaborador", 
        "competencia = :comp"
    ];

    $condition_parse = [
        ":numero_colaborador"   => $id_colaborador,
        ":comp"                 => $comp
    ];

    if( !empty($id) ):
        $conditions[] = " id != :id";
        $condition_parse[":id"] = $id;
    endif;

    
    $conditions = implode( " AND ", $conditions);
    $sql = "SELECT
                SUM(valor) AS valor_total
            FROM educacao
            WHERE $conditions
    ";

    $data                           = find_object_by_sql($sql, $condition_parse);
    $valor_total                    = (float) $data->valor_total;
    $valor_solicitado               = (float) moeda($valor_solicitado);
    $valor_maximo_allowed           = get_valor_maximo_allowed();
    return ( ($valor_total + $valor_solicitado) > $valor_maximo_allowed ) ? false : true;

}


function requerimento_no_prazo(){
    $data = (int) date("d");
    return $data >= 20 ? false : true;
}

function add_valor_teto($obj){
    $data = [
        "valor" => moeda($obj->valor_teto),
        "id_usuario" => $_SESSION['username'],
        "id_tipo_beneficio" => $obj->tipoBeneficio
    ];
    $colunas = array_keys($data);
    $resultado = create_object( (Object) $data, "valor_teto", $colunas, true);
    create_object( (Object) $data, "historico_valor_teto", $colunas);
    return $resultado;

}


function get_valor_dependente($obj){

    $data = [
        'status'    => '',
        'msg'       => '',
        'valor'     => 0
    ];

    $obj = (Object) $obj;

    try{

        if( !isset($obj->nome) || empty($obj->nome) ):
            throw new Exception("É necessário enviar o dependente!");
        endif;

        if( !isset($obj->comp) || empty($obj->comp) ):
            throw new Exception("É necessário enviar a competência!");
        endif;
        
        if( !isset($obj->valor_enviado) ):
            throw new Exception("Houve um problema interno!");
        endif;

        if( !isset($obj->cpf_colaborador) || empty($obj->cpf_colaborador) ):
            throw new Exception("Houve um problema interno! Cod. 02");
        endif;

        if( !isset($obj->valor_folha) || empty($obj->valor_folha) ):
            throw new Exception("Houve um problema interno! Cod. 03");
        endif;
        
    
    
        $sql = "SELECT
                    valor
                FROM educacao
                WHERE dependente = :dependente AND competencia = :competencia AND colaborador = :colaborador
        ";
        $parsed_data = [
            ":dependente"   => $obj->nome,
            ":competencia"  => $obj->comp,
            ":colaborador"  => $obj->cpf_colaborador
        ];
    
        $result = find_objects_by_sql($sql, $parsed_data);
    
        $valor  = 0;
    
            forEach( $result AS $resultado ):
                $valor += $resultado->valor;
            endforeach;
        
        // $teto_atual         = get_valor_maximo_allowed();
        $teto_atual = moeda($obj->valor_folha);

        $obj->valor_enviado = moeda($obj->valor_enviado);
        $valor              = $teto_atual - ($valor + $obj->valor_enviado);
        $valor              = number_format($valor, 2, ',', '.' );

        $data['status']     = 'ok';
        $data['valor']      = $valor;
    }catch(Exception $e){
        $data['status'] = 'error';
        $data['msg']    = $e->getMessage();
    }


    return $data;

}


function get_valor_teto_by_comp($obj){
    $ano = $obj->ano;
    $mes = $obj->mes;
    $tipo = $obj->tipo;

    $sql = "SELECT
                id,
                valor,
                data_cadastro,
                'ok' AS status
            FROM historico_valor_teto 
            WHERE 
                YEAR(data_cadastro) <= :ANO
                AND MONTH (data_cadastro) <= :MES
                AND id_tipo_beneficio = :TIPO
            ORDER BY id DESC
            LIMIT 1
    ";
    $params = [
        ":ANO"  => $ano,
        ":MES"  => $mes,
        ":TIPO"  => $tipo
    ];
    $result = find_object_by_sql($sql, $params);

    if( empty($result) ):
        $result = get_infos_teto_atual('1');
    endif;

    if( isset($result->data_cadastro) ):
        $result->data_cadastro = date("d/m/Y", strtotime($result->data_cadastro));
    endif;

    if( isset($result->valor) ):
        $result->valor =number_format($result->valor, 2, ',', '.' );
    endif;

    return $result;
}




function getCpfPorLoginRede($login_rede) {
    $sql = "SELECT 
        cpf,id_funcional
    FROM complementar
    WHERE login_rede = :login_rede";


    $result = find_objects_by_sql($sql, array(':login_rede' => $login_rede));
    return $result;
}


function getLoginRedePorCpf($cpf) {
    $sql = "SELECT 
        login_rede,id_funcional
    FROM complementar
    WHERE LPAD(cpf,11,'0') = :cpf";


    $result = find_objects_by_sql($sql, array(':cpf' => $cpf));
    return $result;
}

function updateLoginRedeBeneficiario($loginRede, $cpf){
    $sql = "UPDATE complementar 
    SET  login_rede='$loginRede'
    WHERE LPAD(cpf,11,'0') = '$cpf'";
    return execute($sql);
}



function getDadosBeneficiario($loginRede){
    $sql = "SELECT 
        b.*,
        x.cargo,x.vinculo,x.status,
        LPAD(b.cpf,11,'0') as cpf
    FROM complementar as b
    INNER JOIN beneficiario as x ON x.cpf = b.cpf 
    WHERE b.login_rede = :loginRede";


    $result = find_objects_by_sql($sql, array(':loginRede' => $loginRede));
    return $result;
}




function getDadosDependentes($idFuncional){
    $sql = "SELECT 
    DE.*,AX.educacao as auxilio_educacao
    FROM dependente as DE
    INNER JOIN auxiliado AS AX ON DE.id_reg = AX.dependente  
    WHERE DE.id_funcional = :idFuncional";


    $result = find_objects_by_sql($sql, array(':idFuncional' => $idFuncional));
    return $result;
}