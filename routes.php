<?php

// main controller
dispatch('/', 'main_page');
dispatch_get    ('main','AppointmentController::mainNavigation');
dispatch_post  ('main','AppointmentController::mainNavigation');
dispatch_post  ('login','MainController::login');
dispatch_get  ('logout','MainController::logout');


dispatch_get    ('obtercpf','MainController::obtercpf');
dispatch_post    ('obtercpf','MainController::obtercpf');


//Controller Education
dispatch_post   ('education','AppointmentController::educationIndex');
dispatch_get    ('education','AppointmentController::educationIndex');
dispatch_get    ('education/form','AppointmentController::educationIndexForm'); 
dispatch_get    ('education/formAll','AppointmentController::educationIndexFormAll');
dispatch_post   ('education/view','AppointmentController::educationIndexViewPost');
dispatch_get   ('education/view/:id/:doc','AppointmentController::educationIndexViewPost');
dispatch_get    ('education/view/:filter','AppointmentController::educationIndexViewGet');
dispatch_get    ('educationDepend/:id','AppointmentController::educationDepend');
dispatch_get    ('educationDependAll/:id','AppointmentController::educationDependAll');
dispatch_get    ('education/editBeneficio/:protocolo','AppointmentController::editBeneficio');
dispatch_post    ('education/updateBeneficio','AppointmentController::updateBeneficio');
dispatch_post    ('education/ContratoPorCompetencia/:dependente/:competencia','AppointmentController::VerificarContratoVigentePorCompetencia');


dispatch_get    ('education/formEdit/:id', 'AppointmentController::educationEdit');
dispatch_post    ('education/formEdit', 'AppointmentController::educationEditSave');

dispatch_post   ('education/new','AppointmentController::educationCreate');
dispatch_post   ('education/newAll','AppointmentController::educationCreateAll');

dispatch_get    ('education/pdf/:id/:type','AppointmentController::educationPdf');
dispatch_get    ('load/file/:id/:type','AppointmentController::loadFile');

dispatch_get    ('education/teste','AppointmentController::educationTeste');
dispatch_post   ('education/status','AppointmentController::educationUpdateStatus');
dispatch_get    ('education/viewConsolidated/', 'AppointmentController::educationIndexConsolidated');

dispatch_get('education/listHistoryByEducation/:id', 'AppointmentController::educationListHistoryByEducation');

dispatch_get('education/openSheet', 'AppointmentController::openSheet');
dispatch_post('education/createSheet', 'AppointmentController::createSheet');

dispatch_get('education/getInfoSheet/:id', 'AppointmentController::get_infos_sheet');

dispatch_post('education/sheetChangeStatus', 'AppointmentController::updateSheetStatus');

dispatch_get('education/addTeto', 'AppointmentController::openValorTeto');
dispatch_post('education/addTeto', 'AppointmentController::createValorTeto');

dispatch_get('education/getFolhasPagamentos', 'AppointmentController::getFolhasPagamentos');

dispatch_post('education/getValorDependenteByComp', 'AppointmentController::getValorDependenteByComp');
dispatch_post('education/getBestValorTeto', 'AppointmentController::getBestValorTeto');

dispatch_get('education/addContrato', 'AppointmentController::addContrato');
dispatch_post('education/addContrato', 'AppointmentController::createContrato');

dispatch_get('education/addLancamentoContratual', 'AppointmentController::addLancamentoContratual');
dispatch_post('education/addLancamentoContratual', 'AppointmentController::createLancamentoContratual');
dispatch_post('education/updateVigenciaContrato', 'AppointmentController::updateVigenciaContrato');
dispatch_get('education/editLancamentoContratual/:id', 'AppointmentController::editLancamentoContratual');
dispatch_post('education/editLancamentoContratual', 'AppointmentController::editLancamentoContratual');

dispatch_get('education/deleteLancamentoContratual/:id', 'AppointmentController::deleteLancamentoContratual');


dispatch_post('education/getValorByContrato', 'AppointmentController::getValorByContrato');

