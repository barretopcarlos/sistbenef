<?php
class AppointmentController extends AbstractController{
     
    function mainNavigation() {
        return html('index.php');
    }
    
    
    public function educationIndex() {   
        $cpf='';
        if ($_SESSION['perfil']=='beneficiario')
            $cpf = $_SESSION['cpf'];
        set('funcionarios', loadFuncionarios($cpf));
        return html('education/index.php');
    }
    
    public function educationIndexForm() {   
        $cpf='';
        if ($_SESSION['perfil']=='beneficiario')
            $cpf = $_SESSION['cpf'];
        set('funcionarios', loadFuncionarios($cpf));        
        return html('education/form.php');
    }
    
    public function educationIndexFormAll() {   
        $cpf='';
        if ($_SESSION['perfil']=='beneficiario')
            $cpf = $_SESSION['cpf'];

        set('funcionarios', loadFuncionarios($cpf));        
        set('infos_opcoes', get_all_folhas_pagamentos(true));
        return html('education/form_all.php');
        
    }
    
    public function obterNomeInstituicao(){
        $resposta = obterNomeInstituicao(params('nome'));
        $data = null;
        if (!empty($resposta[0])){
            $data['cnpj_contrato'] = $resposta[0]->cnpj_contrato;
            $data['nome_contrato'] = $resposta[0]->nome_contrato;
            $data['internacional'] = $resposta[0]->internacional;
        }


        $data = json_encode($data);

        return render($data, null);

    }

     public function educationIndexViewPost() {  
        set('competencias',listCompetence());
        set('status', listStatus());
 
        set('id', params("id"));   
        set('doc', params("doc"));   

 
        $data = AppointmentController::education_data_from_form();
        $data_obj = make_model_object($data);
        if (isset($data_obj->comp)){
            if($data_obj->comp == '' && $data_obj->status == ''){
                set('dependentes', listEducation($data_obj->comp));        
                set('competencia', 'Todos');
            } else{
                set('dependentes', listEducationComp($data_obj->comp, $data_obj->status));        
                set('competencia', $data_obj->comp);   
            }        
        }else{
            set('dependentes', listEducationComp(null, null));        
            set('competencia', null);   
        }

        return html('education/view.php');
    }
    
    public function educationIndexConsolidated() { 
        set('dependentes', listEducationConsolidated());        
        return html('education/view_consolidated.php');
    }
    
     public function educationIndexViewGet() { 
        set('competencias',listCompetence());
        set('status', listStatus());
   
        set('filter', params('filter'));
        if(params('filter') == 'Todos'){
            set('dependentes', listEducation());        
            set('competencia', 'Todos');
        } else{
            set('dependentes', listEducationComp(params('filter')));        
            set('competencia', params('filter'));   
        }        
        return html('education/view.php');
    }
        
    public function educationDepend() {   
        set('dependentes', loadDependentes(params('id')));
        //Para ajax usar render.                
        return render('education/dependentes.php', null);
    }
    
     public function educationDependAll() {   
        // set('dependentes', loadDependentes(params('id')));
        //Para ajax usar render.                
        // return render('education/dependentes_all.php', null);
        $data = json_encode(loadDependentes(params('id')));
        return render($data, null);
    }
    
    public function educationPdf() {   
        set('pdfid', loadPdf(params('id'), params('type')));
        set('typefile', params('type'));                      
        return html('education/pdf.php');
    }
    
    

    public function loadFile() {   
        $id = params('id');
        $tipo = params('type');
        if ($tipo=='notificacao')
        {
            set('FILE', details_notify_file($id));

        }else{
            set('FILE', loadFile($id, $tipo));
        }

        set('typefile', params('type'));                      
        return html('files/load.php');
    }
    

