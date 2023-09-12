<?php Acl::view('education/view');?>

<div class="container">


    <div class="servicos">
        <form method="POST">
        <div class="row">
                <div class="col-4">
                            <span>Competência da Folha</span>
                            
                                <select name="educacao[comp]" class="form-select">
                                <option value="">Todos</option>
                                    <?php
                                    foreach ($competencias as $position => $registro) { 
                                    echo "<option value=".$registro->competencia.">".$registro->competencia."</option>";                
                                    }?>
                                </select>
                </div>                
                <div class="col-4">                        
                            <span>Status</span>
                                <select name="educacao[status]" id="status" class="form-select">
                                    <option value="">Todos</option>
                                    <?php forEach( $status AS $index => $registro ): ?>
                                        <?php if( empty($registro->status) ): continue; endif; ?>
                                        <option value="<?= $registro->status; ?>">
                                            <?= $registro->status; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                </div>
                <div class="col-4"><br>
                                <input type="submit" value="buscar" class="btn btn-primary"/>
                </div>
                        
        </div>
        </form>
        

    </div>
    <br>

<div class="row">
<div class="col-12">
    <table id="example" class="display" style="text-align:center">
        <thead>
            <tr>
                <th>Id</th>
                <th>Beneficiário</th>
                <th>Nome Dependente</th>
                <th>Competência (Benefício)</th>
                <th>Valor</th>
                <th>Modelo</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php      
             forEach ($dependentes as $position => $dependente):
                $allowed_to_edit = $dependente->status_folha == "aberto" ? true : false;
            ?>
                <tr>
                    <td><?php echo $dependente->id; ?></td>
                    <td><?php echo $dependente->colaborador_nome; ?></td>
                    <td><?php echo $dependente->nome_dependente; ?></td>
                    <td><?php echo $dependente->competencia; ?></td>
                    <td><?php echo number_format($dependente->valor,2,",","."); ?></td>
                    <td><?php echo $dependente->tipo_folha; ?></td>
                    <td><?php echo $dependente->status; ?></td>
                    <td>                        
<!--
                        <?php if($allowed_to_edit ): ?>
                            <a 
                                href="<?=url_for('education/editBeneficio');?>/<?=$dependente->protocolo; ?>"
                                title='Dependentes'
                            >
                                Dependentes
                            </a>          
                            
                            
                        <?php endif; ?>
                        -->

                        <?php if(  strtolower($dependente->status_folha) != "fechado" && $allowed_to_edit ): ?>
                            
                            <?php if(!in_array(strtolower($dependente->status), array("deferido","indeferido"))): ?>
                                <a 
                                    href="#"
                                    title='Editar'
                                    class="btn_editar_ajx"
                                    data_id="<?php echo $dependente->id; ?>"
                                >
                                    Editar
                                </a>          
                                
        
                                <a 
                                    href="<?php echo url_for("/education/status") ?>"
                                    title='Deferir'
                                    class='deferir' urlview="<?php echo url_for("/education/view/".$competencia) ?>"
                                    datacompentecia= "<?php echo $competencia; ?>" id="<?php echo $dependente->id; ?>"
                                >
                                    Deferir
                                </a>

                                <a 
                                    href="<?php echo url_for("/education/status") ?>"
                                    title='Indeferir'
                                    class='indeferir'
                                    urlview="<?php echo url_for("/education/view/".$competencia) ?>"
                                datacompentecia= "<?php echo $competencia; ?>" 
                                id="<?php echo $dependente->id; ?>"
                                >
                                Indeferir
                                </a>
                                <?php endif; ?>


                        <?php endif; ?>
                        
                        <?php if( isset($dependente->qtd_alteracoes_valor) && ( (int) $dependente->qtd_alteracoes_valor > 0 || (int) $dependente->qtd_alteracoes_status > 0 ) ): ?>
                            <a 
                                href=""
                                class="see_historico"
                                data_id="<?php echo $dependente->id; ?>"
                            >
                                Histórico
                            </a>
                        <?php endif; ?>
                
                        <select class="form-select" onChange="documento('<?=$dependente->id?>',this.value);">
                            <option value="">Selecione o Documento</option>
                            <option value="educacao_boletos">Boleto</option>
                            <option value="educacao_comprovantes">Comprovantes</option>
                            <option value="educacao_outros">Outros</option>
                        </select>        
                        
                    </td>        
                </tr>    
            <?php endforeach; ?>  
        </tbody>        
    </table>

