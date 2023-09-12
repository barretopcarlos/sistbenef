<?php Acl::view('report/educationview');?>
<div class="container">


    <div class="servicos">
      
        <form method="POST">
        <div class="row">
                <div class="col-4">
                            Competência da Folha
                            
                                <select name="educacao[comp]" class="form-select">
                                <option value="">Todos</option>
                                    <?php
                                    foreach ($competencias as $position => $registro) { 
                                    echo "<option value=".$registro->competencia.">".$registro->competencia."</option>";                
                                    }?>
                                </select>
                </div>                
                <div class="col-4">                        
                                Status
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


    <table id="example" class="display" style="text-align:center">
        <thead>
            <tr>
                <th>Id</th>
                <th>Beneficiário</th>
                <th>CPF</th>
                <th>Valor</th>
                <th>Dependente</th>
                <th>Competência (Benefício)</th>
                <th>Modelo</th>
                <th>Status</th>
                <th>Ações</th>
                <th>Documentos</th>
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
                    <td><?php echo $dependente->colaborador; ?></td>
                    <td><?php echo number_format($dependente->valor,2,",","."); ?></td>
                    <td><?php echo $dependente->dependente; ?></td>
                    <td><?php echo $dependente->competencia; ?></td>
                    <td><?php echo $dependente->tipo_folha; ?></td>
                    <td><?php echo $dependente->status; ?></td>
                    <td>                        
                        <?php if(  strtolower($dependente->status) != "deferido" && $allowed_to_edit ): ?>
                            <a 
                                href="#"
                                title='Editar'
                                class="btn_editar_ajx"
                                data_id="<?php echo $dependente->id; ?>"
                            >
                                Editar
                            </a>          
                            
                            
                        <?php endif; ?>



                        <?php if(  strtolower($dependente->status_folha) != "fechado" && $allowed_to_edit ): ?>
                
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
                    </td>         
                    <td>
                        <a 
                            href="<?php echo url_for("/load/file/" . $dependente->id . "/educacao_boletos") ?>" 
                            title='Download boleto'
                            target="_blank"
                        >
                            Boleto
                        </a>

                        <a 
                            href="<?php echo url_for("/load/file/" . $dependente->id . "/educacao_comprovantes") ?>"
                            title='Download Comprovante'
                            target="_blank"
                        >
                            Comprovante
                        </a>

                        <a 
                            href="<?php echo url_for("/load/file/" . $dependente->id . "/educacao_outros") ?>"
                            title='Download Outros'
                            target="_blank"
                        >
                            Outros
                        </a>        
                    </td>        
                </tr>    
            <?php endforeach; ?>  
        </tbody>        
    </table>



</div>

<script type="text/javascript" >  
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