    public function educationUpdateStatus() {   
        $data = AppointmentController::education_data_from_form_all_post();
        $data_obj = make_model_object($data);

        updateStatus($data_obj->id,$data_obj->status);   
        createHistoryStatus($data_obj->id,$data_obj->status,$data_obj->obs);
        //criar notificacao ao usuario
        if ($data_obj->status=='indeferido'){
            $info = getProtocoloLancamentoReembolso($data_obj->id);
            $protocolo = $info[0]->protocolo;
            $cpf = $info[0]->colaborador;
            
            $colaborador = file_get_contents(BASEURL_RH."/?/funcionario/listBeneficiario/$cpf");
            $colaborador = json_decode($colaborador);
            $login_rede = $colaborador[0]->login_rede;
            
            $dadosNotificacao['destinatario'] = $login_rede;
            $dadosNotificacao['assunto'] = 'Reembolso Educação[Indeferido]';
            $dadosNotificacao['justificativa'] = $data_obj->obs;
            $dadosNotificacao['mensagem'] = "Esta é uma mensagem automática referente ao indeferimento do protocolo $protocolo.";
            saveNotify($dadosNotificacao);
            return redirect("notify");
            
        }

        if ($data_obj->status=='deferido'){
            $info = getProtocoloLancamentoReembolso($data_obj->id);
            $protocolo = $info[0]->protocolo;
            $cpf = $info[0]->colaborador;
            
            $colaborador = file_get_contents(BASEURL_RH."/?/funcionario/listBeneficiario/$cpf");
            $colaborador = json_decode($colaborador);
            $login_rede = $colaborador[0]->login_rede;
            
            $dadosNotificacao['destinatario'] = $login_rede;
            $dadosNotificacao['assunto'] = 'Reembolso Educação[Deferido]';
            $dadosNotificacao['justificativa'] = $data_obj->obs;
            $dadosNotificacao['mensagem'] = "Esta é uma mensagem automática referente ao Deferimento do protocolo $protocolo.";
            saveNotify($dadosNotificacao);
            return redirect("notify");
            
        }

        


        return html('education/view.php');
    }


    public function educationCreate() {             
        $cpf='';
        if ($_SESSION['perfil']=='beneficiario')
            $cpf = $_SESSION['cpf'];

        $education_data         = AppointmentController::education_data_from_form(); 
        $education_files        = AppointmentController::education_files_from_form();
        $education_data_obj     = make_model_object($education_data); 
        $education_files_obj    = make_model_object_files($education_files);        
        $msg                    =  create_education_objs($education_data_obj,$education_files_obj);                 
        set('msg',$msg);      
        set('funcionarios', loadFuncionarios($cpf));   

            return html('education/form.php');
    }
    
    public function educationCreateAll() {  
        $cpf='';
        if ($_SESSION['perfil']=='beneficiario')
            $cpf = $_SESSION['cpf'];

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
       
        $msg = '';
            try{
                $education_data         = AppointmentController::education_data_from_form(); 
                $education_files        = AppointmentController::education_files_from_form();
            
                AppointmentController::education_create_all_validators($education_data);

                //Gerar um novo protocolo de auxílio educação
                $protocolo = new_protocolo(1);
                $education_data['protocolo'] = $protocolo['protocolo'];
                                

                $education_data_obj     = make_model_object($education_data); 
                $education_files_obj    = make_model_object_files($education_files);


                set('protocolo',$protocolo['protocolo']);      

                $msg    =  create_education_objs($education_data_obj,$education_files_obj);            
                    //if( !empty($msg) ):
                     //   throw new Exception('Informação de Cadastro: '.$msg);
                   // endif;
                
            }catch(Exception $e){
                $msg = $e->getMessage();
                set('msg',$msg);  
            }
        
        set('funcionarios', loadFuncionarios($cpf)); 
        set('infos_opcoes', get_all_folhas_pagamentos(true));  
            return html('education/form_all.php');
    }

    public function educationEdit(){

        $id = params('id');
        set('infos_educacao', listEducationForEdit($id));
        return html('education/education_form_edit.php');
    }

    public function educationEditSave(){

    

        $education_data             = AppointmentController::education_data_from_form();
        $education_data_files       = AppointmentController::education_files_from_form();
        $education_data_obj         = make_model_object($education_data);
        $education_data_obj_files   = make_model_object_files($education_data_files);

        $msg                        = edit_education_obj($education_data_obj, $education_data_obj_files);   
            return $msg;
    }

    public function educationListHistoryByEducation(){
        set('history', load_historico_alteracoes_education(params('id')));
        return render('education/education_history_list.php', null);
    }
    
    public function openSheet(){
        set('infos_opcoes', get_all_folhas_pagamentos());
        return html('education/openSheet.php');
    }

    public function createSheet(){

        try{
            $sheet_data     = AppointmentController::education_data_from_form();
            $sheet_data_obj = make_model_object($sheet_data);
                AppointmentController::folha_pagamento_validators($sheet_data_obj);
            $msg = folha_pagamento_create($sheet_data_obj);
        }catch(Exception $e){
            $msg = $e->getMessage();
        }

        return render($msg, null);
    }

    public function get_infos_sheet(){
        $resultado = get_infos_folha_pagamento(params('id'));
        return render(json_encode($resultado), NULL);
    }

