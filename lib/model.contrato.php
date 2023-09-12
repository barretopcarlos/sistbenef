<?php

function contrato_ja_existe($nome){
    $sql = "SELECT
                *
            FROM contrato
            WHERE ( nome_contrato = :nome )
    ";

    $parse_data = [
        ":nome" =>  $nome
    ];

    $result = find_object_by_sql($sql, $parse_data);
    //print_r($result);die();
    if( count($result) <= 0 ):
        return false;
    else:
        return true;
        return $result->nome_contrato == $nome ? "O nome do contrato já está em uso" : "";
    endif;



}


/*
function cnpj_ja_existe($cnpj){
    return false;
    $sql = "SELECT
                *
            FROM contrato
            WHERE (cnpj_contrato = :cnpj )
    ";

    $parse_data = [
        ":cnpj" => $cnpj
    ];

    $result = find_object_by_sql($sql, $parse_data);

    if( count($result) <= 0 ):
        return false;
    else:
        return true;
    endif;



}
*/

function obterNomeInstituicao($nome)
{
    $sql = "SELECT cnpj_contrato,nome_contrato,internacional FROM contrato WHERE nome_contrato='$nome'";

    return find_objects_by_sql($sql);

}

function get_lancamentos($id = null, $cpf = null){
$where = "";

	if (!empty($id)){
		$where =" AND lc.id = '$id' ";
	}

	if (!empty($cpf)){
		$where =" AND lc.colaborador = '$cpf' ";
	}

    $sql = "SELECT
            lc.id, 
            lc.colaborador, 
            c.id as id_contrato, 
            c.nome_contrato, 
            lc.meses, 
            lc.id_usuario_cadastro, 
            lc.data_cadastro, 
            lc.total, 
            lc.dependente, 
            lc.nome_dependente, 
            lc.identificacao_contrato, 
            DATE_FORMAT(lc.inicio_vigencia,'%d/%m/%Y') as inicio_vigencia, 
            DATE_FORMAT(lc.fim_vigencia,'%d/%m/%Y') as fim_vigencia, 
            lc.arquivo, 
            lc.situacao
            FROM lancamento_contratual as lc
            INNER JOIN contrato as c on lc.id_contrato = c.id
            WHERE situacao = 'ABERTO' 
            AND  (
                fim_vigencia >= CURDATE()
                OR fim_vigencia is NULL
            )
	    $where 
            ORDER BY id desc";

    return find_objects_by_sql($sql);
}


function get_contratos(){
    $sql = "SELECT
                *
            FROM contrato
            ORDER BY nome_contrato
    ";

    return find_objects_by_sql($sql);
}


function add_contrato($obj){
    $username = $_SESSION['username'];
    $data = [
        'nome_contrato' => $obj->nome_contrato,	
        'id_usuario_cadastro' => $username,	
        'cnpj_contrato' => $obj->cnpj_contrato
    ];
    $colunas = array_keys($data);

    $resultado = create_object( (Object) $data, "contrato", $colunas);

}



function edit_contrato($obj){
    $cnpj_contrato = $obj->cnpj_contrato;
    $nome_contrato = $obj->nome_contrato;
    $nomeOriginal = $obj->nomeOriginal;
    $sql = "UPDATE contrato 
    SET  nome_contrato='$nome_contrato'
    WHERE nome_contrato = '$nomeOriginal'";
    return execute($sql);

}

function updateVigenciaContrato($obj){
    $id = $obj['id_contrato'];
    $fim_vigencia = $obj['fim_vigencia_modal'];
    $justificativa = $obj['justificativa_modal'];


    $sql = "UPDATE lancamento_contratual
    SET  fim_vigencia='$fim_vigencia',
    justificativa = '$justificativa'
    WHERE id = '$id'";

    return execute($sql);

}


function updateLancamentoContratual($obj){
    $objeto = $obj['educacao'];	

    $id = $objeto['id'];
    $beneficiario = $objeto['beneficiario'];	
    $tmpDendente = $objeto['dependente'];
    $tmpDendente = explode("_",$tmpDendente);		
    $dependente = $tmpDendente[0];	
    $nomeDependente = $tmpDendente[1];	
    $total = $objeto['total'];	
    $idInstituicao = $objeto['contrato'];
    $identificacaoContrato = $objeto['identificacao_contrato'];
    $inicioVigencia = $objeto['inicio_vigencia'];
    $fimVigencia = $objeto['fim_vigencia'];
    

    $sql = "UPDATE lancamento_contratual
    SET 
    colaborador = '$beneficiario',
    id_contrato = '$idInstituicao',
    total = '$total',
    dependente = '$dependente',
    nome_dependente = '$nomeDependente',
    identificacao_contrato = '$identificacaoContrato',
    inicio_vigencia='$inicioVigencia',
    fim_vigencia='$fimVigencia'
    WHERE id = '$id'";

    return execute($sql);

}




function deleteLancamentoContratual($id){
    
    $sql = "UPDATE lancamento_contratual
    SET situacao = 'DELETADO'
    WHERE id = '$id'";

    return execute($sql);

}




