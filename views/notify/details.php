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

<?php
if (empty($lstNotificacao)) die();
//print_r($lstNotificacao);

?>

<?=ACL::view("details");?>

<div class="container" style="margin-bottom: 100px;">

<div class="card  shadow-lg p-3 mb-5 bd-white rounded">
  <div class="card-body">


            <form action="" method="POST">
            <input type="hidden" name="id_message" value="" id="id_mural">
    
                <div class="row">
                    <div class="col-12">
                        <a href='#'  onClick="replyMessage('<?=$lstNotificacao[0]->id?>');" style='text-decoration:none'><i class="fa-solid fa-arrow-left"></i> Responder</a>
                    </div>        
                </div>

                <br />


                <div class="row">
                    <div class="col-12">
                        <h2 class="h2"><?=$lstNotificacao[0]->assunto;?></h2>
                    </div>        
                </div>


                <div class="row">
                    <div class="col-12">
                    <label>De:</label>

                        <?php 
                            if ($lstNotificacao[0]->destinatario == '0')
                            {
                                echo "Núcleo de Benefícios";        
                            }elseif ($lstNotificacao[0]->remetente == '0'){
                                echo "Núcleo de Benefícios";        
                            }else{
                                echo $lstNotificacao[0]->destinatario;
                            }
                        ?>
                    </div>        
                </div>


            
                <div class="row">
                    <div class="col-12">
                        <?=$lstNotificacao[0]->enviado_em?>
                    </div>        
                </div>


                <br />
                <div class="row">
                    <div class="col-12">
                        <?=$lstNotificacao[0]->descricao?>
                    </div>        
                </div>

                <br />
                <div class="row">
                    <div class="col-12">
                        <label>Justificativa:</label>
                        <?=$lstNotificacao[0]->justificativa?>
                    </div>        
                </div>
                  
                
                <br /><br />
                <button type="button" 
                onClick="window.open('<?php echo url_for("/load/file/" . $lstNotificacao[0]->id . "/notificacao") ?>','_blank')"
                class="btn btn-primary fa-solid fa-paperclip"
                title="Visualizar Anexo">
                </button>

                            
                <hr/>

                <?php
                    $remetenteResposta = "";
                    if (!empty($lstNotificacaoReplys))
                    {
                            echo "<h3>Mensagem Original</h3><br>";

                            foreach($lstNotificacaoReplys as $k => $v){
                                if ($v->remetente == "0")   
                                {
                                    $remetenteResposta = "Núcleo de Benefícios";
                                }else{
                                    $remetenteResposta = $v->remetente;
                                }

                                echo "Remetente: {$remetenteResposta} em {$v->enviado_em}<br><br>
                                Assunto: {$v->assunto}<br>
                                Justificativa: {$v->justificativa}<br>
                                Descrição: {$v->descricao}<br>
                                Respondido por: {$v->respondido_por} em {$v->respondido_em}<br><br>
                                <hr/>";

                            }

                    }
                ?>
                
            </form>
    </div>
</div>
    
  
</div>



<script>
    function replyMessage(id){
        $('#area-notificacao').load("<?=url_for('notify/reply');?>/" + id);
    }


</script>