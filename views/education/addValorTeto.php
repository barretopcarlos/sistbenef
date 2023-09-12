<?php
    $valor_atual_moeda = number_format($valor_teto_atual, 2,",",".");
    
?>


<div class="container" style="margin-bottom: 100px;">


    <form action="" method="POST">
       
        <div class="row">
            <div class="col-4">
                <label for="">Valor do teto</label>
                <input type="text" class="form-control" name="educacao[valor_teto]" value="<?= $valor_atual_moeda; ?>" id="valor_teto" onKeyPress="return(moeda(this,'.',',',event))">
            </div>

			<div class="col-4">
                <label for="">Tipo de Beneficio</label>
                <select  id="tipoBeneficio" name="educacao[tipoBeneficio]"  class="form-select">
                  <option value="">Selecione</option>
                      <?php foreach ($tipoBeneficios as $key => $ben): ?>
                            <option value="<?= $ben->id;?>" selected>
                                <?= $ben->beneficio; ?>
                            </option>;                
                      <?php endforeach; ?>
                  </select>
            </div>			
		   

            <div class="col-4">
                <br>
                <button type="button" id="btn_add" class="btn btn-primary">Salvar</button>
            </div>
        </div>
        
       
    </form>

    <br><br>
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Valor</th>
                <th>Beneficio</th>
                <th>Cadastrado Por</th>
                <th>Data Cadastro</th>
            </tr>
        </thead>

        <tbody>
            <?php $index = 0;?>
            <?php forEach($tetosPagamento AS $row ): ?>
                <?php 
                    $index++;
                    $classe = $index == 1 ? "style='background-color: #c3e6cb !important;'" : '';
                ?>
                <tr>
                    <td <?= $classe; ?> ><?= $row->id; ?></td>
                    <td <?= $classe; ?> ><?= number_format($row->valor, 2, ",", "."); ?></td>
                    <td <?= $classe; ?> ><?= $row->beneficio; ?></td>
                    <td <?= $classe; ?> ><?= $row->id_usuario; ?></td>
                    <td <?= $classe; ?> ><?= date("d/m/Y H:i", strtotime($row->data_cadastro)); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>  
    </table>
    
  
</div>


<script defer>

    const tabela = $('#example').DataTable({
        "order": [[ 0, 'desc' ]],
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
    
    const btn_add       = $("#btn_add");
    const input_valor   = $("#valor_teto");
    const valor_atual   = `<?= $valor_atual_moeda; ?>`

    btn_add.on("click", async function(e){
        e.preventDefault();


        try{
            const valor = input_valor.val() || false;
            
                if( !valor ){
                    throw("É necessário preencher o valor");
                }

                if( valor == valor_atual ){
                    throw("O novo valor deve ser diferente do valor atual!");
                }
                
            const confirma = await swal_confirma();
                if( !confirma )
                    return;
    
                $("form").eq(0).submit();
        }catch(e){
            swal_error(e);
        }

    });

</script>