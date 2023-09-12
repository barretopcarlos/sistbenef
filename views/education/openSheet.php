
<div class="container" style="margin-bottom: 100px;">

    <div>
        <label><b>Gestão da Folha</b></label>
        <select name="educacao[comp_folha]" id="comp_folha" class="form-select">
            <option value="">Selecione</option>
            <option value="add">Cadastrar Nova</option>
            <?= $infos_opcoes; ?> 
        </select>
    
        <button type="button" class="is_btn btn btn-primary col-2" id="abrir_folha">Abrir Folha</button>
        <button type="button" class="is_btn btn btn-success col-2" id="reabrir_folha">Reabrir Folha</button>
        <button type="button" class="is_btn btn btn-danger col-2" id="fechar_folha">Fechar Folha</button>
    </div>
    <hr>
    
    <form action="" class="fx">
        <div class="tab">
            <div>
                <label for="">Tipo de Folha</label></br>
                <select name="educacao[tipo_folha]" class="readable" id="tipo_folha" class="form-select" style="width:150px;" required>
                    <option value="" required>Selecione</option>
                    <option value="mensal">Mensal</option>
                    <option value="suplementar">Suplementar</option>
                </select>
            </div>
            <br><br>
            
            <div>
                <label for="">Competência Folha</label>
                <input class="form-control" style="border: 1px solid #ccc; border-radius: 4px; padding: 4px 6px;" type="month" style="border: 1px solid #ccc; border-radius: 4px; padding: 4px 6px;" name="educacao[competencia]" class="readable" id="competencia">
            </div>
            <br><br>
            
            <!--- ABERTURA -->
                <div>
                    <label for="">Data Abertura</label>
                    <input class="form-control" style="border: 1px solid #ccc; border-radius: 4px; padding: 4px 6px;" type="date" name="educacao[data_abertura]" class="readable" id="data_abertura">
                </div>
                <br><br>
            
                <div>
                    <label for="">Responsável pela Abertura</label>
                    <input class="form-control" value="<?=$_SESSION['username']?>" style="border: 1px solid #ccc; border-radius: 4px; padding: 4px 6px;" type="text" id="responsavel_abertura" disabled>
                </div>
                <br>
                <hr>
                <br>
            <!--- ABERTURA -->
            
            <!--- RE-ABERTURA -->
                <div>
                    <label for="">Data Reabertura</label>
                    <input class="form-control" style="border: 1px solid #ccc; border-radius: 4px; padding: 4px 6px;" type="text" id="data_reabertura" disabled>
                </div>
                <br><br>
            
                <div>
                    <label for="">Responsável pela Reabertura</label>
                    <input class="form-control" style="border: 1px solid #ccc; border-radius: 4px; padding: 4px 6px;" type="text" id="responsavel_reabertura" disabled>
                </div>
                <br>
                <hr>
                <br>
            <!--- RE-ABERTURA -->
            
            <!--- RE-ABERTURA -->
                <div>
                    <label for="">Responsável pela Consolidação</label>
                    <input class="form-control" style="border: 1px solid #ccc; border-radius: 4px; padding: 4px 6px;" type="text" id="responsavel_consolidacao" disabled>
                </div>
                <br><br>
            
                <div>
                    <label for="">Data de Consolidação</label>
                    <input class="form-control" style="border: 1px solid #ccc; border-radius: 4px; padding: 4px 6px;" type="text"  id="data_consolidacao" disabled>
                </div>
                <hr>
                <br><br>
            <!--- RE-ABERTURA -->
        </div>
    
        <div class="tab">
            <div>
                <label for="">Total de Beneficiários</label>
                <input class="form-control" style="border: 1px solid #ccc; border-radius: 4px; padding: 4px 6px;" type="text" id="total_beneficiarios" disabled>
            </div>
            <br><br>
    
            <div>
                <label for="">Valor Total da Folha</label>
                <input class="form-control" style="border: 1px solid #ccc; border-radius: 4px; padding: 4px 6px;" type="text" id="valor_total_folha" disabled>
            </div>
            <br><br>
    
            <div>
                <label for="">Data do Crédito</label>
                <input class="form-control" style="border: 1px solid #ccc; border-radius: 4px; padding: 4px 6px;" type="text" id="data_do_credito" disabled>
            </div>
            <br><br>
    
    
        </div>
    </form>

</div>



