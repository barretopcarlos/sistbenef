
<style>
.nav-pills .btn {
  color: #45773B;
  font-weight:bold;
  border:#efefef solid;
  border-radius: 50px;
}

.nav-pills .btn:hover {
  background: #45773B;
  color: #FFFFFF;
  border-radius: 50px;

}

.header-css{
    font-weight: bold;
    text-align: center;

}

.header-css th {
    background-color: #115B90;
    color: white;
    font-size: 16px;
    text-transform: uppercase;
}

.tbody-css td {
    font-size: 16px;
    text-align: center;
}
</style>    
<?php $_SESSION['user'] = true;?>
<?php
    $lstMuralEducacao = load_mural('1');
    $lstMuralSaude = load_mural('2');
    $infoBeneficiario = getDadosBeneficiario($_SESSION['username']);
    $infoDependentes = getDadosDependentes($_SESSION['id_funcional']);
    $lstMuralAviso = load_mural(null,'Aviso');
    $lstMuralNoticia = load_mural(null,'Notícia');
    $lstMuralOrientacao = load_mural(null,'Orientação'); 
    $lstContaBancaria = getContaBancaria($_SESSION['cpf']);
?>
<div class="content content-index">
    <div class="row nav-pills mb-3" id="pills-tab" role="tablist">
        <div class="col-md-2 col-sm-3 mb-1 col-3" role="presentation">
            <button class="btn" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Beneficiário</button>
        </div>
        <div class="col-md-2 col-sm-3 mb-1 col-3" role="presentation">
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" id="dropdown-dependentes" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dependentes
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdown-dependentes">
                    <a class="dropdown-item" href="<?php echo url_for('dependente/cadastrarDeficiencia'); ?>">Cadastrar Tipo de Deficiência de Dependente</a>
                    <a class="dropdown-item" href="<?php echo url_for('dependente/gerenciarDeficiencia'); ?>">Gerenciar Tipo de Deficiência de Dependente</a>
                </div>
            </div>
        </div>
        <div class="col-md-1 col-sm-3 mb-1 col-3" role="presentation">
            <a href="<?php echo url_for('conta/consultarDadosBancarios'); ?>"><button class="btn" id="pills-contabancaria-tab" type="button" role="tab" aria-controls="pills-contabancaria" aria-selected="true">Conta</button></a>
        </div>
        <div class="col-md-2 col-sm-3 mb-1 col-3" role="presentation">
            <button class="btn" id="pills-mural-tab" data-bs-toggle="pill" data-bs-target="#pills-mural" type="button" role="tab" aria-controls="pills-mural" aria-selected="true">Informações</button>
        </div>
        <div class="col-md-1 col-sm-3 mb-1 col-3" role="presentation">
            <a class="btn" id="pills-advice-tab" data-bs-toggle="pill" data-bs-target="#pills-advice" type="button" role="tab" aria-controls="pills-advice" aria-selected="true">Avisos</a>
        </div>
        <div class="col-md-1 col-sm-3 mb-1 col-3" role="presentation">
            <a class="btn" id="pills-noticia-tab" data-bs-toggle="pill" data-bs-target="#pills-noticia" type="button" role="tab" aria-controls="pills-noticia" aria-selected="true">Notícias</a>
        </div>
        <div class="col-md-1 col-sm-3 mb-1 col-3" role="presentation">
            <a class="btn" id="pills-orientacao-tab" data-bs-toggle="pill" data-bs-target="#pills-orientacao" type="button" role="tab" aria-controls="pills-orientacao" aria-selected="true">Orientações</a>
        </div>
    </div>

