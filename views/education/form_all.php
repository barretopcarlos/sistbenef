<?php

 if(empty($_SESSION['perfil'])){
    redirect_to("logout");
 }

    if( isset($msg) ):
        phpAlert($msg);
    endif;

    if (isset($protocolo) && !empty($protocolo))
    {
        echo "<div class=\"alert alert-success col-10 offset-1\" role=\"alert\" id='alertaProtocolo'>
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\" onClick=\"$('#alertaProtocolo').hide();\">
        <span aria-hidden=\"true\">&times;</span>
    </button>
        
    Protocolo de atendimento: $protocolo
        
        </div>";
    }
?>

<script type="text/javascript">
        setTimeout(function () {
  
            // Closing the alert
            $('#alertaProtocolo').alert('close');
        }, 60000);
    </script>

<div class="header d-none">
    <div class="headerImage">
        <img src="https://pge.rj.gov.br/site/img/logo.png" alt="PGE - RJ" class="logo">
    </div>
    <div class="headerTitulo">
        <h2 >Benefícios</h2>
    </div>
</div>

<div class="container">
    

    <div id="mainDiv">

            <form method="POST" action="<?php echo url_for('education/newAll'); ?>"  enctype="multipart/form-data">
            <input type="hidden" name="_method" id="_method" value="POST" />
            
            <div class="row">


                    <div class="col-6">
                        <span>ID</span>
                        <input type="text" class="form-control" id="idd" disabled>
                    </div>
            
                    <div class="col-6">
                        <span>CPF</span>
                        <input type="text" class="form-control" id="cpff" disabled>
                    </div>
                    

                    <div class="col-4">
                        <span>Competência da Folha</span>
                            <select name="educacao[id_folha]" id="folha_comp" class="form-select">
                                <option value="">Selecione</option>
                                <?= $infos_opcoes; ?>
                            </select>
                    </div>
            
                    <div class="col-4">
                        <label for="input-colaborador">Beneficiário</label>
                        <input type="text" class="form-control" placeholder="Beneficiário" list="list-colaborador" id="input-colaborador">

                            <datalist id="list-colaborador">
                                <?php foreach ($funcionarios as $position => $funcionario): ?>
                                        <option>
                                            <?= $funcionario->nome; ?>
                                        </option>;                
                                <?php endforeach; ?>
                            </datalist>
                        
                    </div>
            
            
            
                    <div class="col-4">
                        <span>Dependentes</span>
                            <select id="dependentes" class="form-select">
                                <option value="">Selecione</option>
                            </select>

                    </div>
                
            
                    <div class="col-6">
                        <button type="button" id="btn_add_dep" class="btn btn-primary" disabled>Adicionar</button>
                    </div>


                <div id="dependentes-data" style="display:none">
                    <div class="dps_r col-9">
                    <br><br>    
                        <table id="tbl" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Dependente</th>
                                    <th>Compet. Reembolso</th>
                                    <th>Valor Documento</th>
                                    <th>Observacao</th>
                                    <th>Boleto</th>
                                    <th>Comprovante</th>
                                    <th>Outros</th>
                                    <th>#</th>
                                </tr>
                            </thead>
            
                            <tbody>
            
                            </tbody>
                        </table>
                    </div>
                </div>
            
            </div>                        
    </div> 



        <div id="resumo" class="d-none" style="padding: 0 50px">

            <div class="jumbotron">
                    
                    <h1 class="display-7">
                    <i class="fa-solid fa-check"></i>
                        Confirmar dado(s) de beneficiário(s)?
                    </h1>

            </div>
            <p>     
                <input id="btn_env" class="d-none btn btn-primary" type="submit" value="Confirmar" />
                <input id="btn_cancel" type="button" class="btn btn-danger" style="display:none" value="Cancelar" />
            </p>

        </div>
    
    
        <div class="fx">
            
    
            <p>     
                <input id="btn_confirm" type="button" style="display:none" class="btn btn-info" value="Enviar" />
            </p>
           
            
        </div>
    </form> 
    
   

