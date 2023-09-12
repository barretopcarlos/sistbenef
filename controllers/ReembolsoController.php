<?php
class ReembolsoController extends AbstractController
{

    public function openReembolso()
    {

        if ($_SESSION['perfil'] == 'beneficiario'){
            $cpf = $_SESSION['cpf'];
        }

        set('funcionarios', loadFuncionarios(isset($cpf)));
        set('infos_opcoes', get_all_folhas_pagamentos(true));
        set('tipoBeneficios', load_tipos_beneficios(true));
        set('tipoDocumentos', load_tipo_documentos());
        set('moedas', load_dados_moeda());
        //set('beneficiarios', load_beneficiarios($_SESSION['id_funcional']));

        return html('reembolso/openReembolso.php');
    }

    public function loadBeneficiarios(){
        $data = json_encode(load_beneficiarios(
                            params('idFuncional'),
                            params('tipoBeneficio'))
                            );

        print_r($data);
        die();
        return render($data, null);
    }

    public function loadBeneficiarioPorIdFuncional(){
        //Para ajax usar render.
        $data = json_encode(loadBeneficiarioPorIdFuncional(
                                params('idFuncional'),
                                params('tipoBeneficio'))
                            );

        return render($data, null);
    }

    public function contratoPorBeneficio()
    {

        //Para ajax usar render.
        $data = json_encode(loadContratoDependentePorBeneficio(
            params('cpfRequerente'),
            params('idDependente'),
            params('idBeneficio')));

        return render($data, null);
    }

    public function cadastrarReembolso()
    {
        try {
            if ($_SERVER ['REQUEST_METHOD'] == 'POST') {

                /**
                 * Informações da solicitação
                 */
                $obj['colaborador'] = $_POST['colaborador'];
                $obj['colaboradorNome'] = $_POST['colaboradorNome'];
                $obj['dependente'] = $_POST['dependente'];
                $obj['dependenteNome'] = $_POST['dependenteNome'];

                if($_SESSION['perfil'] != 'analista'){
                    $obj['dependente'] = '-';
                    $obj['dependenteNome'] = '-';
                }
                $obj['tipoMoeda'] = $_POST['tipoMoeda'];

                if($_POST['tipoMoeda'] == 'dolar') {
                    // Remover o símbolo "$" e vírgulas de milhar, e converter para float
                    $valor = str_replace(['$', ',',''], '', $_POST['valorMoeda']);
                }else if($_POST['tipoMoeda'] == 'euro'){
                    $valor = str_replace(['€', ',',''], '', $_POST['valorMoeda']);
                }else {
                    $valor = preg_replace("/[^0-9,.]/", "", $_POST['valorMoeda']); // Remove todos os caracteres, exceto números, vírgulas e pontos
                    $valor = str_replace(',', '.', str_replace('.', '', $valor)); // Substitui vírgulas por pontos e remove pontos adicionais}
                }
                $obj['valor'] = number_format(floatval($valor), 2, '.', '');

                /**
                 * Pega o id da folha pelo valor da competência da folha de beneficio
                 */
                $competencia = explode("-", $_POST['competenciaBeneficios']);
                $obj['competencia'] = trim($competencia[0] . '-' . $competencia[1]);
                $obj['idFolha'] = get_folha_existe_by_comp($obj['competencia'])->id;

                $obj['competenciaReembolso'] = $_POST['competenciaReembolso'];

                /**
                 * Busa a informação do ID do valor teto
                 */

                $obj['valorTetoId'] = get_valor_teto($_POST['beneficioTiposId']) !== null ? get_valor_teto($_POST['beneficioTiposId'])->id : 'null';
                $obj['valorDisponivel'] = "0.00"; // verifica_valor_disponivel_valor_solicitado();

                $obj['status'] = 'Aberto';
                $obj['dataCadastro'] = date('Y-m-d H:i:s');
                $obj['observacao'] = htmlspecialchars($_POST['observacao']);
                $obj['beneficioTiposId'] = $_POST['beneficioTiposId'];
                $obj['beneficiario'] = 'b';//$_POST['beneficiario'];
                $obj['tipoDocumento'] = $_POST['tipoDocumento'];
                $obj['lancamentoContratualId'] = $_POST['lancamentoContratual'] != "" ? $_POST['lancamentoContratual'] : 'null';
                $obj['moedaId'] = $_POST['moeda'];
                $obj['cpf_cnpj_cr'] = $_POST['cpf'] != "" ? preg_replace('/[^0-9]/', '', $_POST['cpf']) : 'null';  //informações adicionais

                /**
                 * Gerra o protocolo e pega o ID para a tabela de solicitação
                 */
                $protocoloData = new_protocolo($_POST['beneficioTiposId'],$_SESSION['cpf']);

                if(!$protocoloData == null){
                    $obj['protocoloId'] = $protocoloData['id'];
                    $obj['protocolo'] = $protocoloData['protocolo'];
    
                    /**
                     * Cria a solicitação de reembolso
                     */
                    $response = json_decode(addSolicitacaoReembolso($obj));
    
                    /**
                     * Em caso de falha na criação da solicitação remove o protocolo criado
                     */
                    if (!$response->success) {
                        deleteProtocoloFail($protocoloData['id']);
                    }
    
                    /**
                     * Salva os comprovantes
                     */
    
                    if ($response->success) {
    
                        $retorno = json_decode(salvaComprovanteSolicitacao($_FILES, $response->solicitacaoId));
    
                        //  $retorno = array("files" => $_FILES, "campos" => $_POST);
                        if (!$retorno->success) {
                            return $retorno;
                        }
                        return json_encode(array("success" => $response->success, "protocolo" => $obj['protocolo']));
                    }
                }else{
                    return json_encode(array("success" => false, "msg" => "Ocorreu um erro ao gerar o protocolo, favor tente mais tarde!"));
                }
                
            }
        } catch (Exception $e) {
            return json_encode(array("success" => false, 'msg' => $e->getMessage()));
        }

    }

}