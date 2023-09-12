
<style>
    label {
        font-size: small;    
        font-weight: bold;
        font-family: Arial, Helvetica, sans-serif;
    }

    #btn_add{
        display: inline-block;
        padding: 8px 16px;
        font-size: small;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        outline: none;
        color: #fff;
        background-color: #40539C;
        border: none;
        border-radius: 10px;
    }


    table{
        font-size:small;
    }

    button{
        font-size:small;
    }

    input{
        font-size:small;
    }

    .form-select{
        font-size:small;

    }
    .form-control{
        font-size:small;
    }

</style>

<div class="container" style="margin-bottom: 100px;">

  
    <form action="" method="POST">
    <?php
        $assunto = isset($_POST['assuntoEmail'])?$_POST['assuntoEmail']:'';
        $dtNotificacao = isset($_POST['dataEmail'])?$_POST['dataEmail']:'';
    ?>


    <input type="hidden" name="id_mural" value="" id="id_mural">
        <div class="row">
            <div class="col-1">
                <a href='#' onClick="newMessage();"><i class="fa-solid fa-circle-plus fa-lg"></i> Novo   </a></br>
            </div>

            <div class="col-2">
                    <input type="text" name="assuntoEmail" class="form-control" value="<?=$assunto?>" placeholder="Assunto"/>
            </div>
            <div class="col-2">
                    <select name="dataEmail" class="form-select">
                        <option value="">Selecione a Data</option>
                        <?php
                            $selecionaData = "";
                            foreach ($datasNotificacao as $k=>$v){
                                if ($v->dt == $dtNotificacao)
                                {
                                    $selecionaData = " selected ";
                                }else{
                                    $selecionaData = "";
                                }

                                echo "<option $selecionaData value='{$v->dt}'>{$v->dtFormatada}</option>";
                            }
                        ?>
                    </select>
            </div>
            <div class="col-1">
                    <input type="submit" name="btnSearch" value="Buscar" class="btn btn-warning"/>
            </div>

        </div>
       
        <br>
        <div class="row">

			<div class="col-4">

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-entrada-tab" data-bs-toggle="pill" data-bs-target="#pills-entrada" type="button" role="tab" aria-controls="pills-entrada" aria-selected="true"><b>Entrada</b></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-enviado-tab" data-bs-toggle="pill" data-bs-target="#pills-enviado" type="button" role="tab" aria-controls="pills-enviado" aria-selected="false"><b>Enviados</b></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-lida-tab" data-bs-toggle="pill" data-bs-target="#pills-lida" type="button" role="tab" aria-controls="pills-lida" aria-selected="false"><b>Lidas</b></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-naolida-tab" data-bs-toggle="pill" data-bs-target="#pills-naolida" type="button" role="tab" aria-controls="pills-naolida" aria-selected="false"><b>Não Lidas</b></button>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-entrada" role="tabpanel" aria-labelledby="pills-entrada-tab" tabindex="0">
                        <div class="list-group">
                            <?php
                                //caixa de entrada    
                                foreach($entrada as $k=>$v)
                                {
                                    $estilo = "";
                                        if ($v->enviado_em=='S')
                                            $estilo = " font-weight:bold; ";
                                    echo "<a href='#' onClick=\"details_notify('{$v->id}');\" class='list-group-item list-group-item-action flex-column align-items-start'>
                                    <div class='d-flex w-100 justify-content-between'>
                                    <h5 class='mb-1'><b>{$v->assunto}</b></h5>
                                    <small>{$v->enviado_em}</small>
                                    </div>
                                    <p class='mb-1' style='$estilo'>{$v->descricao}{$v->continuacao}</p>
                                    <small>{$v->justificativa}{$v->continuacao_justificativa}</small>
                                </a>";
                                }
                            ?>        
                        </div>                    
                    </div>


                    <div class="tab-pane fade" id="pills-enviado" role="tabpanel" aria-labelledby="pills-enviado-tab" tabindex="0">
                            <?php
                                //enviados    
                                foreach($enviados as $k=>$v)
                                {
                                    echo "<a href='#' onClick=\"details_notify('{$v->id}');\" class='list-group-item list-group-item-action flex-column align-items-start'>
                                    <div class='d-flex w-100 justify-content-between'>
                                    <h5 class='mb-1'><b>{$v->assunto}</b></h5>
                                    <small>{$v->enviado_em}</small>
                                    </div>
                                    <p class='mb-1'>{$v->descricao}{$v->continuacao}</p>
                                    <small>{$v->justificativa}{$v->continuacao_justificativa}</small>
                                </a>";
                                }
                            ?>        
                    </div>
                    
                    <div class="tab-pane fade" id="pills-lida" role="tabpanel" aria-labelledby="pills-lida-tab" tabindex="0">
                            <?php
                                //lidas    
                                foreach($lidas as $k=>$v)
                                {
                                    echo "<a href='#' onClick=\"details_notify('{$v->id}');\" class='list-group-item list-group-item-action flex-column align-items-start'>
                                    <div class='d-flex w-100 justify-content-between'>
                                    <h5 class='mb-1'><b>{$v->assunto}</b></h5>
                                    <small>{$v->enviado_em}</small>
                                    </div>
                                    <p class='mb-1'>{$v->descricao}{$v->continuacao}</p>
                                    <small>{$v->justificativa}{$v->continuacao_justificativa}</small>
                                </a>";
                                }
                            ?>        
                    </div>
                    
                    <div class="tab-pane fade" id="pills-naolida" role="tabpanel" aria-labelledby="pills-naolida-tab" tabindex="0">
                            <?php
                                //nao lidas    
                                foreach($naolidas as $k=>$v)
                                {
                                    echo "<a href='#' onClick=\"details_notify('{$v->id}');\" class='list-group-item list-group-item-action flex-column align-items-start'>
                                    <div class='d-flex w-100 justify-content-between'>
                                    <h5 class='mb-1'><b>{$v->assunto}</b></h5>
                                    <small>{$v->enviado_em}</small>
                                    </div>
                                    <p class='mb-1'><b>{$v->descricao}{$v->continuacao}</b></p>
                                    <small>{$v->justificativa}{$v->continuacao_justificativa}</small>
                                </a>";
                                }
                            ?>        
                    </div>

                </div>



            </div>			

            <!-- aba de visualizacao de mensagem ou envio -->
            <div class="col-8">
                <!-- Aqui sera exinido conteudo da mensagem ou area para envio de mensagem de notificacao -->
                <div id="area-notificacao"></div>
            </div>
        </div>
        


        
       
    </form>
    
  
</div>



<script>
    function newMessage(){
        $('#area-notificacao').load("<?=url_for('notify/new');?>");
    }

    function details_notify(id){
        console.log(id);
      //  $('#area-notificacao').load("<?php echo url_for('notify/details/');?>/" + id);
    }

</script>