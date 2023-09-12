<?php Acl::view('notify/details');?>
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

    .image-upload>input {
      display: none;
    }


    .image-send>input {
      display: none;
    }


</style>
<div class="container" style="margin-bottom: 100px;">

    <div class="card  shadow-lg p-3 mb-5 bd-white rounded">
    <div class="card-body">


            <form  action="<?=url_for('notify/new'); ?>" method="post" enctype="multipart/form-data">

            <input type="hidden" name="id_message" value="" id="id_mural">
            <input type="hidden" name="id_resposta" id="id_resposta"  value="<?=$id?>">
            
                <div class="row">
                    <div class="col-12">
                        
                            <div class="image-send">
                                <label for="submit-input">
                                    <i class="fas fa-envelope"></i> Enviar
                                </label>

                                <input id="submit-input" type="submit" />
                            </div>


                    <!--  <i class="fa fa-remove"></i> Descartar-->
                        

                            <div class="image-upload">
                                <label for="file-input">
                                    <i class="fas fa-paperclip"></i> Inserir
                                </label>
                                <input id="file-input" name="file-input" type="file" multiple="multiple"/>
                            </div>
                            <div id="nomeArquivo"></div>


                    </div>        
                </div>
                <br/>
            
                <div class="row">
                    <div class="col-12">
                        <?php 
                            if (Acl::$perfil=='analista')
                            {
                                $DESTINATARIOS = '';
                                $lstBeneficiarios = file_get_contents(BASEURL_RH."/?/funcionario/listAll");
                                $lstBeneficiarios = json_decode($lstBeneficiarios);
                                
                                $habilitado = ""; //no reply selecionar destinatario
                                $destinatarioReply = "";
                                    if (isset($lstNotificacao->destinatario))
                                        $destinatarioReply = $lstNotificacao->destinatario;

                                foreach ($lstBeneficiarios as $key => $value) {
                                    if  ($destinatarioReply == $value->login_rede)
                                        $habilitado = " selected ";

                                    if (!empty($value->login_rede))
                                    {
                                        $DESTINATARIOS .= "<option $habilitado value='{$value->login_rede}'>{$value->nome}</option>";
                                    }
                                }
                    
                                echo "<select name='destinatario'>
                                    <option value=''>Selecione</option>
                                    $DESTINATARIOS
                                </select>";
                            }else{
                                echo "<input type='hidden' name='destinatario' value='0'/>Destinatário: <label> NÚCLEO DE BENEFÍCIOS</label>";
                            }
                        ?>
                        
                    </div>        
                </div>

                
                <div class="row">
                    <div class="col-12">
                        <input type="text" name="assunto" class="form-control" placeholder="Assunto:">
                    </div>        
                </div>

                
                <div class="row">
                    <div class="col-12">
                        <input type="text" name="justificativa" class="form-control" placeholder="Justificativa:">
                    </div>        
                </div>


                <div class="row">
                    <div class="col-12">
                        <textarea name="mensagem" class="form-control" placeholder="Descrição"></textarea>
                    </div>        
                </div>


            
            </form>
    </div>            
    </div>            
    
  
</div>


