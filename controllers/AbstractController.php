<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AbstractController
 *
 * @author santosml
 */
abstract class AbstractController {

    function serveAsJson($subject){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        return json($subject);
    }

    function extractModelFromForm($subject) {
        return (isset($_POST[$subject]) && is_array($_POST[$subject])) ? $_POST[$subject] : array();
    }
    
    function education_data_from_form_all_post() {
    return $_POST;
    }
    
    function education_data_from_form_all_get() {
    return $_GET;
    }
    
    function education_data_from_form() {
     return isset($_POST['educacao']) && is_array($_POST['educacao']) ? $_POST['educacao'] : array();
    }

    function education_files_from_form() {
        return isset($_FILES['educacao']) && is_array($_FILES['educacao']) ? $_FILES['educacao'] : array();
    }

    function education_create_all_validators($education_data){


        if( empty( $education_data['colaborador'][0] ) ):
            throw new Exception("Houve um problema interno!");
        endif;

        if( empty( $education_data['id_folha'] ) ):
            throw new Exception("É necessárior a folha de Benefício!");
        endif;

        if( empty( $education_data['competencia'] ) ):
            throw new Exception("É necessário enviar as competências!");
        else:
            $education_data['competencia'] = array_filter($education_data['competencia']);
            if( count($education_data['competencia']) <= 0 ):
                throw new Exception("É necessário enviar as competências!!");
            endif;
        endif;

        if( empty( $education_data['valor'] ) ):
            throw new Exception("É necessário enviar os valores!");
        else:   
            $education_data['valor'] = array_filter($education_data['valor']);
            if( count($education_data['valor']) <= 0 ):
                throw new Exception("É necessário enviar os valores!!");
            endif;
        endif;

        // if( !requerimento_no_prazo() ):
            // if( empty( $education_data['justificativa'] ) ):
            //     throw new Exception("Após o dia 20, é necessário enviar justificativa!");
            // endif;
        // endif;

        // $valores_per_comp = [];
        //     forEach( $education_data['competencia'] AS $index => $comp ):

        //         if( !verifica_valor_maximo_dependentes($education_data['colaborador'][0], $comp) ):
        //             throw new Exception("O colaborador não possui mais saldo para a competência de {$comp}");
        //         endif;

        //         $valor_by_comp = (float) moeda($education_data['valor'][$index]);
        //         if( isset($valores_per_comp[$comp]) ):
        //             $valores_per_comp[$comp] += $valor_by_comp;
        //         else:
        //             $valores_per_comp[$comp] = $valor_by_comp;
        //         endif;
            
        //     endforeach;

        //     forEach( $valores_per_comp AS $comp => $valor_tot_by_comp ):
        //         $valor_tot_by_comp = number_format($valor_tot_by_comp, 2, ",", ".");
        //         $result = verifica_valor_disponivel_valor_solicitado($education_data['colaborador'][0], $comp, $valor_tot_by_comp);
        //             if( !$result ):
        //                 throw new Exception("O valor SOLICITADO somado ao valor JÁ SOLICITADO, excede o limite mensal. Competência: {$comp}");
        //             endif;
        //     endforeach;


    }

    function folha_pagamento_validators($sheet_data){
        if ($sheet_data->tipo_folha=='mensal'){
            //Só pode existir uma folha mensal por competência
            if( folha_existe_by_comp($sheet_data->competencia) ):
                throw new Exception("Já existe folha de benefício para essa competência");
            endif;            
        }
        

/*        if( empty($sheet_data->tipo_folha) ):
            throw new Exception("É necessário enviar o tipo de folha");
        endif;

        if( empty( $sheet_data->competencia ) ):
            throw new Exception("É necessário enviar a competência");
        endif;

        if( empty( $sheet_data->data_abertura ) ):
            throw new Exception("É necessário enviar a abertura");
        endif;

        if( $sheet_data->tipo_folha == "mensal" ):
            if( folha_aberta() ):
                throw new Exception("Existem outras folhas abertas!");
            endif;

            if( folha_existe_by_comp($sheet_data->competencia) ):
                throw new Exception("Já existe folha de benefício para essa competência");
            endif;

            if( folha_aberta_by_tipo($sheet_data->tipo_folha) ):
                throw new Exception("Já existe folha para o tipo escolhido!");
            endif;
        endif;
        */
    }