<script defer>
    const select_escolher_folha = $("#comp_folha");
    const btn_abrir_folha       = $("#abrir_folha").get(0);
    const btn_reabrir_folha     = $("#reabrir_folha").get(0);
    const btn_fechar_folha      = $("#fechar_folha").get(0);
    const formulario            =  $("form").eq(0);
    let id                      = 0;
    let estado                  = '';


    window.onload = ()=>{
        select_escolher_folha.trigger("change");
    }
    

    select_escolher_folha.on("change", function(){
        const  valor = $(this).val() || false;
        estado = '';
        clear_all();
        disable_or_enable(true);
        disable_enable_btns();

            if( ! valor ) return;

            if( valor == "add" ){
                disable_or_enable(false);
                allow_create(true);
                estado = 'create';
                return false;
            }else{
                load_data(valor);
            }

    });

    


    const disable_or_enable = (condition = true)=>{
        document.querySelectorAll(".readable").forEach((elemento) =>{
            elemento.disabled = condition;
        });
    }
    disable_or_enable();


    const disable_enable_btns = (condition = true)=>{
        document.querySelectorAll(".is_btn").forEach((elemento) =>{
            elemento.disabled = condition;
        });
    }
    disable_enable_btns();

    const clear_all = ()=>{
        document.querySelectorAll(".fx input, .fx select").forEach((elemento) => {
            elemento.value = '';
        })
    }

    const allow_create  = (condition = false)=>{
        // btn_add.disabled = !condition;
        btn_abrir_folha.disabled = !condition;
    }

    const allow_edit = (condition = false)=>{
        btn_reabrir_folha.disabled  = !condition;
        btn_fechar_folha.disabled   = !condition;
    }

    const load_data = (valor) =>  {

        $.ajax({
            url: `?/education/getInfoSheet/${valor}`,
            dataType: 'JSON',
            success: function(response){
                
                if( !response || response.length <= 0 )
                    return;

                id = response.id;

                for( const index in response ){
                    const valor             = response[index];
                    const procurar_elemento = $(`#${index}`);
                    procurar_elemento.val(valor);
                }


                if( response.status == "aberto" ){
                    btn_fechar_folha.disabled       = false;
                }else if( response.status == "fechado" ){
                    btn_reabrir_folha.disabled= false;
                }
            },
            error: function(fail){
                swal_error('Falha interna!');
                console.log(fail);
            }
        });
    }
    

    $(btn_abrir_folha).on("click", async function(){
        const confirma = await swal_confirma();
        if( !confirma )
            return;

        if( estado == 'create' ){
            send_create();
        }
    });

    $(btn_fechar_folha).on("click", async function(){
        const confirma = await swal_confirma();
            if( !confirma )
                return;

        send_edit('fechado');
    });

    $(btn_reabrir_folha).on("click", async function(){
        const confirma = await swal_confirma();
            if( !confirma )
                return;

        send_edit('aberto');
    });

    const send_edit = async (status)=>{

        const valor_atual = select_escolher_folha.val();
        var     all_ok    = false;
        const tipo_folha = $("#tipo_folha").val();

        await $.ajax({
            url: '?/education/sheetChangeStatus',
            type: 'post',
            data: {
                'educacao[id_folha]' : id,
                'educacao[status]' : status,
                'educacao[tipo_folha]': tipo_folha
            },
            success: function(response){
                if( response != "ok" ){
                    swal_error(`${response}`);
                    return;
                }

                swal_sucesso('Folha atualizada');
                all_ok = true;
                
            },
            error: function(fail){
                swal_error('Erro interno!');
                console.log(fail);
            }
        });

        if( all_ok ){
            await load_the_data();
            select_escolher_folha.val(valor_atual).trigger("change");
        }
    }

    const send_create = ()=>{

        const infos = new FormData(formulario.get(0));

        $.ajax({
            url: '?/education/createSheet',
            data: infos,
            type: 'POST',
            contentType: false,
            processData: false,
                success: function(response){
                    if( response != "ok"){
                        swal_error(`${response}`);
                        return;
                    }
                    load_the_data();
                    swal_sucesso('Folha criada com sucesso');
                },
                error: function(fail){
                    swal_error('Falha interna');
                    console.log(fail)
                }
        });
    }

    const load_the_data = async ()=>{
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '?/education/getFolhasPagamentos',
                success: function(response){
                    select_escolher_folha.html(`
                        <option value="">Selecione</option>
                        <option value="add">Cadastrar Nova</option>
                        ${response}
                    `)
                    return resolve();
                },
                error: function(fail){
                    swal_error();
                    console.log(fail);
                    return reject();
                },
            });
        })
    }

</script>