    public function updateSheetStatus(){

        try{
            $sheet_data     = AppointmentController::education_data_from_form();
            $sheet_data_obj = make_model_object($sheet_data); 
                AppointmentController::folha_pagamento_status_validators($sheet_data_obj);
            $msg            = folha_pagamento_update_status($sheet_data_obj);
        }catch(Exception $e){
            $msg = $e->getMessage();
        }

        return render($msg, null);
        
    }

    public function openValorTeto(){
        set('tetosPagamento', get_tetos());
        set('valor_teto_atual', get_valor_maximo_allowed());
        set('tipoBeneficios', load_tipos_beneficios());        

        return html('education/addValorTeto.php');
    }

    public function createValorTeto(){

        try{
            $value_data = AppointmentController::education_data_from_form();
            $value_data = make_model_object($value_data);
                if( empty($value_data->valor_teto) ):
                    throw new Exception("É necessário enviar o valor teto");
                endif;
            $msg        = add_valor_teto($value_data);
        }catch(Exception $e){
            $msg = $e->getMessage();
        }
        
        set('tetosPagamento', get_tetos());
        set('valor_teto_atual', get_valor_maximo_allowed());
        set('tipoBeneficios', load_tipos_beneficios());        

        return html('education/addValorTeto.php');

    }

    public function getFolhasPagamentos(){
        $options = get_all_folhas_pagamentos();
        return render($options, null);
        
    }

    public function getValorDependenteByComp(){

        $data       = make_model_object(AppointmentController::education_data_from_form());
        $resultado  = get_valor_dependente($data);

        return render(json_encode($resultado), null);
    }

    public function getBestValorTeto(){
        $data       = make_model_object(AppointmentController::education_data_from_form());
        $data->tipo = '1';
        $resultado  = get_valor_teto_by_comp($data);
        return render(json_encode($resultado), null);
    }
   
    public function addContrato(){
        set('lstContratos', get_contratos());

        return html("education/addCadastro.php");
    }

    public function createContrato(){
        $msg = '';
        try{
            $data       = make_model_object(AppointmentController::education_data_from_form());
            AppointmentController::addContrato_validators($data);
            if ($data->transacao == 'edit')
            {
                edit_contrato($data);
            }else{
                add_contrato($data);               
            }
/*
            if (contrato_ja_existe($data->nome_contrato))
            {
                edit_contrato($data);
               // $msg = "O CNPJ já está sendo utilizado em outro contrato";
               // set('msg', $msg);  
            }else{
                add_contrato($data);               
            }
  */          
        }catch(Exception $e){
            $msg = $e->getMessage();
            set('msg', $msg);
        }


        set('lstContratos', get_contratos());
        return html("education/addCadastro.php");

    }


    public function addLancamentoContratual(){
        $cpf='';
        if ($_SESSION['perfil']=='beneficiario')
            $cpf = $_SESSION['cpf'];
        set('funcionarios', loadFuncionarios($cpf));   
        set('contratos', get_contratos());
        set('lstLancamentos', get_lancamentos(null,$cpf));
        return html("education/addLancamentoContratual.php");
    }
    
    public function editLancamentoContratual(){
        $cpf='';
        if ($_SESSION['perfil']=='beneficiario')
            $cpf = $_SESSION['cpf'];
    	$id = params('id');
        set('funcionarios', loadFuncionarios($cpf));   
        set('contratos', get_contratos());
        set('editLancamento', get_lancamentos($id));
        set('lstLancamentos', get_lancamentos(null,$cpf));

            if (!empty($_POST)){
                //echo "<pre>";print_r($_POST);die();
                    updateLancamentoContratual($_POST);
                    set('lstLancamentos', get_lancamentos(null,$cpf));
                header("location:".BASEURL."/?/education/addLancamentoContratual");
            }


        return html("education/addLancamentoContratual.php");
    }


    public function deleteLancamentoContratual(){
        $cpf='';
        if ($_SESSION['perfil']=='beneficiario')
            $cpf = $_SESSION['cpf'];
        $id = params('id');
            set('funcionarios', loadFuncionarios($cpf));   
            set('contratos', get_contratos());
            set('lstLancamentos', get_lancamentos(null,$cpf));
    
        if ($id > 0){
            deleteLancamentoContratual($id);
            set('lstLancamentos', get_lancamentos(null,$cpf));
            header("location:".BASEURL."/?/education/addLancamentoContratual");
        }
    
    
            return html("education/addLancamentoContratual.php");
        }
     