function addLancamentoContratual($obj){
    $beneficiario   = $obj->beneficiario;
    $id_contrato    = $obj->contrato;
    $total          = $obj->total;
    $infoDependente          = explode('_',$obj->dependente);
    $dependente = $infoDependente[0];
    $nome_dependente = $infoDependente[1];
    $identificacao_contrato          = $obj->identificacao_contrato;
    $inicio_vigencia          = $obj->inicio_vigencia;
    $fim_vigencia          = $obj->fim_vigencia;
    $id_usuario_cadastro = $_SESSION['username'];

    $meses = 0;

    try{
        $Ei = explode('-', $inicio_vigencia);
        //$Ef = explode('-', $fim_vigencia);
        $date1 = date_create("{$Ei[0]}-{$Ei[1]}-01");
        $date2 = date_create($fim_vigencia);
        $diff1 = date_diff($date1,$date2);
        $daysdiff = $diff1->format("%R%a");
        $meses = round($daysdiff / 30);
    }catch(Exception $e){}
    

    $formatDate = date("Ymd");
    $target_file = "contrato_teste_{$formatDate}.pdf";
        
    $data = [
        "colaborador"            => $beneficiario,
        "id_contrato"            => $id_contrato,
        "meses"                  => $meses,
        "id_usuario_cadastro"    => $id_usuario_cadastro,
        "total"                  => $total,
        "dependente"             => $dependente,
        "nome_dependente"        => $nome_dependente,
        "identificacao_contrato" => $identificacao_contrato,
        "inicio_vigencia"        => $inicio_vigencia,
        "fim_vigencia"          => $fim_vigencia,
        "arquivo"                => $target_file
    ];
    $colunas            = array_keys($data);


    $id_gerado_contrato = create_object( (Object) $data, "lancamento_contratual", $colunas);

    if ($id_gerado_contrato > 0 )
    {
       


        create_lancamento_files($_FILES["arquivo"],$id_gerado_contrato);

    }
    
/*
    $competencias   = $obj->competencia;
    $valores        = $obj->valor;
    $dependentes    = $obj->dependente;
    $repeat         = 0;
    forEach( $competencias AS $index => $comp ):

        $repeat++;
        $comp   = $comp;
        $valor  = $valores[$index];
        $depen  = $dependentes[$index];
        $depen  = explode(",", $depen);

            forEach( $depen AS $index_depens => $dependente_atual ):
                $data = [
                    "id_lancamento_contratual"  => $id_gerado_contrato,
                    "colaborador"               => $beneficiario,
                    "dependente"                => $dependente_atual,
                    "competencia"               => $comp,
                    "valor"                     => $valor,
                    "mes_relacao"               => $repeat
                ];
                $colunas = array_keys($data);
                create_object( (Object) $data, "registro_lancamento_contratual", $colunas);
            endforeach;
    endforeach;
    */
}



function editLancamentoContratual($obj){
	die($obj);
}


/*
Obter valor da mensalidade por dependente / contrato de ensino
*/
function getValoresByContrato($obj){
    $sql = "SELECT
                lancamento_contratual.*,
                total
            FROM lancamento_contratual
            WHERE dependente = :DEPENDENTE 
            AND (
                :COMP >= inicio_vigencia
                    OR (
                        MONTH(:COMP)=MONTH(inicio_vigencia) AND
                        YEAR(:COMP)=YEAR(inicio_vigencia)
                    )
                AND	
                LAST_DAY(:COMP) <= fim_vigencia
            )
            
    ";

    $parse_data = [
        ":DEPENDENTE"   => $obj->dependente,
        ":COMP"         => $obj->comp . '-01'
    ];

    return find_objects_by_sql($sql, $parse_data);
}


function verifica_lancamento_ja_existe($dependente, $comp, $colaborador, $id_contrato){
    $sql = "SELECT 
                A.* 
            FROM registro_lancamento_contratual A
            INNER JOIN lancamento_contratual AS B ON B.id = A.id_lancamento_contratual
            WHERE A.dependente = :dependente AND A.competencia = :comp AND A.colaborador = :colaborador AND B.id_contrato = :id_contrato
    ";
    $parsed_data = [
        ":dependente"   => $dependente,
        ":comp"         => $comp,
        ":colaborador"  => $colaborador,
        ":id_contrato"  => $id_contrato
    ];

    $result = find_objects_by_sql($sql, $parsed_data);

    return count($result) > 0 ? true : false;


}

function encerrarContrato($id)
{

    return update_object((object) array("id" => $id , "situacao" => "FECHADO"), "lancamento_contratual", array("situacao"));

}



/*
    Verificar vigÊncia de contrato por dependente
*/
function verifica_vigencia_dependente($dependente, $contrato){
$retorno = false;

    if (!empty($dependente) && !empty($contrato))
    {
        $where = " AND dependente='$dependente' 
        AND identificacao_contrato='$contrato' ";
    }


    $sql = "SELECT
                *
            FROM lancamento_contratual
            WHERE situacao = 'ABERTO' 
            AND  (
                fim_vigencia >= CURDATE()
                OR fim_vigencia is NULL
            )
        $where    
    ";

    $resposta =  find_objects_by_sql($sql);

    if (!empty($resposta)) $retorno = true;

    return $retorno;
}


function VerificarContratoVigentePorCompetencia($dependente,$competencia){

    $sql = "SELECT * FROM lancamento_contratual
    WHERE dependente='$dependente'
    AND (
    '$competencia-01' >= inicio_vigencia
        OR (
        MONTH('$competencia-01')=MONTH(inicio_vigencia) AND
        YEAR('$competencia-01')=YEAR(inicio_vigencia)
        )
    AND	
    LAST_DAY('$competencia-01') <= fim_vigencia
    )";

    $resposta =  find_objects_by_sql($sql);

    return $resposta;
}    

?>