<div class="tab-content" id="pills-tabContent">
                <div class="tab-pane" id="pills-mural" role="tabpanel" aria-labelledby="pills-mural-tab" tabindex="0">                            
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="bd-bloc">
                                <h6>Auxílio educação</h6>
                                <p>Quem tem direito: </p>
                                <?php
                                    foreach ($lstMuralEducacao as $key=>$row){
                                        echo "<li>{$row->descricao}</li><br>";
                                    }
                                ?>     
                            </div>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="bd-bloc">
                                    <h6>Auxílio Saúde</h6> 
                                    <p>Quem tem direito: </p>
                                    <?php
                                        foreach ($lstMuralSaude as $key=>$row){
                                            echo "<li>{$row->descricao}</li><br>";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                </div>

  
                <!-- dados do beneficiario -->
                <div class="tab-pane active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                    <?php 
                        if (isset($infoBeneficiario[0]) || !empty($infoBeneficiario)):
                            $ben = $infoBeneficiario[0];
                    ?>
                            <!--div class="container bd-bloc">
                                <table class="table table-striped align-middle">
                                    <thead class="header-css">
                                    <tr>
                                        <th>Nome</th>
                                        <th>CPF</th>
                                        <th>ID Funcional</th>
                                        <th>Cargo</th>
                                        <th>Vínculo</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody class="tbody-css">
                                    <tr>
                                        <td><?php echo $ben->nome?></td>
                                        <td><?php echo $ben->cpf?></td>
                                        <td><?php echo $ben->id_funcional?></td>
                                        <td><?php echo $ben->cargo != '' ? $ben->cargo : '-'?></td>
                                        <td><?php echo $ben->vinculo != '' ? $ben->vinculo : '-'?></td>
                                        <td><span class="badge bg-success text-white"><?php echo $ben->status?></span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div-->

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="bd-bloc">
                                        <?php $ben = $infoBeneficiario[0]; ?>
                                        <div class="row">
                                            <label>Nome</label>
                                            <span><?=$ben->nome?></span>
                                        </div>
                                        <div class="row">
                                            <label>CPF</label>
                                            <span><?=$ben->cpf?></span>
                                        </div>
                                        <div class="row">
                                            <label>ID Funcional</label>
                                            <span><?=$ben->id_funcional?></span>
                                        </div>
                                        <div class="row">
                                            <label>Cargo</label>
                                            <span><?=$ben->cargo?></span>
                                        </div>
                                        <div class="row">
                                            <label>Vínculo</label>
                                            <span><?=$ben->vinculo?></span>
                                        </div>
                                        <div class="row">
                                            <label>Status</label>
                                            <span><?=$ben->status?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php endif;?>
                </div>

                
                
                <!-- <div class="tab-pane" id="pills-contabancaria" role="tabpanel" aria-labelledby="pills-contabancaria-tab" tabindex="0">

                    <?php 
                        if (isset($lstContaBancaria[0]) || !empty($lstContaBancaria[0]))
                        { 
                        ?>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="bd-bloc">
                                        <?php $contas = $lstContaBancaria[0];?>
                                        <h4>Pagamento</h4>
                                        <div class="row">
                                            <div class="col-3">                                            
                                                <label>Banco:</label>
                                                <span><?=$contas->banco_pagamento?></span>
                                            </div>
                                            <div class="col-3">
                                                <label>Agência:</label>
                                                <span><?=$contas->agencia_pagamento?></span>
                                            </div>
                                            <div class="col-3">
                                                <label>Conta:</label>
                                                <span><?=$contas->conta_pagamento?></span>
                                            </div>
                                        </div>
                                        <br><br>
                                        <h4>Benefício</h4>
                                        <div class="row">
                                            <div class="col-3">                                            
                                                <label>Banco:</label>
                                                <span><?=$contas->banco_beneficio?></span>
                                            </div>
                                            <div class="col-3">
                                                <label>Agência:</label>
                                                <span><?=$contas->agencia_beneficio?></span>
                                            </div>
                                            <div class="col-3">
                                                <label>Conta:</label>
                                                <span><?=$contas->conta_beneficio?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php 
                        } 
                    ?> 


                </div> -->

                <div class="tab-pane" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
                    <?php 
                        if (!empty($infoDependentes))
                        { 
                    ?>    
                            <div class="row">
                                <div class="col-md-12">
                                    
                                        <?php  
                                            foreach ($infoDependentes as $k => $v)
                                            {
                                        ?>  
                                            <div class="bd-bloc mb-5">
                                                <div class="row">
                                                    <label>Nome</label>
                                                    <span><?=$v->nome?></span>
                                                </div>
                                                <div class="row">
                                                    <label>CPF</label>
                                                    <span><?=$v->cpf?></span>
                                                </div>
                                                <div class="row">
                                                    <label>Sexo</label>
                                                    <span><?=$v->sexo?></span>
                                                </div>
                                                <div class="row">
                                                    <label>Dependência</label>
                                                    <span><?=$v->dependencia?></span>
                                                </div>
                                                <div class="row">
                                                    <label>Auxílio Educação?</label>
                                                    <span><?=$v->auxilio_educacao?></span>
                                                </div>
                                            </div>    
                                        <?php
                                            }
                                        ?>                                                    
                                    
                                </div>
                            </div>
                    <?php 
                        } 
                    ?>                                                
                </div>

                <div class="tab-pane" id="pills-advice" role="tabpanel" aria-labelledby="pills-advice-tab" tabindex="0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="bd-bloc">
                                <?php
                                 
                                    if(null == $row->descricao){
                                        echo "Ops, me parece que você não tem avisos no momento.";}else{
                                            foreach ($lstMuralAviso as $key=>$row){
                                                

                                                    echo "<li>{$row->descricao}</li><br>";}
                                               
                                                    
                                                
                                            }
                                        ?>
                                </div>
                            </div>
                        </div>
                </div>



                <div class="tab-pane" id="pills-noticia" role="tabpanel" aria-labelledby="pills-noticia-tab" tabindex="0">
                        <div class="row">
                            <div class="col-md-12">
                            <?php
                                 
                                if(null == $row->descricao){
                                     echo "Ops, me parece que você não tem notícias no momento.";}else{
                                         
                                         foreach ($lstMuralNoticia as $key=>$row){
                                             echo "<li>{$row->descricao}</li><br>";
                                         }
                                            
                                                 
                                             
                                }
                             ?>
                            </div>
                        </div>
                </div>


                <div class="tab-pane" id="pills-orientacao" role="tabpanel" aria-labelledby="pills-orientacao-tab" tabindex="0">
                        <div class="row">
                            <div class="col-md-12">
                            <?php
                                 
                                 if(null == $row->descricao){
                                     echo "Ops, me parece que você não tem orientações no momento.";}else{
                                         foreach ($lstMuralOrientacao as $key=>$row){
                                             echo "<li>{$row->descricao}</li><br>";
                                         }
                                            
                                                 
                                             
                                         }
                             ?>

                            </div>
                        </div>
                </div>



    </div>
</div>

<?php
// Kint::dump($GLOBALS, $_SERVER, $_SESSION);

//echo "A versão do PHP é: " . phpversion();
?>