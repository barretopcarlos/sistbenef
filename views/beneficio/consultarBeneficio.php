<?php Acl::view('beneficio/consultarBeneficio');?>

<html >
    <body>  
        <?php
            $formattedData = [];
            foreach ($tipoBeneficios as $beneficio) {
                $formattedData[] = [
                    'id' => $beneficio->id,
                    'beneficio' => $beneficio->beneficio,
                    'criado_por' => $beneficio->criado_por,
                    'criado_em' => date('d/m/Y \à\s H:i:s', strtotime($beneficio->criado_em)),
                    'diaLimite' => $beneficio->dia_limite,
                    'reembolso' => $beneficio->reembolso == 'sim' ? 'Sim' : 'Não',
                    'tetoGasto' => $beneficio->gasto_teto == 'sim' ? 'Sim' : 'Não',
                    'editar' => "<button class='editar btn btn-link' data-id='$beneficio->id' data-beneficio='$beneficio->beneficio' data-criado_por='$beneficio->criado_por' data-criado_em='$beneficio->criado_em' data-diaLimite='$beneficio->dia_limite' data-reembolso='$beneficio->reembolso' data-tetoGasto='$beneficio->gasto_teto'><i class='bi bi-pencil'></i></button>"
                ];
            }
            $jsonData = json_encode($formattedData);
        ?>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li>
                    <svg width="12" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.79167 7.58591C2.68666 7.83937 2.66665 7.96886 2.66665 8.00002V13.3346C2.66665 13.702 2.96433 14 3.33331 14H5.33331V10C5.33331 9.26364 5.93027 8.66669 6.66665 8.66669H9.33331C10.0697 8.66669 10.6666 9.26364 10.6666 10V14H12.6666C13.0356 14 13.3333 13.702 13.3333 13.3346V8.00002C13.3333 7.96886 13.3133 7.83937 13.2083 7.58591C13.1107 7.35045 12.9629 7.06176 12.7698 6.73501C12.3842 6.08255 11.8433 5.32001 11.2378 4.59348C10.631 3.86527 9.97592 3.19315 9.36679 2.70971C9.06229 2.46805 8.78241 2.28408 8.53698 2.16295C8.28601 2.0391 8.10938 2.00002 7.99998 2.00002C7.89058 2.00002 7.71395 2.0391 7.46298 2.16295C7.21755 2.28408 6.93767 2.46805 6.63317 2.70971C6.02404 3.19315 5.36896 3.86527 4.76213 4.59348C4.15668 5.32001 3.61572 6.08255 3.23018 6.73501C3.0371 7.06176 2.88921 7.35045 2.79167 7.58591ZM6.87292 0.967295C7.22351 0.794274 7.60938 0.666687 7.99998 0.666687C8.39058 0.666687 8.77645 0.794274 9.12704 0.967295C9.48317 1.14305 9.84392 1.38616 10.1957 1.66533C10.899 2.22356 11.619 2.9681 12.2621 3.7399C12.9067 4.51336 13.4907 5.33415 13.9177 6.0567C14.1309 6.41745 14.3111 6.76417 14.4401 7.07559C14.5617 7.369 14.6666 7.69785 14.6666 8.00002V13.3346C14.6666 14.4399 13.7704 15.3334 12.6666 15.3334H10.6666C9.93027 15.3334 9.33331 14.7364 9.33331 14V10H6.66665V14C6.66665 14.7364 6.06969 15.3334 5.33331 15.3334H3.33331C2.22954 15.3334 1.33331 14.4399 1.33331 13.3346V8.00002C1.33331 7.69785 1.4383 7.369 1.55986 7.07559C1.68887 6.76417 1.86911 6.41745 2.08228 6.0567C2.50924 5.33415 3.09328 4.51336 3.73783 3.7399C4.381 2.9681 5.10092 2.22356 5.80429 1.66533C6.15604 1.38616 6.51679 1.14305 6.87292 0.967295Z" fill="#0F0F0F"/>
                    </svg>&nbsp;
                    <a href="<?php echo url_for('main'); ?>" class="text-black">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span class="text-breadcrumb-blue texto-breadcrumb">Consulta de Benefícios</span></li>
            </ol>
        </nav>

        <div class="container">
            <?php if (isset($msg) && $msg == true) : ?>
                <div class="beneficio-alterado">
                    <i class="bi bi-check-circle-fill"></i>
                    <p class="texto-beneficio-alterado">Benefício <?php echo $_POST['beneficio']; ?> alterado com sucesso.</p>
                </div>
            <?php elseif (isset($msg) && $msg == false) : ?>
                <div class="beneficio-nao-alterado">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <p class="texto-beneficio-nao-alterado">Não foi possível alterar o benefício. Tente novamente.</p>
                </div>
            <?php endif; ?>
        </div>

        <h1>Consulta de Benefícios</h1>

        <table id="beneficioTable" class="display">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Benefício</th>
                    <th>Dia limite da entrega</th>
                    <th>Reembolso</th>
                    <th>Teto de Gasto</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>

        <!-- MODAL -->
        <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="updateForm" action="<?= url_for('beneficio/atualizarBeneficio'); ?>" method="post">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmationModalLabel">Alteração de Benefícios</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                        </div>
                        <div class="modal-body">

                        <div id="campo-nao-preenchido" style="display: none; margin-bottom: 20px;">
                            <div class="campo-nao-preenchido">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                <p class="texto-campo-nao-preenchido">Preencha todos os campos</p>
                            </div>
                        </div>


                            <input type="hidden" id="modalId" name="id">
                            <div class="form-group">
                                <label for="modalBeneficio">Benefício</label>
                                <input type="text" class="form-control" id="modalBeneficio" name="beneficio" maxlength="50">
                            </div>
                            <div class="form-group edit-form">
                                <label for="modalDiaLimite">Dia Limite da Entrega</label>
                                <select class="form-control select-modal" id="modalDiaLimite" name="dia_limite">
                                    <?php
                                        for ($i = 1; $i <= 31; $i++) {
                                            echo '<option value="' . $i . '">' . $i . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group edit-form">
                                <label>Reembolso:</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="modalReembolso" id="modalReembolsoSim" value="sim">
                                        <label class="form-check-label" for="modalReembolsoSim">Sim</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="modalReembolso" id="modalReembolsoNao" value="nao">
                                        <label class="form-check-label" for="modalReembolsoNao">Não</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group edit-form">
                                <label>Teto de Gasto:</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="modalTetoGasto" id="modalTetoGastoSim" value="sim">
                                        <label class="form-check-label" for="modalTetoGastoSim">Sim</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="modalTetoGasto" id="modalTetoGastoNao" value="nao">
                                        <label class="form-check-label" for="modalTetoGastoNao">Não</label>
                                    </div>
                                </div>
                            </div>

                            <p style="text-align: left;display:block;margin-top: 10px; margin-bottom: -10px;">Deseja prosseguir com a alteração do benefício?</p>

                        </div>                                 

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="button" class="btn btn-primary" id="confirmForm">Avançar</button>
                        </div>
                    </div>
                </form>


            </div>
        </div>

        <script>var jsonData = <?php echo json_encode($formattedData); ?>;</script>
        
    </body>
</html>

<!-- CSS da página -->
<link href="assets/css/beneficios/cadastro_beneficios.css" rel="stylesheet" >
<!-- JS da página -->
<script src="assets/js/beneficio/consultar_beneficio.js"></script>
    