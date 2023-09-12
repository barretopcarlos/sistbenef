<?php Acl::view('education/addContrato');?>
<?php 
    if( isset($msg) && !empty($msg) ):
        phpAlert($msg);
    endif;
?>

<div class="container" style="margin-bottom: 100px;">


    <form action="" method="POST">
    <input type="hidden" name="educacao[nomeOriginal]" id="nomeOriginal"/>
    <input type="hidden" name="educacao[transacao]" id="transacao"/>
  
          <div class="row">

                <div class="col-3">
                    <label for="">CNPJ</label>
                    <br>
                    <input type="text" class="form-control" name="educacao[cnpj_contrato]" id="cnpj_contrato">
                    <br>
                </div>   

                <div class="col-3  ">
                    <label for="">Nome da instituição</label>
                    <br>
                    <input type="text" class="form-control" name="educacao[nome_contrato]" id="nome_contrato">
                </div>

                <div class="col-2">
                    <label for="">Instituição Internacional?</label>
                    <br>
                    <input type="checkbox" class="form-checkbox" name="educacao[internacional]" id="internacional" onClick="InstituicaoInternacional()">
                    <br>
                </div>   
            <button type="submit" class="btn btn-primary col-1" type="button" id="btn_add" name="btn_add">Cadastrar</button>
            <button class="btn btn-warning col-1" type="button" id="btn_edit" name="btn_edit" style="display:none">Atualizar</button>
            <button class="btn btn-danger col-1" type="button" id="btn_cancel" name="btn_cancelt" style="display:none">Cancelar</button>
        </div>

    </form>
 
    

    
    <br><br>
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>CNPJ</th>
                <th>Instituição</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php $index = 0;?>
            <?php forEach($lstContratos AS $row ): ?>
                <?php 
                    $index++;
                    $classe = $index == 1 ? "style='background-color: #c3e6cb !important;'" : '';
                ?>
                <tr>
                    <td <?= $classe; ?> ><?= $row->id; ?></td>
                    <td <?= $classe; ?> ><?= $row->cnpj_contrato; ?></td>
                    <td <?= $classe; ?> ><?= $row->nome_contrato; ?></td>
                    <td> 
                            <button type="button" 
                            onClick="getNomeInstituicao('<?= $row->nome_contrato; ?>');"
                            class="btn btn-primary btn-sm fa-solid fa-edit"
                            title="Editar contrato">Editar
                            </button>
	                </td>
                </tr>
            <?php endforeach; ?>
        </tbody>  
    </table>
    
  
</div>


<script src="assets/js/imask.js"></script>
<script defer>



function InstituicaoInternacional()
{
    if ($('#internacional').prop('checked') === true)
    {
        $('#cnpj_contrato').val('00000000000000')
    }else{
        $('#cnpj_contrato').val('')
    }
}


function getNomeInstituicao(nome){
    $('#nomeOriginal').val(nome); 
    $('#nome_contrato').val(nome); 
    $('#transacao').val('edit'); 
    
    $.get( "<?=BASEURL?>/?/education/nomeInstituicao/" + nome, function( data ) {

            if (data!=undefined && data!=''){
                var json = JSON.parse(data);
                $('#cnpj_contrato').val(json.cnpj_contrato); //cnpj
                var checkedInternacional = json.internacional == 'S' ? true : false;

                $("#internacional").attr('checked', checkedInternacional)


                $("#btn_edit").show(); //habilitar botão de edição    
                $("#btn_cancel").show(); //habilitar botão de edição    
                $("#btn_add").hide(); 

            }else{
                $('#nome_contrato').val(''); //nome da instituição na caixa de texto
                $("#btn_edit").hide(); //desabilitar botão de edição
                $("#btn_cancel").hide();    
                $("#btn_add").show(); 
            }
        });
}

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
    const btn_cancel     = $("#btn_cancel");
    const nome_contrato = $("#nome_contrato");
    const cnpj_contrato = $("#cnpj_contrato");
    const internacional = $("#internacional");

    const cnpj_mask = IMask(cnpj_contrato.get(0), {
        mask: '00000000000000',
        lazy: false,
        placeholderChar: "#"
    });


    cnpj_contrato.on("keyup", async function(e){
        console.log(e);

        $.get( "<?=BASEURL?>/?/education/nomeInstituicao/" + this.value, function( data ) {
            if (data!=undefined && data!=''){
                $('#nome_contrato').val(data); //nome da instituição na caixa de texto
                $("#btn_edit").show(); //habilitar botão de edição    
            }else{
                $('#nome_contrato').val(''); //nome da instituição na caixa de texto
                $("#btn_edit").hide(); //desabilitar botão de edição
            }
        });

    });

    
    btn_add.on("click", async function(e){
        e.preventDefault();

        try{
            const valor_nome    = nome_contrato.val() || false;
            const valor_cnpj    = cnpj_mask._unmaskedValue;


                if( !valor_nome ){
                    throw("É necessário preencher o nome!");
                }
/*
                if( valor_cnpj.length != 14){
                    throw("O CNPJ não está completo");
                }
*/
                
            const confirma = await swal_confirma();
                if( !confirma )
                    return;
    
                $("form").eq(0).submit();
        }catch(e){
            swal_error(e);
        }

    });


    btn_edit.on("click", async function(e){
        e.preventDefault();

        try{
            const valor_nome    = nome_contrato.val() || false;
            const valor_cnpj    = cnpj_mask._unmaskedValue;

                
            const confirma = await swal_confirma();
                if( !confirma )
                    return;
    
                $("form").eq(0).submit();
        }catch(e){
            swal_error(e);
        }

    });




    btn_cancel.on("click", async function(e){
        e.preventDefault();

        $("#btn_edit").hide(); 
        $("#btn_cancel").hide(); 
        $("#btn_add").show(); 

    });

</script>