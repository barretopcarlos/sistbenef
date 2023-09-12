<?php Acl::view('management/addMural');?>
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


    <form action="<?= url_for('management/addMural'); ?>" method="POST">
    <input type="hidden" name="id_mural" value="" id="id_mural">
       
        <div class="row">
            <div class="col-4">
                <label for="">Descrição</label>
                <input type="text" class="form-control" name="descricao" value="" id="descricao">
            </div>

			<div class="col-2">
                <label for="">Tipo de Beneficio</label>
                <select  id="tipoBeneficio" name="tipoBeneficio"  class="form-select">
                  <option value="">Selecione</option>
                      <?php foreach ($tipoBeneficios as $key => $ben): ?>
                            <option value="<?= $ben->id;?>" selected>
                                <?= $ben->beneficio; ?>
                            </option>;                
                      <?php endforeach; ?>
                  </select>
            </div>			
		   

			<div class="col-2">
                <label for="">Categoria</label>
                <select  id="categoria" name="categoria"  class="form-select">
                    <option value="">Selecione</option>
                    <option value="Auxílio" selected>Auxílio</option>;                
                    <option value="Aviso">Aviso</option>;                
                    <option value="Notícia">Notícia</option>;                
                    <option value="Orientação">Orientação</option>;                
                  </select>
            </div>			
		   

            <div class="col-4">
                <br>
                <button type="submit" id="btn_add" class="btn btn-primary">Salvar</button>
                <button class="btn btn-warning" type="button" id="btn_edit" name="btn_edit" style="display:none">Atualizar</button>

            </div>
        </div>
        
       
    </form>

    <br><br>
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Descrição</th>
                <th>Beneficio</th>
                <th>Cadastrado Por</th>
                <th>Data Cadastro</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php $index = 0;?>
            <?php forEach($lstMural AS $row ): ?>
                <?php 
                    $index++;
                    $classe = $index == 1 ? "style='background-color: #c3e6cb !important;'" : '';
                ?>
                <tr>
                    <td <?= $classe; ?> ><?= $row->id; ?></td>
                    <td <?= $classe; ?> style="width:35%"><?= $row->descricao; ?></td>
                    <td <?= $classe; ?> ><?= $row->beneficio; ?></td>
                    <td <?= $classe; ?> ><?= $row->id_usuario; ?></td>
                    <td <?= $classe; ?> ><?= date("d/m/Y", strtotime($row->data_cadastro)); ?></td>
                    <td <?= $classe; ?> >
                        <a href="#" onclick="$('#descricao').val('<?= $row->id;?>');$('#descricao').val('<?=$row->descricao;?>');$('#btn_edit').show();">Editar</a>
                        <a href="#" onClick="$('#btn_edit').hide();deleteMural('<?=$row->id?>');">Excluir</a>
                    </td>
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
    const btn_edit       = $("#btn_edit");
    const descricao   = $("#descricao");
    const id_mural   = $("#id_mural");

    btn_add.on("click", async function(e){
        e.preventDefault();

        try{
            const valor = descricao.val() || false;
            
                if( !valor ){
                    throw("É necessário preencher o valor");
                }

                
            const confirma = await swal_confirma();
                if( !confirma )
                    return;
    
                $("form").eq(0).submit();
        }catch(e){
            swal_error(e);
        }

    });

    async function deleteMural(id){
        const confirma =  await swal_confirma();
                            if( !confirma )
                                return;


                
                    $.ajax({
                    url: '?/management/deleteMural/' + id,
                    type: 'GET',
                    dataType: 'json',

                        success: function(response){
                            if( !response.status || response.status != true ){
                                swal_error(`Erro ao tentar excluir descrição no mural`);
                                return;
                            }

                        $("form").eq(0).submit();

                        },
                        error: function(err){
                           swal_error('Falha interna!');
                            console.error(`Erro ao tentar excluir descrição no mural`);
                        }
                    });
                    
                
        

    }


    btn_edit.on("click", async function(e){
        e.preventDefault();

        const confirma =  await swal_confirma();
                            if( !confirma )
                                return;


                $("form").eq(0).submit();

    });




</script>