dispatch_get('education/closeLancamentoContratual/:id', 'AppointmentController::closeLancamentoContratual');


dispatch_get    ('education/nomeInstituicao/:nome','AppointmentController::obterNomeInstituicao');

//Controller Health
dispatch_post   ('health','HealthController::healthIndex');
dispatch_get    ('health','HealthController::healthIndex');

############## MANAGEMENT ROUTES ##############
        dispatch_get('management','ManagementController::managementIndex');
        dispatch_get('management/viewTeto','ManagementController::gridTeto');

        dispatch_get('management/addMural', 'MuralController::openMural');
        dispatch_post('management/addMural', 'MuralController::createMural');
        dispatch_get('management/deleteMural/:id', 'MuralController::deleteMural');

############## //MANAGEMENT ROUTES ##############

dispatch_get    ('report','ReportController::Index');
dispatch_get    ('report/educationview','ReportController::educationView');
dispatch_post    ('report/educationview','ReportController::educationViewPost');

############## //NOTIFICATIONS ROUTES ##############

dispatch_get    ('notify','NotifyController::load');
dispatch_post    ('notify','NotifyController::load');
dispatch_get    ('notify/new','NotifyController::new');
dispatch_post    ('notify/new','NotifyController::new');
dispatch_get    ('notify/reply/:id','NotifyController::reply');
dispatch_get    ('notify/details/:id','NotifyController::details');
dispatch_post    ('notify/save','NotifyController::save');

############## BENEFICIOS ##########################

dispatch_get('beneficio/cadastrarBeneficio', 'BeneficioController::openBeneficio');
dispatch_post('beneficio/addBeneficio', 'BeneficioController::createBeneficio');
dispatch_post('beneficio/cadastrarBeneficio', 'BeneficioController::cadastrarBeneficio');

dispatch_get('beneficio/consultarBeneficio', 'BeneficioController::openConsultarBeneficio');
dispatch_post('beneficio/consultarBeneficio', 'BeneficioController::consultarBeneficio');
dispatch_post('beneficio/listarConsultarBeneficio', 'BeneficioController::listarConsultarBeneficio');

dispatch_post('beneficio/atualizarBeneficio', 'BeneficioController::atualizarBeneficio');
dispatch_get('beneficio/atualizarBeneficio', 'BeneficioController::openConsultarBeneficio');

############## DADOS BANCARIOS ##########################

dispatch_get('conta/consultarDadosBancarios', 'ContaController::openDadosBancarios');

############## DEPENDENTES ##########################

#### DEFICIENCIA
dispatch_get('dependente/cadastrarDeficiencia', 'DependenteController::openDeficiencia');
dispatch_post('dependente/addDeficiencia', 'DependenteController::cadastrarDeficiencia');

dispatch_get('dependente/gerenciarDeficiencia', 'DependenteController::openGerenciarDeficiencia');

dispatch_post('dependente/deficiencia', 'DependenteController::editarExcluirDeficiencia');
dispatch_get('dependente/atualizarDeficiencia', 'DependenteController::openDeficiencia');

############## REEMBOLSO ##########################
dispatch_get('reembolso/openReembolso', 'ReembolsoController::openReembolso');
dispatch_post('reembolso/cadastrarReembolso','ReembolsoController::cadastrarReembolso');
dispatch_get('reembolso/contratoPorBeneficio/:cpfRequerente/:idDependente/:idBeneficio','ReembolsoController::contratoPorBeneficio');
dispatch_get('reembolso/loadBeneficiario/:idFuncional/:tipoBeneficio','ReembolsoController::loadBeneficiarios');

//APIS
dispatch_get    ('api-v1/carregaContratosDependente/:id','AppointmentController::carregaContratosDependente');

dispatch_get    ('main_health','HealthController::index');


// ################ ROTAS PARA APLICAR LAYOUT PADRÃO PGE

// dispatch('/', function() {
//         $content = "Conteúdo da página inicial";
//         return render('views/template_pge.php', compact('content'));
// });