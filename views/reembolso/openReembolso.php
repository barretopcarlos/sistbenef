
<div class="container mt-1">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li>
                <svg width="12" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2.79167 7.58591C2.68666 7.83937 2.66665 7.96886 2.66665 8.00002V13.3346C2.66665 13.702 2.96433 14 3.33331 14H5.33331V10C5.33331 9.26364 5.93027 8.66669 6.66665 8.66669H9.33331C10.0697 8.66669 10.6666 9.26364 10.6666 10V14H12.6666C13.0356 14 13.3333 13.702 13.3333 13.3346V8.00002C13.3333 7.96886 13.3133 7.83937 13.2083 7.58591C13.1107 7.35045 12.9629 7.06176 12.7698 6.73501C12.3842 6.08255 11.8433 5.32001 11.2378 4.59348C10.631 3.86527 9.97592 3.19315 9.36679 2.70971C9.06229 2.46805 8.78241 2.28408 8.53698 2.16295C8.28601 2.0391 8.10938 2.00002 7.99998 2.00002C7.89058 2.00002 7.71395 2.0391 7.46298 2.16295C7.21755 2.28408 6.93767 2.46805 6.63317 2.70971C6.02404 3.19315 5.36896 3.86527 4.76213 4.59348C4.15668 5.32001 3.61572 6.08255 3.23018 6.73501C3.0371 7.06176 2.88921 7.35045 2.79167 7.58591ZM6.87292 0.967295C7.22351 0.794274 7.60938 0.666687 7.99998 0.666687C8.39058 0.666687 8.77645 0.794274 9.12704 0.967295C9.48317 1.14305 9.84392 1.38616 10.1957 1.66533C10.899 2.22356 11.619 2.9681 12.2621 3.7399C12.9067 4.51336 13.4907 5.33415 13.9177 6.0567C14.1309 6.41745 14.3111 6.76417 14.4401 7.07559C14.5617 7.369 14.6666 7.69785 14.6666 8.00002V13.3346C14.6666 14.4399 13.7704 15.3334 12.6666 15.3334H10.6666C9.93027 15.3334 9.33331 14.7364 9.33331 14V10H6.66665V14C6.66665 14.7364 6.06969 15.3334 5.33331 15.3334H3.33331C2.22954 15.3334 1.33331 14.4399 1.33331 13.3346V8.00002C1.33331 7.69785 1.4383 7.369 1.55986 7.07559C1.68887 6.76417 1.86911 6.41745 2.08228 6.0567C2.50924 5.33415 3.09328 4.51336 3.73783 3.7399C4.381 2.9681 5.10092 2.22356 5.80429 1.66533C6.15604 1.38616 6.51679 1.14305 6.87292 0.967295Z" fill="#0F0F0F"/>
                </svg>&nbsp;
                <a href="<?php echo url_for('main'); ?>" class="text-black">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><span class="text-blue-bold">Solicitação de Reembolso</span></li>
        </ol>
    </nav>

    <form name="frmReembolso" id="frmReembolso" method="POST" action="<?php echo url_for('reembolso/cadastrarReembolso');?>"  enctype="multipart/form-data">
        <input type="hidden" name="hiddenPerfil" id="hiddenPerfil" value="<?php echo $_SESSION['perfil']?>">
        <input type="hidden" name="hiddenIdFuncional" id="hiddenIdFuncional" value="<?php echo $_SESSION['id_funcional']?>">
        <input type="hidden" name="hiddenCpfRequerente" id="hiddenCpfRequerente" value="<?php echo $_SESSION['cpf']?>">
        <div class="row">
            <h1 class="mb-2">Solicitação de Reembolso</h1>
            <div class="col-3 mb-3">
                <label for="competenciaBeneficios" class="form-label">Competência da Folha de Benefícios:</label>
                <select class="form-control" id="competenciaBeneficios" name="competenciaBeneficios">
                    <?php
                        /** @var array $infos_opcoes */
                        echo $infos_opcoes; ?>
                </select>
            </div>
            <div class="col-3 mb-3">
                <label for="competenciaReembolso" class="form-label">Competência de Reembolso:</label>
                <input type="month" class="form-control" id="competenciaReembolso" name="competenciaReembolso">
            </div>
            <div class="col-3 mb-3">
                <label for="beneficio" class="form-label">Benefício:</label>
                <select class="form-control" id="beneficio" name="beneficio">
                    <option value="">Selecione o Tipo de Benefício</option>
                    <?php
                        /** @var array $tipoBeneficios */
                        foreach ($tipoBeneficios as $key=> $tipoBeneficio): ?>
                        <option value="<?php echo $tipoBeneficio->id;?>" data-tipo="<?php echo $tipoBeneficio->tipo_beneficio?>">
                            <?php echo trim($tipoBeneficio->beneficio); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="row">
            <?php
                if($_SESSION['perfil'] == 'analista'):?>
                    <div class="col-2 mb-3 minha-div">
                        <label for="requerente" class="form-label">Requerente:</label>
                        <select class="form-control" id="requerente" name="requerente">
                            <option value="">Selecione o Requerente</option>
                            <?php
                            /** @var array $funcionarios */
                            foreach ($funcionarios as $key => $funcionario): ?>
                                <option value="<?php echo $funcionario->NUMERO; ?>" data-cpf="<?php echo $funcionario->cpf; ?>">
                                    <?php echo $funcionario->nome; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>
            <div class="col-2 mb-3 minha-div">
                <label for="beneficiario" class="form-label">Beneficiário:</label>

                <?php if($_SESSION['perfil'] !== 'analista'): ?>
                    <select class="form-control beneficiario" id="beneficiario" name="beneficiario">
                        <option value="">Selecione o Beneficiário</option>
                    </select>
                <?php else : ?>
                <select class="form-control beneficiario" id="beneficiario" name="beneficiario">
                    <option value="">Selecione o Beneficiário</option>
                        <?php
                             /** @var array $beneficiarios */
                            foreach ($beneficiarios as $key => $beneficiario): ?>
                                <option value="<?php echo $beneficiario->id_funcional; ?>"  data-cpf="<?php echo $beneficiario->cpf; ?>">
                                    <?php echo $beneficiario->nome; ?>
                                </option>
                            <?php endforeach; ?>
                    </select>
                <?php endif; ?>
            </div>
            <div class="col-3 mb-3">
                <label for="tipoDocumento" class="form-label">Tipo de Documento:</label>
                <select class="form-control" id="tipoDocumento" name="tipoDocumento">
                    <option value="" >Selecione Documento</option>
                    <?php
                    /** @var array $tipoDocumentos */
                    foreach ($tipoDocumentos as $key=> $tipoDocumento): ?>
                        <option value="<?php echo $tipoDocumento->id; ?>">
                            <?php echo $tipoDocumento->tipo; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-3 mb-3">
                <label for="contrato" class="form-label">Contrato:</label>
                <select class="form-control" id="cbContrato" name="cbContrato">
                    <option value="">Número do Contrato</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-4 mb-3">
                <label for="boleto" class="form-label">Boleto:</label>
                <div class="d-flex">
                    <button class="btn btn-primary btn-sm  btn-file" type="button" id="btnBoleto" data-option="boleto"><i class="bi bi-upload"></i> Upload</button>
                    <input type="file" class="form-control d-none" id="boleto" name="boleto" onchange="updateFileName(this)">
                    <label class="custom-file-label customFile" for="customFile" id="customFile"> Nenhum arquivo Escolhido</label>

                </div>
            </div>
            <div class="col-4 mb-3">
                <label for="comprovantePagamento" class="form-label">Comprovante de Pagamento:</label>
                <div class="d-flex">
                    <button class="btn btn-primary btn-sm  btn-file" type="button" id="btnComprovantePagamento"  data-option="comprovantePagamento"><i class="bi bi-upload"></i> Upload</button>
                    <input type="file" class="form-control d-none" id="comprovantePagamento"  name="comprovantePagamento" onchange="updateFileName(this)">
                    <label class="custom-file-label customFile" for="customFile" id="customFile">Nenhum arquivo Escolhido</label>
                </div>
            </div>
            <div class="col-4 mb-3">
                <label for="outros" class="form-label">Outros:</label>
                <div class="d-flex">
                    <button class="btn btn-primary btn-sm btn-file" type="button" id="btnOutros"  data-option="outros"><i class="bi bi-upload"></i> Upload</button>
                    <input type="file" class="form-control d-none" id="outros"  name="outros" onchange="updateFileName(this)">
                    <label class="custom-file-labe customFile" for="customFile" id="customFile">Nenhum arquivo Escolhido</label>
                </div>
            </div>
        </div>

        <div class="row">
   <!-- Informações adicionais (CPF, CNPJ ou CR) -->
            <div class="col-3 mb-3 custom-input">
                <label for="infoAdicional" class="form-label">Informações Adicionais:</label>
                <select class="form-control"  id="infoAdicional"  name="infoAdicional">
                    <option value="">Selecione o CPF, CNPJ ou CR</option>
                    <option value="CPF">CPF</option>
                    <option value="CNPJ">CNPJ</option>
                    <option value="CR">CR</option>
                </select>
            </div>

            <div class="col-2 mb-3">
                <label for="cpf" class="form-label" id="labelCpf">CPF:</label>
                <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Digite Número do CPF" maxlength="15">
            </div>
        </div>

        <div class="row">
            <div class="col-2 mb-3 radio-input">
                <label class="form-label">Reembolso Internacional:</label>
                <div class="d-flex align-items-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="reembolsoInternacional" id="reembolsoInternacionalS" value="sim">
                        <label class="form-check-label labelInternacional" for="sim">Sim</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="reembolsoInternacional" id="reembolsoInternacionalN" value="nao" checked="true">
                        <label class="form-check-label labelInternacional" for="nao">Não</label>
                    </div>
                </div>
            </div>
            <div class="col-2 mb-2" style="display: none" id="divMoeda">
               <label for="moeda" class="form-label">Moeda:</label>

               <select class="form-select form-select-lg mb-3" id="moeda" name="moeda">
                    <option value="">Selecione a Moeda</option>
                   <?php
                   /** @var array $moedas */
                    foreach ($moedas as $key=> $moeda): ?>

                        <?php  if(strtolower($moeda->descricao).trim() == 'real'):?>
                            <input type="hidden" value="<?php echo $moeda->id; ?>"  data-alias="<?php echo strtolower($moeda->descricao).trim(); ?>" id="moedaHidden">
                        <?php else: ?>
                           <option value="<?php echo $moeda->id; ?>" data-alias="<?php echo strtolower($moeda->descricao).trim(); ?>">
                               <?php echo $moeda->descricao; ?>
                           </option>
                        <?php endif; ?>

                   <?php endforeach; ?>
                </select>
            </div>
            <div class="col-2 mb-3">
                <label for="valorMoeda" class="form-label" id="labelModalMoeda" >Valor Moeda Brasileira:</label>
                <input type="text" class="form-control" id="valorMoeda" maxlength="15" name="valorMoeda" placeholder="R$ 0,00">
            </div>
        </div>

        <div class="row">
            <div class="col-11 mb-3">
                <label for="observacao" class="form-label">Observações:</label>
                <textarea class="form-control" id="observacao" rows="3" maxlength="200" name="observacao"></textarea>
            </div>
        </div>

        <div class="row pt-3">
            <div class="col-11 enviar-input" style="text-align: right;" >
                <button type="button" class="btn btn-outline btn-sm btnLimpar" id="btnLimpar" name="btnLimpar">
                    &nbsp;Limpar
                </button>
                <button type="submit" class="btn btn-primary btn-sm btnEnviar" id="btnEnviar" name="btnEnviar">
                    &nbsp;Enviar
                </button>
            </div>
        </div>
    </form>

    <!-- MODAL -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue-dark text-white">
                    <h5 class="modal-title" id="confirmationModalLabel">Aviso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">

                    <span class="label-content-modal">Competência da Folha de Benefcío</span><br>
                    <p id="modalCompetencia"></p>

                    <span class="label-content-modal">Competência de Reembolso</span><br>
                    <p id="modalReembolso"></p>

                    <span class="label-content-modal">Benefício</span><br>
                    <p id="modalBeneficio"></p>

                    <span class="label-content-modal">Beneficiário</span><br>
                    <p id="modalBeneficiario"></p>

                    <span class="label-content-modal">Tipo Documento</span><br>
                    <p id="modalTipoDocumento"></p>

                    <span class="label-content-modal">Contrato</span><br>
                    <p id="modalContrato"></p>

                    <span class="label-content-modal">Comprovante(s)</span><br>
                    <p id="modalBoleto"></p>
                    <p id="modalComprovante"></p>
                    <p id="modalOutros"></p>

                    <span class="label-content-modal">Reembolso Internacional</span><br>
                    <p id="modalReembolsoInternacional"></p>

                    <span class="label-content-modal">Moeda</span><br>
                    <p id="modalMoeda"></p>

                    <span class="label-content-modal" id="labelMoeda">Valor moeda Brasileira</span><br>
                    <p id="modalValorMoeda"></p>

                    <span class="label-content-modal">Informações Adicionais</span><br>
                    <p id="modalInfoAdicionais"></p>

                    <span class="label-content-modal">Observações</span><br>
                    <div style="word-wrap: break-word; width: 100%;" id="modalObservacoes"></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline btn-sm btnLimpar" data-bs-dismiss="modal" id="btnLimpar" name="btnLimpar">
                        &nbsp;Fechar
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm btnEnviar" id="confirmForm" name="confirmForm">
                        &nbsp;Enviar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS da página -->
<link href="assets/css/reembolso/reembolso.css" rel="stylesheet" >

<!-- Normalize CSS -->
<link rel="stylesheet" href="assets/css/normalize.min.css">

<!-- Máscara CPF e CNPJ>-->
<script src="assets/js/jquery.mask.min.js"></script>

<!-- Máscara campo Moeda>-->
<script src="assets/js/jquery.inputmask.min.js"></script>

<!-- Js da página -->
<script src="assets/js/reembolso/reembolso.js"></script>


<?php
Kint::dump($GLOBALS, $_SERVER, $_SESSION);
?>