</div> <!--div coluna tabela -->

<div class="col-6">
    <div id="telaDocumentos"></div>
    <?php
        if ($id>0)
        {
            $linkFile = url_for("/load/file/")."/$id/$doc";
            echo "<span>$doc - $id</span>";
        echo " <embed src='$linkFile' type=\"application/pdf\" width=\"100%\" height=\"100%\">";
        }
    ?>

</div>

</div>





</div>

<script type="text/javascript" >  

function documento(id, target){
    window.open('<?php echo url_for("/load/file/")?>/' + id + "/" + target);

}


$(document).ready(function() {
    $('#example').DataTable({
        "language": {
        "sProcessing":    "Procesando...",
        "sLengthMenu":    "Mostrar _MENU_ registros",
        "sZeroRecords":   "Não foram encontrados registros",
        "sEmptyTable":    "Não há dados disponível",
        "sInfo":          "Mostrando registros de _START_ de _END_ de um total de _TOTAL_ registros",
        "sInfoEmpty":     "Mostrando registros de 0 de 0 de um total de 0 registros",
        "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":   "",
        "sSearch":        "Buscar:",
        "sUrl":           "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Carregando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":    "Último",
            "sNext":    "Seguinte",
            "sPrevious": "Anterior"
        }
    }

    });
    
    $(document).on("click", "a.deferir", function() {
        
        event.preventDefault();
        const target = event.target;
        const targetid = event.target.id;
        const targetcompetencia = $(this).attr('datacompentecia');
        const url = $(this).attr('href'); 
        const urlview = $(this).attr('urlview');
        
            Swal.fire({
                icon: 'warning',
                title: 'Deseja prosseguir com o deferemimento?',                
                showCancelButton: true				
                 }).then((result) => {
                if (result.isConfirmed) {   
                    //let obs = prompt("Deseja incluir uma observação?", "");  

                    $.ajax({
                            url: url,
                            type: 'POST',   
                            data: {
                                    id: targetid,
                                    status: 'deferido',
                                    obs:null,
                                    filter: targetcompetencia
			    },
                            success: function(response) {
                                    if (response) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Operação realizada'  
                                            }).then(function() {
                                               window.location.href=urlview;
                                            });                                          
                                            //console.log( error)
                                            //window.location.href=urlview
                                    } else {
                                            Swal.fire(
                                                'Error',
                                                'COD 05',
                                                'error'
                                              );
                                            //console.log( error)
                                    }
                                    
                            },
                            error: function(error) {
                                     Swal.fire(
                                                'Error',
                                                'COD 06',
                                                'error'
                                              );                                     
                                    //console.log(error);
                            },
                            beforeSend: () => {
                                    target.disabled = true;
                            },
                            complete: () => {
                                    target.disabled = true;
                            }                    
                        });
                        
                    } 
                    
                });
                
            });  
    
    $(document).on("click", "a.indeferir", function() {
        event.preventDefault();
        const target = event.target;
        const targetid = event.target.id;
        const targetcompetencia = $(this).attr('datacompentecia');
        const url = $(this).attr('href'); 
        const urlview = $(this).attr('urlview');
        
            Swal.fire({
                title: "Você tem certeza?",
                input: 'textarea',
                inputLabel: 'Justifique o inderefimento',
                inputPlaceholder: 'Escreva sua mensagem aqui...',
                inputAttributes: {
                  'aria-label': 'Escreva sua mensagem aqui'
                },
                showCancelButton: true				
                 }).then((result) => {
                if (result.value) {   
                    //let obs = prompt("Deseja incluir uma observação?", "");  

                    $.ajax({
                            url: url,
                            type: 'POST',   
                            data: {
                                    id: targetid,
                                    status: 'indeferido',
                                    obs:result.value,
                                    filter: targetcompetencia
			    },
                            success: function(response) {
                                    if (response) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Operação realizada'  
                                            }).then(function() {
                                               window.location.href=urlview;
                                            });                                          
                                            //console.log( error)
                                            //window.location.href=urlview
                                    } else {
                                            Swal.fire(
                                                'Error',
                                                'COD 03',
                                                'error'
                                              );
                                            //console.log( error)
                                    }
                                    
                            },
                            error: function(error) {
                                     Swal.fire(
                                                'Error',
                                                'COD 04',
                                                'error'
                                              );                                     
                                    //console.log(error);
                            },
                            beforeSend: () => {
                                    target.disabled = true;
                            },
                            complete: () => {
                                    target.disabled = true;
                            }                    
                        });
                        
                    } 
                    
                });
                
    }); 


        $(document).on("click", ".btn_editar_ajx", async function(event){
            event.preventDefault();
            const target    = event.target;
            const id        = $(this).attr("data_id");

            const { isConfirmed: confirmou, value: formDt } = await Swal.fire({
                title: "Você tem certeza?",
                html: `
                    <label>Valor</label>
                    <br>
                    <input id="valor" onKeyPress="return(moeda(this,'.',',',event))" class="swal2-input">

                    <br><br>
                    <label style="margin-top: 1rem">Observação</label><br>
                    <textarea id="obs" cols="30" rows="10" class="swal2-input"></textarea>

                    <br><br>
                    <label style="margin-top: 1rem">Boleto</label><br>
                    <input type="file" name="educacao[boleto]" id="boleto" accept="application/pdf, image/png, image/jpeg">

                    <br><br>
                    <label style="margin-top: 1rem">Comprovante</label><br>
                    <input type="file" name="educacao[comprovante]" id="comprovante" accept="application/pdf, image/png, image/jpeg">

                    <br><br>
                    <label style="margin-top: 1rem">Outros</label><br>
                    <input type="file" name="educacao[outros]" id="outros" accept="application/pdf, image/png, image/jpeg">
                `,
                focusConfirm: false,
                showCancelButton: true,
                preConfirm: () => {
                    return {
                        valor: document.getElementById('valor').value || false,
                        obs: document.getElementById('obs').value || false,
                        boleto: document.getElementById('boleto').files[0] || '',
                        comprovante: document.getElementById('comprovante').files[0] || '',
                        outros: document.getElementById('outros').files[0] || ''
                    }
                }			
            });

            if( !confirmou ){
                return;
            }

            if( !formDt.valor || !formDt.obs ){
                Swal.fire("É necessário preencher o valor e a observação", "", "error");
                return;
            }

            const n_form = new FormData();
                n_form.append("educacao[idd_registro]", id,);
                n_form.append("educacao[observacao]", formDt.obs);
                n_form.append("educacao[valor]", formDt.valor);
                n_form.append("educacao[boleto]", formDt.boleto);
                n_form.append("educacao[comprovante]", formDt.comprovante);
                n_form.append("educacao[outros]", formDt.outros);

            $.ajax({
                url: '?/education/formEdit',
                type: 'POST',
                data: n_form,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response){
                    if( response && response == "ok" ){
                        Swal.fire("Atualizado com sucesso", "", "success")
                            .then(()=>{
                                window.location.reload();
                            })
                    }else{
                        Swal.fire(`${response}`, "", "error");
                    }
                },
                error: function(error){
                    Swal.fire('Error', 'COD 07','error');
                },
                beforeSend: () =>{ target.disabled = true; },
                complete: () => {  target.disabled = false; }
            })

        });


        $(document).on("click", ".see_historico", function(event){
            event.preventDefault();
            const target = event.target;
            const id = $(this).attr("data_id");

            $.ajax({
                url: `?/education/listHistoryByEducation/${id}`,
                type: 'GET',
                    success: function(response){
                        Swal.fire({
                            width: '40em',
                            allowOutsideClick: false,
                            title: "Histórico:",
                            html: `
                                ${response}
                            `,
                            focusConfirm: false,
                        });
                    },  
                    error: function(fail){
                        Swal.fire('Error', 'COD 08','error');
                    },
                    beforeSend: ()=>{
                        target.disabled = true;
                    },
                    complete: ()=>{
                        target.disabled  = false;
                    }

            })
        });
    
});
</script>