    function folha_pagamento_status_validators(&$sheet_data){
        if( empty( (int) $sheet_data->id_folha) ):
            throw new Exception("É necessário enviar a folha de benefício");
        endif;

        if( empty($sheet_data->status) ):
            throw new Exception("É necessário enviar a situação");
        endif;

        if( empty($sheet_data->tipo_folha) ):
            throw new Exception("Erro interno!");
        endif;

        if( !in_array($sheet_data->status, ["aberto", "fechado", "consolidado"]) ):
            throw new Exception("Parâmetro incorreto!");
        endif;

        switch( $sheet_data->status ):

            case 'fechado':
                if( !folha_aberta_by_id($sheet_data->id_folha) ):
                    throw new  Exception("A folha não está aberta para ser fechada!");
                endif;
            break;

            case 'aberto':
                if( $sheet_data->tipo_folha == "mensal" ):
                    if( folha_aberta_by_tipo($sheet_data->tipo_folha) ):
                        throw new Exception("Já existe folha aberta para o tipo escolhido!");
                    endif;
                endif;
            break;


        endswitch;

    }

    function addContrato_validators($data){
        if( empty($data->nome_contrato) ):
            throw new Exception("É necessário enviar o nome do contrato");
        endif;

        if( empty($data->cnpj_contrato) ):
            throw new Exception("É necessário enviar o CNPJ docontrato");
        else:
            $data->cnpj_contrato = preg_replace('/\D/', '', $data->cnpj_contrato);

            if( strlen($data->cnpj_contrato) != 14 ):
                throw new Exception("É necessário enviar um CNPJ válido!");
            endif;
        endif;

      //  $valida_infos = contrato_ja_existe($data->nome_contrato, $data->cnpj_contrato);
        //    if($valida_infos !== true ):
          //      throw new Exception($valida_infos);
            //endif;

    }

    function createLancamentoContratual_validators(&$data){
        if( empty($data->beneficiario) ):
            throw new Exception("É necessário selecionar o beneficiário!");
        endif;


        if( empty($data->fim_vigencia ) ):
            throw new Exception("É necessário preencher in�cio de vig�ncia do contrato");
        endif;

        if( empty($data->inicio_vigencia ) ):
            throw new Exception("É necessário preencher Fim de vig�ncia do contrato");
        endif;

        if( empty($data->identificacao_contrato ) ):
            throw new Exception("É necessário preencher o campo que identifique o contrato");
        endif;

        
        if( empty( $data->contrato ) ):
            throw new Exception("É necessário fornecer a Institui��o de ensino");
        endif;

        /*
  


        if( empty($data->competencia) || gettype($data->competencia) != "array" ):
            throw new Exception("Competência(s) incorreta(s)!");
        else:
            $data->competencia = array_filter($data->competencia);
            if( count($data->competencia) <= 0 ) throw new Exception("Nenhuma competência foi considerada válida!");
        endif;


        if( empty($data->valor) || gettype($data->valor) != "array" ):
            throw new Exception("Valores incorretos!");
        else:
            $data->valor = array_map('moeda', $data->valor);
            $data->valor = array_filter($data->valor);
            if( count($data->valor) <= 0 ) throw new Exception("Nenhum valor foi considerado válido!");
        endif;
        
        if( empty($data->dependentes) || gettype($data->dependentes) != "array" ):
            throw new Exception("Nenhum dependente foi selecionado!");
        else:
            $data->dependentes = array_map(function($data){
                $data = explode(",", $data);
                $data = array_filter($data);
                $data = implode(",", $data);
                return $data;
            }, $data->dependentes);
            
            $data->dependentes = array_filter($data->dependentes);
            if( count($data->dependentes) <= 0 ) throw new Exception("Nenhum dependente foi considerado válido!");


        endif;

        if(
            count($data->competencia) != count($data->valor)
                ||
            count($data->competencia) != count($data->dependentes)
        ):
            throw new Exception("Os dados não são compatíveis!");
        endif;

        ############ VERIFICANDO SE JÁ EXISTE O REGISTRO LANÇADO ############
            forEach( $data->competencia AS $index => $competencia ):
                $competencia    = $competencia;
                $valor          = $data->valor[$index];
                $dependente     = $data->dependentes[$index];

                $result = verifica_lancamento_ja_existe($dependente, $competencia, $data->beneficiario, $data->contrato);
                    if( $result ):
                        throw new Exception("Já existe lançamento para o contrato nesta competência! Comp.: [{$competencia}]");
                    endif;
            endforeach;
        ############ //VERIFICANDO SE JÁ EXISTE O REGISTRO LANÇADO ############
*/

    }

    function getValorByContrato_validators($data){
        /*if( empty($data->dependente) ):
            throw new Exception("Erro cod. 01");
        endif;

        if( empty($data->comp) ):
            throw new Exception("Erro cod. 02");
        endif;

        if( empty($data->colaborador) ):
            throw new Exception("Erro cod. 03");
        endif;*/
    }

}

?>
