
<style>
    .fx{
        display: flex;
        gap: 5px;
    }


    span{
        font-size:small;
        font-weight:bold;
    }
    label{
        font-size:small;
        font-weight:bold;
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
    td{
        font-size:x-small;
    }

</style>


<?php
/*
    stdClass Object ( 
        [id] => 126 [protocolo] => 202302.07a7d468d74eef9893ed51a5dbc98d56 [colaborador] => 82284903304 
        [valor] => 324.04 [dependente] => ANALICE MARTINS BRITO [colaborador_nome] => ABGAIL MARTINS BEZERRA [competencia] => 2022-10 
        [status] => [id_folha] => 24 [id_valor_teto] => 129 [valor_disponivel] => -127.35 [data_cadastro] => 2023-02-09 18:16:11 
    )
*/
$COMBO = null;
$dependentes = file_get_contents(BASEURL."/?/educationDependAll/".$dados->colaborador);
$dependentes = json_decode($dependentes);
$competencia_folha = $dados->competencia;
    $COMBO.="<option value=''>Selecione</option>";
    foreach($dependentes as $k=>$v){
        $COMBO.="<option value='".$v->ID_REG."'>".$v->NOME."</option>";  

    }

//echo '<pre>';  print_r($dados);
$id_folha = $dados->id_folha;
$id_valor_teto = $dados->id_valor_teto;
$valor_disponivel = isset($dados->valor_disponivel)?$dados->valor_disponivel:0;
?>



<div class="container">

    <form method="POST" enctype="multipart/form-data" action="<?=url_for('education/updateBeneficio');?>">
    <input type="hidden" name="index_of" id="index_of" value="0"></input>
    <input type="hidden" name="id_folha" id="id_folha" value="<?=$id_folha?>"></input>
    <input type="hidden" name="valor_disponivel" id="valor_disponivel" value="<?=$valor_disponivel?>"></input>
    <input type="hidden" name="id_valor_teto" id="id_valor_teto" value="<?=$id_valor_teto?>"></input>


            <div class="row">
                <div class="col-4">
                    <label>Protocolo</label>
                    <input type="text" name="protocolo" id="protocolo" 
                    readonly
                    class="form-control" 
                    value="<?=$dados->protocolo?>"></input>
                </div>


                <div class="col-2">
                    <label>CPF Colaborador</label>
                    <input type="text" name="colaborador[]" id="colaborador" 
                    readonly
                    class="form-control" 
                    value="<?=$dados->colaborador?>"></input>
                </div>

                <div class="col-2">
                    <label>Nome Colaborador</label>
                    <input type="text" name="colaborador_nome" id="colaborador_nome" 
                    readonly
                    class="form-control" 
                    value="<?=$dados->colaborador_nome?>"></input>
                </div>                
            </div>   


            <div class="row">
                
            
                <div class="col-2">
                    <label>Competência da Folha</label>
                    <input type="text" name="competencia-folha" id="competencia-folha" 
                    readonly
                    class="form-control" 
                    value="<?=$competencia_folha?>"></input>
                </div>

            
                <div class="col-2">
                    <label>Dependente</label>
                    <select name="dependente" id="dependente" class="form-select" required>
                        <?=$COMBO?>
                    </select>
                </div>

            
                <div class="col-2">
                    <label>Competência do Reembolso</label>
                    <input type="month" required="" id="competencia" name="competencia" class="form-control">
                </div>

                <div class="col-2">
                    <label>Valor do Documento</label>
                    <input type="text" required="" class="form-control" name="valor" id="valor">
                </div>

            </div>

            <br><br>    
            <div class="row">
                <div class="col-3">
                    <label>BOLETO</label>
                    <input type="file" name="educacao[boleto][0][]" id="boleto" accept="application/pdf, image/png, image/jpeg">
                </div>
        
                <div class="col-3">
                    <label>COMPROVANTE</label>
                    <input type="file" name="educacao[comprovante][0][]" required="" id="comprovante" accept="application/pdf, image/png, image/jpeg" required>
                </div>

                <div class="col-3">    
                    <label>OUTROS</label>
                    <input type="file" name="educacao[outros][0][]" id="outros" accept="application/pdf, image/png, image/jpeg">
                </div>
            </div>

            <br><br>    
            <div class="row">
                <div class="col-3">
                    <input type="submit" class="btn-primary btn-lg" value="Incluir">
                </div>
            </div>
    </form>
</div>




<script defer>
    const select_comp_folha = $("#folha_comp");
    let current_compp       = select_comp_folha;
    const id_dependente = $("#dependente").val();


$(document).on("change onlychange", "#competencia", async function(e){
        const {type: tipo_evento} = e;
        const is_original_edit = tipo_evento == "change";

        const valor         = $(this).val() || false;
        const target        = $(this);
        const campo_valor   = target.closest("tr").find("#valor");



        
        if( !current_compp ){
            swal_error("É necessário selecionar a comp. Folha")
            $(this).val("").trigger("change");
            $(document).trigger("comp_finish");
            return false;
        }
/*
        const d1 = new Date(valor).getTime();
        const d2 = new Date(current_compp).getTime();

        if( d1 > d2 ){
            swal_error("A compet. Reembolso não pode ser maior que comp. da Folha");
            $(this).val("").trigger("change");
            $(document).trigger("comp_finish");
            return false;
        }
*/
        const [ano, mes] = valor.split("-");

        const events = [];


        await Promise.all([
            $.ajax({
                url: '?/education/getBestValorTeto',
                type: 'POST',
                dataType: 'json',
                data: { 
                    "educacao[ano]": ano, 
                    "educacao[mes]": mes 
                },
                success: function(response){
                    if( !response.status || response.status != "ok" ){
                        swal_error(`${response.status}`);
                        //target.val("").trigger("change");
                        return;
                    }
    
                    let valor_disponivel = $("#valor_disponivel").val();
                    //let valor = response.valor;
                   // console.log('valor_disponivel',valor_disponivel);
                  //  console.log('valor',valor);

                   // $("#id_valor_teto").val(response.id_valor_teto)
                   // $("#valor").val(response.valor)
                   // $("#valor_disponivel").val(valor_disponivel - valor)
                    console.log('BRAGAO',response);

                },
                error: function(err){
                    swal_error('Falha interna!');
                    console.error(err);
                }
            }),
    
            
            is_original_edit ? 
            $.ajax({
                url: '?/education/getValorByContrato',
                type: 'POST',
                dataType: 'json',
                data: { 
                    "educacao[dependente]": $("#dependente").val(), 
                    "educacao[comp]": valor
                },
                success: async function(response){
    
                    if( !response.status || response.status != "ok" ){
                        swal_error(response.msg);
                        return;
                    }
                    console.log('dadass',this.data);

                    console.log('poxaman',response);

                    if( response.msg.length <= 0 ) return;
    
                    const opcoes = response.msg.map( v => `<option value='${formata_para_moeda(v.total)}'>${v.identificacao_contrato} - ${formata_para_moeda(v.total)}</option>`).join("");
    
                    const {value} = await Swal.fire({
                        title: 'Selecione um valor',
                        text: 'Lançamentos contratuais encontrados',
                        html: `<select id='fake_sel'>
                                    <option value=''>Selecione</option>
                                    ${opcoes}
                                </select>`,
                        icon: 'question',
                        preConfirm: ()=>{
                            return document.querySelector("#fake_sel").value;
                        }
                    }) || false;
    
                    if( !value ) return;
    

                 

                 //   $("#valor").val(value).trigger("keypress");

                    $("#valor").val(value).trigger("keypress");

                    let valor_disponivel = $("#valor_disponivel").val();
                    let valorDocumento = value;//.replace(".","").replace(",",".");
                   // valor_disponivel = valor_disponivel - valorDocumento;

                    $("#valor_disponivel").val(valor_disponivel);


                },
                error: function(fail){
                    swal_error("Erro interno!");
                    console.error(fail);
                }
            }) 
            
                : ''
        ])

        $(document).trigger("comp_finish");

    });
    
</script>