</div>



<script defer >

    const btn_add_dep       = $("#btn_add_dep");
    const valores           = JSON.parse(`<?= json_encode($funcionarios); ?>`);
    let dependentes         = [];
    let escolhidos          = {};
    let idet_colaborador    = 0;
    const tabela            = $("#tbl");
    const tbody             = tabela.find("tbody");
    const ct_resumo         = $("#resumo");
    const pre_form          = $(".pre-form");
    
    const btn_env           = $("#btn_env");
    const btn_confirm       = $("#btn_confirm");

    const select_comp_folha = $("#folha_comp");
    let current_compp       = '';

    const estrutura = {
        dt_emissao: '',
        valor: 0,
        index_of: 0,
        data_cadastro_folha: '',
        id_folha: '',
        valor_folha: ''
    }
    

    const tr_modelo = `
        <tr>
        <input type="hidden"  name="educacao[colaborador_nome][]" value="@@COLABORADOR@@">
                <input type="hidden"  name="educacao[codigo_dependente][]" value="@@ID_REG@@">
                <input type="hidden"  name="educacao[dependente][]" value="@@NOME@@">
                <input type="hidden"  name="educacao[colaborador][]" value="@@CPF@@">
                <input type="hidden"  name="educacao[valor_disponivel][]" class="vlddx" value="">
                <input type="hidden"  name="educacao[id_valor_teto][]" class="iddfolha" value="">
                <input type="hidden"  name="educacao[index_of][]" class="idxx" value="@@INDEX_OF@@">
            <td data-label="nome">
                @@NOME@@
            </td>

            

            <td data-label="competencia">
                <input type="month"  required class="the_comp" name="educacao[competencia][]" >
            </td> 

            <td data-label="valor">
                <input type="text" required class="the_valor" name="educacao[valor][]" onKeyPress="return(moeda(this,'.',',',event))">
            </td>
            <td data-label="observacao">
                <textarea name="educacao[observacao][]" cols=30 rows=2 maxlength=150></textarea>
            </td>
            
	        <td data-label="boleto">
                <input type="file" name="educacao[boleto][@@INDEX_OF@@][]" id="boleto" accept="application/pdf, image/png, image/jpeg"/>
            </td>

            <td data-label="comprovante">
                <input type="file" name="educacao[comprovante][@@INDEX_OF@@][]" required id="comprovante" accept="application/pdf, image/png, image/jpeg"/>
            </td>

            <td data-label="outros">
                <input type="file" name="educacao[outros][@@INDEX_OF@@][]" id="outros" accept="application/pdf, image/png, image/jpeg"/>
            </td>

            <td>
                <button type="button" class="bt_remover_linha">
                    x
                </button>
            </td>
        </tr>
    `;

    const resumo_modelo = `
        <div class="container_bene">
            <div class="card shadow-lg p-3 mb-5 bg-white rounded">
                    <div class="row">

                        <div class="col-8">
                            <span>Nome</span>
                            <input type="text" value="@@NOME@@" disabled class="form-control">

                        </div>


                        <div class="col-2">
                            <span>Valor Documento</span>
                            <input type="text" value="@@VALOR@@" disabled class="form-control">
                        </div>

                        <div class="col-2">
                            <span>Compet. da folha</span>
                            <input type="text" value="@@COMP_FOLHA@@" disabled class="form-control">
                        </div>
            
                        <div class="col-2">
                            <span>Compet. do reembolso</span>
                            <input type="text" value="@@COMP_RB@@" disabled class="form-control">
                        </div>

                    
                        <div class="col-2">
                            <span>Teto do Benefício</span>
                            <input type='text' value="@@FOLHA_DISP_VALOR@@" disabled class="form-control">
                        </div>

                        <div class="col-2">
                            <span>Data de Cadastro Folha</span>
                            <input type='text' value="@@FOLHA_DISP_DT@@" disabled class="form-control">
                        </div>

                        <div class="col-2">
                            <span>Valor a Reembolsar</span>
                            <input type='text' value="@@VALOR_RESTITUIDO@@" disabled class="form-control">
                        </div>

                        <div class="col-4">
                            <span>Valor disponível para reembolso</span>
                            <input type="text" value="@@VALOR_DISP@@" disabled class="form-control">
                        </div>
                </div>
            </div>     
        </div>
    `;


    const manipula_dependente = {
        select_dependentes: '',
        target: $("#dependentes"),
        init: function(){
            this.select_dependentes = this.target.select2({width: '100%'});
            return this;
        },
        destroy: function(){
            this.select_dependentes.select2('destroy');
            this.select_dependentes =  this.target;
            this.select_dependentes.html(`<option value=''>Selecione</option>`);
            this.select_dependentes.val("").trigger("change");
            return this;
        },
        load: function(data){
            this.select_dependentes.append(data);
        }
    }
    manipula_dependente.init();


    select_comp_folha.on("change", function(){
        const valor = $(this).val() || false;
        let t_comp = $(this).find("option:selected").text().split(" - ");
            t_comp = t_comp.length === 3 ? t_comp[0] : t_comp[1];
            t_comp = t_comp;

        current_compp = valor ? t_comp : '';

        console.log(current_compp);

        $(".the_comp").val("");
    });
    select_comp_folha.trigger("change");
    

    document.addEventListener('DOMContentLoaded', e => {
       // $('#input-colaborador').autocomplete()
    }, false);


    $("#input-colaborador").change( async function(){					
        const getUserID = $(this).val() || false;

        const data = valores.filter( (v) => v.nome == getUserID )[0] || {cpf: '', NUMERO: ''};

        console.log(data);
        $("#idd").val(data.NUMERO);
        $("#cpff").val(data.cpf);
        dependentes = [];
        escolhidos  = [];

            if( getUserID ){
                await $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: `?/educationDependAll/${data.cpf}`,
                    success: function(data){
                        dependentes = [...data];					
                        idet_colaborador = data.cpf;
                        
                    }
                });
            }


            load_dependentes();

    });
        
    $(document).on("click", ".bt_remover_linha", function(e){
        e.preventDefault();
        $(this).get(0).disabled = true;
        const linha = $(this).closest("tr");
        const index = linha.find(".idxx").val();

        delete escolhidos[index];

        linha.fadeOut("slow", ()=>{
            linha.remove();
        });
    });

    $(document).on("change onlychange", ".the_comp", async function(e){
        const {type: tipo_evento} = e;
        const is_original_edit = tipo_evento == "change";

        const valor         = $(this).val() || false;
        const index         = $(this).closest("tr").find(".idxx").val();
        const ipt_id_folha  = $(this).closest("tr").find(".iddfolha");
        const target        = $(this);
        const campo_valor   = target.closest("tr").find(".the_valor");

        ipt_id_folha.val("");

        escolhidos[index].dt_emissao= '';

            if( !valor ){
                $(document).trigger("comp_finish");
                return;
            }
        
        if( !current_compp ){
            swal_error("É necessário selecionar a comp. Folha")
            $(this).val("").trigger("change");
            $(document).trigger("comp_finish");
            return false;
        }

        const d1 = new Date(valor).getTime();
        const d2 = new Date(current_compp).getTime();
        //console.log('braga',d1,d2);

        if( d1 > d2 ){
            swal_error("A compet. Reembolso não pode ser maior que comp. da Folha");
            $(this).val("").trigger("change");
            $(document).trigger("comp_finish");
            return false;
        }

        const cpf_colaborador = escolhidos[index].CPF_COLABORADOR;
        const nome_dependente = escolhidos[index].NOME;
        const id_dependente = escolhidos[index].ID_REG;
       /* const result_busca = escolhidos.filter( (v) => v.NOME == nome_dependente && v.dt_emissao == valor );
            
        if( result_busca.length  > 0 ){
            swal_error("Competência duplicada para o dependente!");
            $(this).val("");
            $(document).trigger("comp_finish");
            return;
        }
*/
        escolhidos[index].dt_emissao = valor;

        const [ano, mes] = valor.split("-");

        const events = [];



        await Promise.all([
            /*********************************************************************************
                Verifica se dependente possui contrato aplicado para a comptencia da folha
            **********************************************************************************/
            $.ajax({
                url: '?/education/ContratoPorCompetencia',
                type: 'POST',
                dataType: 'json',
                data: { 
                    "dependente": id_dependente, 
                    "competencia": valor 
                },
                success: function(response){
                    if(response.length === 0){
                        Swal.fire({
                            title: 'Ausência de contrato',
                            text: `Atenção, este dependente não possui lançamento de contrato vigente para a competência da folha.`,
                            icon: 'info'
                        });

                    }


                },
                error: function(err){
                    swal_error('Falha interna!');
                    console.error(err);
                }
            }),



            /*********************************************************************************
                Obtêm valor do teto
            **********************************************************************************/
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
                        target.val("").trigger("change");
                        return;
                    }
    
                    
                    escolhidos[index].data_cadastro_folha   = response.data_cadastro;
                    escolhidos[index].id_folha              = response.id;
                    escolhidos[index].valor_folha           = response.valor;
                    ipt_id_folha.val(response.id);
                },
                error: function(err){
                    swal_error('Falha interna!');
                    console.error(err);
                }
            }),

            
            /*********************************************************************************
                Se tiver lançamento contratual fornece uma combo com o valor a ser lançado
            **********************************************************************************/
            is_original_edit ? 
            $.ajax({
                url: '?/education/getValorByContrato',
                type: 'POST',
                dataType: 'json',
                data: { 
                    "educacao[dependente]": id_dependente, 
                    "educacao[comp]": valor
                },
                success: async function(response){
    
                    if( !response.status || response.status != "ok" ){
                        swal_error(response.msg);
                        return;
                    }
    

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
    
                    campo_valor.val(value).trigger("keypress");
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

    $(document).on("keypress", ".the_valor", function(){
        const valor = $(this).val();
        const index = $(this).closest("tr").find(".idxx").val();
        escolhidos[index].valor = valor;
    });


    $("#btn_cancel").on("click", function(e){

        location.href="<?=url_for('education/formAll');?>";

    });


    btn_add_dep.on("click", function(e){
        e.preventDefault();

        $('#btn_confirm').show();
        $('#dependentes-data').show();
        
        const valor = manipula_dependente.target.find("option:selected").text() || false;

            if( !valor )
                return;

        const dp = { ...dependentes.filter( (d) => d.NOME == valor)[0], ...estrutura }
        escolhidos.push(dp);
        const index_of = escolhidos.length - 1;

        escolhidos[index_of].index_of = index_of;
        let tr = tr_modelo;
            tr =    tr.replaceAll("@@NOME@@", dp.NOME)
                    .replace("@@ID_REG@@", dp.ID_REG)
                    .replace("@@COLABORADOR@@", dp.COLABORADOR)
                    .replace("@@CPF@@", dp.CPF_COLABORADOR)
                    .replaceAll("@@INDEX_OF@@", index_of)


        tbody.append(tr);

    });

    manipula_dependente.target.on("change", function(){
        const valor = $(this).val() || false;
        btn_add_dep.get(0).disabled = valor ? false : true;
    });

    btn_confirm.on("click", async function(e){
        e.preventDefault();
        $('#mainDiv').hide();
        $('#btn_cancel').show();


        if( Array.from(escolhidos).filter( e => e ).length <= 0 ){
            swal_error("É necessário adicionar os dependentes!");
            return;
        }

        const el_pendentes = Array.from(tbody.get(0).querySelectorAll("input[required]")).filter( el => !( el.value || false  ) ).length;

        if( el_pendentes > 0 ){
            swal_error("Preencha todos os campos obrigatórios!");
            $('#mainDiv').show();

            btn_env.click();
            return;
        }

        //REFAZENDO OS AJAX
            const campos_comp = $(".the_comp");
            for(let i = 0; i < campos_comp.length; i++){
                campos_comp.eq(i).trigger("onlychange");
                await new Promise((resolve)=>{
                    $(document).on("comp_finish", function(){
                        resolve('');
                    })
                })
            }
        //REFAZENDO OS AJAX

        tabela.addClass("d-none");
        ct_resumo.removeClass("d-none");
        pre_form.addClass("d-none");

        $(this).addClass("d-none");
        btn_env.removeClass("d-none");

        const escolhidos_filtrados = escolhidos.filter( e => e )
        const dt_comp_selecionada = select_comp_folha.find("option:selected").text().split(" - ")[0];

        let need_break = false;
        for( const escolhido of escolhidos_filtrados ){

            if( need_break ) { break; }


            await $.ajax({
                url: '?/education/getValorDependenteByComp',
                type: 'POST',
                dataType: 'JSON',
                data: { 
                        'educacao[nome]': escolhido.NOME,
                        'educacao[comp]': escolhido.dt_emissao,
                        'educacao[valor_enviado]': escolhido.valor,
                        'educacao[cpf_colaborador]': escolhido.CPF_COLABORADOR,
                        'educacao[valor_folha]': escolhido.valor_folha
                },
                    success: function(response){
                        if( !response.status || response.status != "ok" ){
                            swal_error(`${response.msg}`);
                            need_break = true;
                            return;
                        }
                        escolhido.valor_disp = response.valor;
                    },
                    error: function(fail){
                        swal_error("Problema interno!");
                        console.warn(fail)
                    }
            })

            let valorUtilizado = 0.00;
                if (parseFloat(escolhido.valor_disp) > 0) valorUtilizado = escolhido.valor_disp;

            let valorReembolsado = 0;
                if (parseFloat(valorUtilizado) > 0)
                    valorReembolsado = escolhido.valor_folha.replace('.','').replace(',','.') - valorUtilizado.replace('.','').replace(',','.'); //valor a ser restituido pelo colaborador

            let valorDisponivelReembolso = 0.00;
                if (parseFloat(escolhido.valor_disp) > 0)
                    valorDisponivelReembolso = escolhido.valor_disp;
        
            
            console.log('ECOM',escolhido);
            let copy_resumo = resumo_modelo;
                copy_resumo = copy_resumo
                                .replace("@@NOME@@", escolhido.NOME)
                                .replace("@@CPF@@", escolhido.CPF_COLABORADOR)
                                .replace("@@COMP_FOLHA@@", dt_comp_selecionada)
                                .replace("@@COMP_RB@@", escolhido.dt_emissao)
                                
                                .replace("@@VALOR@@", escolhido.valor)
                                .replace("@@FOLHA_DISP_VALOR@@", escolhido.valor_folha)
                                .replace("@@FOLHA_DISP_DT@@", escolhido.data_cadastro_folha)
                                .replace("@@VALOR_RESTITUIDO@@", formata_para_moeda(valorReembolsado))
				                .replace("@@VALOR_DISP@@", valorDisponivelReembolso)

            ct_resumo.append(copy_resumo);

            $(`.idxx[value=${escolhido.index_of}]`).closest("td").find(".vlddx").val(escolhido.valor_disp);
        }


    });


    const load_dependentes = ()=>{
        manipula_dependente.destroy();
            for(const dt of dependentes ){
                manipula_dependente.load(`<option value='${dt.CPF_COLABORADOR}'>${dt.NOME}</option>`);
            }
        manipula_dependente.init();
    }


	

</script>