    public function updateVigenciaContrato(){
        $cpf='';
        if ($_SESSION['perfil']=='beneficiario')
            $cpf = $_SESSION['cpf'];
        set('funcionarios', loadFuncionarios($cpf));   
        set('contratos', get_contratos());
        set('lstLancamentos', get_lancamentos(null, $cpf));

        if(!empty($_POST['id_contrato']))
        {
            //atualizar vigencia
            updateVigenciaContrato($_POST);
            header("location:".BASEURL."/?/education/addLancamentoContratual");
        }

        return html("education/addLancamentoContratual.php");
    }
    public function createLancamentoContratual(){
        $cpf='';
        if ($_SESSION['perfil']=='beneficiario')
            $cpf = $_SESSION['cpf'];
        set('lstLancamentos', get_lancamentos(null, $cpf));

        $msg = '';

        try{
            $data = make_model_object(AppointmentController::education_data_from_form());
            AppointmentController::createLancamentoContratual_validators($data);
            addLancamentoContratual($data);

        }catch(Exception $e){
            $msg = $e->getMessage();
            set('msg', $msg);
        }

        set('funcionarios', loadFuncionarios($cpf));   
        set('contratos', get_contratos());
        set('lstLancamentos', get_lancamentos(null, $cpf));

        return html("education/addLancamentoContratual.php");

    }

    public function getValorByContrato(){
        $retorno = [
            'status'    => '',
            'msg'       => ''
        ];
        try{
            $data = make_model_object(AppointmentController::education_data_from_form());
            AppointmentController::getValorByContrato_validators($data);
            $result = getValoresByContrato($data);
            
            $retorno['status']  = 'ok';
            $retorno['msg']     = $result;
        }catch(Exception $e){
            $retorno['status']  = 'error';
            $retorno['msg']     = $e->getMessage();
        }
        

        return render(json_encode($retorno), null);
    }


    public function closeLancamentoContratual(){
        $cpf='';
        if ($_SESSION['perfil']=='beneficiario')
            $cpf = $_SESSION['cpf'];
        set('lstLancamentos', get_lancamentos(null, $cpf));
        $retorno = null;
        $id = params('id');
        
        $retorno = encerrarContrato($id);
        header('location:' . url_for('education/addLancamentoContratual') );
    }

    public function carregaContratosDependente(){
        $retorno = loadContratosDependente(params('id'));

        return render(json_encode($retorno), null);
       
    }


    public function editBeneficio(){
        $protocolo = params('protocolo');
        $dados = getByProtocolo($protocolo);
        set('dados', $dados[0]);

        return html("education/editBeneficio.php");

    }



    public function updateBeneficio(){
        $msg = '';
            try{
                $education_data         = $_POST; 
                $education_files        = $_FILES;
                               
                //obter o nome do dependente com lancamento contratual do beneficio de educação
                $infoDependente = getNomeDependente($_POST['dependente']);

                $_POST['codigo_dependente'] = $_POST['dependente'];
                $_POST['dependente'] = !empty($infoDependente->nome_dependente)?$infoDependente->nome_dependente:null;


                $_POST['valor'] = moeda($_POST['valor']);
                $valor_disponivel = $_POST['valor_disponivel'] - $_POST['valor'];
                $education_data['valor_disponivel'] = $valor_disponivel;

               $education_data_obj = new stdClass();
               foreach ($_POST as $key => $value) {
                    if (!in_array($key,array('colaborador','protocolo','id_folha'))) //chaves nao sao arrays, pois indifere do dependente
                    {
                        $education_data_obj->$key[0] = $value;
                    }else{
                        $education_data_obj->$key = $value;
                    }
                }
        

              // echo "<pre>";print_r($obj);die();


            
             //  $education_data_obj     = make_model_object($education_data); 
               $education_files_obj    = make_model_object_files($education_files);
        
                set('protocolo',$_POST['protocolo']);      

                $msg  =  create_education_objs($education_data_obj,$education_files_obj, false);            


            }catch(Exception $e){
                $msg = $e->getMessage();
                set('msg',$msg);  
            }
        

        return redirect("education/view");
    }



    public function VerificarContratoVigentePorCompetencia(){
        $resultado = null;
        $dependente = $_POST['dependente'];
        $competencia = $_POST['competencia'];
        
        $resultado = VerificarContratoVigentePorCompetencia($dependente,$competencia);
        return render(json_encode($resultado), null);
    }




}