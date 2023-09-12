$(document).ready(function() {

    // Por padrão, desabilita os campos
    //$('#moeda').prop('disabled', true);
    $('#requerente').prop('disabled', true);
    $('#beneficiario').prop('disabled', true);

    /**
     * Evento de clique no campos files
     */
    $(".btn-file").click(function() {
         let input = '#'+$(this).data("option");
         $(input).click();
    });

    /***
     * Limpar Formulário
     */
    $("#btnLimpar").on('click',function() {
        $("#frmReembolso")[0].reset();
        $("#beneficio").val(null).trigger("change");
        $("#requerente").val(null).trigger("change");
        $("#beneficiario").val(null).trigger("change");
        $("#tipoDocumento").val(null).trigger("change");
        $("#cbContrato").val(null).trigger("change");
        $("#infoAdicional").val(null).trigger("change");
        //document.getElementById('customFile').textContent = "Nenhum arquivo Escolhid";
        const labels = document.querySelectorAll('.customFile');
        labels.forEach(function(label) {
            label.textContent = "Nenhum arquivo Escolhido";
        });
    });

    $("select").each(function(){
        $(this).select2(
            {   width: '100%',
                height:'40px',
                theme: 'bootstrap',
            }
        )
    });

    function aplicarMascaraCPF() {
        $("#cpf").mask('000.000.000-00', {reverse: true});
    }

    function aplicarMascaraCNPJ() {
        $("#cpf").mask('00.000.000/0000-00', {reverse: true});
    }

    $("#cpf").change(function() {
        if ( $("#infoAdicional").val() === "CPF") {
            aplicarMascaraCPF();
        } else if ( $("#infoAdicional").val() === "CNPJ") {
            aplicarMascaraCNPJ();
        } else {
            $("#cpf").unmask();
        }
    });

    $("#infoAdicional").change('#cpf',function() {
        if ($(this).val() === "CPF") {
            aplicarMascaraCPF();
        } else if ($(this).val() === "CNPJ") {
            aplicarMascaraCNPJ();
        } else {
            $("#cpf").unmask();
        }
        let cpf = $(this).val() !== "" ? $(this).val() : 'CPF:';
        $('#labelCpf').html(cpf);
        $("#cpf").attr('placeholder','Digite Número do ' + cpf);
    });

    function updateCurrencyMask() {
        let isInternational = $("input[name='reembolsoInternacional']:checked").val() === "sim";
        //let currency = $("#moeda").find(':selected').data('alias'); //$('#moeda').val();

        $('#moeda').prop('disabled', true);
        $("#divMoeda").css("display", "none");
        $("#valorMoeda").attr('placeholder','R$ 0,00');

        if (isInternational) {
            $('#moeda').prop('disabled', false);
            $("#divMoeda").css("display", "block");
            $("#valorMoeda").attr('placeholder','');
            $("#valorMoeda").val('');
        }
    }

    // Atualiza a máscara sempre que a opção de reembolso internacional mudar
    $("input[name='reembolsoInternacional']").change(updateCurrencyMask);

    // Quando o valor do reembolso internacional mudar
    $('input[name="reembolsoInternacional"]').change(function() {
        // Se for "Sim", habilita o campo de moeda
        if ($(this).val() == 'sim') {
            $('#moeda').prop('disabled', false);
            $('#labelMoeda').html("Valor Moeda Estrangeira:");
            $('#labelModalMoeda').html("Valor Moeda Estrangeira:");
        } else {
            // Se for "Não", desabilita o campo de moeda
            $('#moeda').prop('disabled', true);
            $('#labelMoeda').html("Valor Moeda Brasileira:");
            $('#labelModalMoeda').html("Valor Moeda Brasileira:");
            $('#moeda').val(null).trigger("change");
        }
    });

    function validarCPF(cpf) {
        cpf = cpf.replace(/[^\d]+/g, '');
        if (cpf === '') return false;
        // Elimina CPFs invalidos conhecidos
        if (cpf.length !== 11 ||
            cpf === "00000000000" ||
            cpf === "11111111111" ||
            cpf === "22222222222" ||
            cpf === "33333333333" ||
            cpf === "44444444444" ||
            cpf === "55555555555" ||
            cpf === "66666666666" ||
            cpf === "77777777777" ||
            cpf === "88888888888" ||
            cpf === "99999999999")
            return false;
        // Valida 1o digito
        add = 0;
        for (i = 0; i < 9; i++) add += parseInt(cpf.charAt(i)) * (10 - i);
        rev = 11 - (add % 11);
        if (rev === 10 || rev === 11) rev = 0;
        if (rev !== parseInt(cpf.charAt(9))) return false;
        // Valida 2o digito
        add = 0;
        for (i = 0; i < 10; i++) add += parseInt(cpf.charAt(i)) * (11 - i);
        rev = 11 - (add % 11);
        if (rev === 10 || rev === 11) rev = 0;
        if (rev !== parseInt(cpf.charAt(10))) return false;
        return true;
    }

    function validarCNPJ(cnpj) {
        cnpj = cnpj.replace(/[^\d]+/g, '');
        if (cnpj === '') return false;
        if (cnpj.length !== 14) return false;
        // Elimina CNPJs invalidos conhecidos
        if (cnpj === "00000000000000" ||
            cnpj === "11111111111111" ||
            cnpj === "22222222222222" ||
            cnpj === "33333333333333" ||
            cnpj === "44444444444444" ||
            cnpj === "55555555555555" ||
            cnpj === "66666666666666" ||
            cnpj === "77777777777777" ||
            cnpj === "88888888888888" ||
            cnpj === "99999999999999")
            return false;
        // Valida DVs
        let tamanho = cnpj.length - 2;
        let numeros = cnpj.substring(0, tamanho);
        let digitos = cnpj.substring(tamanho);
        let soma = 0;
        let pos = tamanho - 7;
        for (let i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) pos = 9;
        }
        let resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado !== parseInt(digitos.charAt(0))) return false;
        tamanho = tamanho + 1;
        numeros = cnpj.substring(0, tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (let i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado !== parseInt(digitos.charAt(1))) return false;
        return true;
    }


    /**
     * Evento de envio do formulário
     */
    $("#frmReembolso").on("submit", function(e) {
        e.preventDefault();

        let partes = "";
        let nomeArquivo = "";
        let tamanho = "";
        let radioIntenacional = null;
        let tipoMoeda;
        let opcoes;
        let moeda = "";

       // 1. Validando a Competência da folha de benefícios
        if ($("#competenciaBeneficios").val() === "") {
            swal_info("Atenção","Por favor, selecione uma Competência da Folha de Benefícios.");
            return;
        }

        // 2. Validando a Competência do reembolso
        if ($("#competenciaReembolso").val() === "") {
            swal_info("Atenção","Por favor, selecione uma Competência de Reembolso.");
            return;
        }

        // 3. Validando Tipo de Benefício
        if ($("#beneficio").val() === "") {
            swal_info("Atenção","Por favor, selecione um Tipo de Benefício.");
            return;
        }

        // 5. Validando Requerente
        if ($("#requerente").val() === "") {
            swal_info("Atenção","Por favor, selecione o Requerente.");
            return;
        }

        // 6. Validando Beneficiário do reembolso
        if ($("#beneficiario").val() === "") {
            swal_info("Atenção","Por favor, selecione um Beneficiário do Reembolso.");
            return;
        }

        // 7. Validando Tipo de documento
        if ($("#tipoDocumento").val() === "") {
            swal_info("Atenção","Por favor, selecione um Tipo de Documento.");
            return;
        }

        // 8. Validando Comprovante
        if ($("#comprovantePagamento").get(0).files.length === 0) {
            swal_info("Atenção","Por favor, faça o upload do Comprovante de Pagamento.");
            return;
        }

        // 9. Validando Reembolso internacional
        if ($("input[name='reembolsoInternacional']:checked").val() === "sim" && $("#moeda").val() === "") {
            swal_info("Atenção","Por favor, selecione a Moeda do Reembolso Internacional.");
            return;
        }

        // 10. Validando moeda
        if ($("input[name='reembolsoInternacional']:checked").val() === "nao" && $("#valorMoeda").val() === "") {
            swal_info("Atenção","Por favor, preencha o valor em Moeda Real.");
            return;
        }

        // 11.
        if($("#cpf").val() !== "") {
            if ($("#infoAdicional").val() === "CPF" && !validarCPF($("#cpf").val())) {
                swal_info("Atenção", 'Por favor, insira um CPF válido.');
                return;
            }

            if ($("#infoAdicional").val() === "CNPJ" && !validarCNPJ($("#cpf").val())) {
                swal_info("Atenção", 'Por favor, insira um CNPJ válido.');
                return;
            }
        }

        // 12. Validando Valor a ser reembolsado
        if ($("input[name='reembolsoInternacional']:checked").val() === "sim" && $("#valorMoeda").val() === "") {
            swal_info("Atenção","Por favor, preencha o valor em moeda estrangeira para Reembolso Internacional.");
            return;
        }


        /**
         * Pega os dados do Form e joga na modal
         * */

        $("#modalCompetencia").html(converterFormato($('#competenciaBeneficios option:selected').text()));

        $("#modalReembolso").html(converterDataParaTexto($('#competenciaReembolso').val()));

        $("#modalBeneficio").html($('#beneficio option:selected').text());

        $("#modalBeneficiario").html($('#beneficiario option:selected').text());

        $("#modalTipoDocumento").html($('#tipoDocumento option:selected').text());

        $("#modalContrato").html($('#cbContrato option:selected').val() !== "" ? $('#cbContrato option:selected').text()  : '-');

        if ($('#boleto').val() !== "") {
            partes = $('#boleto').val().split("\\");
            nomeArquivo = partes[partes.length - 1];
            tamanho = $('#boleto')[0].files[0];
            $("#modalBoleto").html("<i class=\"bi bi-check-circle-fill text-success\"></i>&nbsp;" + nomeArquivo + " (" + bytesToKB(tamanho.size) +"&nbsp;kb" +")");
        }
        /**
         * Esse é obrigatório
         * */
            partes = $('#comprovantePagamento').val().split("\\");
            nomeArquivo = partes[partes.length - 1];
            tamanho = $('#comprovantePagamento')[0].files[0];
            $("#modalComprovante").html("<i class=\"bi bi-check-circle-fill text-success\"></i>&nbsp;" + nomeArquivo + " (" + bytesToKB(tamanho.size) +"&nbsp;kb" +")");

        if ($('#outros').val() !== "") {
            partes = $('#outros').val().split("\\");
            nomeArquivo = partes[partes.length - 1];
            tamanho = $('#outros')[0].files[0];
            $("#modalOutros").html("<i class=\"bi bi-check-circle-fill text-success\"></i>&nbsp;" + nomeArquivo + " (" + bytesToKB(tamanho.size) +"&nbsp;kb" +")");
        }

        opcoes = document.getElementsByName('reembolsoInternacional');
        for (let i = 0; i < opcoes.length; i++) {
            if (opcoes[i].checked) {
                radioIntenacional = opcoes[i].value === "nao" ? "Não" : "Sim" ;
                tipoMoeda = opcoes[i].value === "nao" ? false : true; //se for não é nacional
                break; // Sair do loop assim que encontrar a opção selecionada
            }
        }
        $("#modalReembolsoInternacional").html(radioIntenacional);

        $("#modalMoeda").html(tipoMoeda === false ? "Real R$" : $('#moeda option:selected').text());

        $("#modalValorMoeda").html($('#valorMoeda').val());

        if($("#cpf").val() !== "") {
            const infoAdicional = $('#infoAdicional option:selected').text();
            $("#cpf").val() !== "" ? $("#modalInfoAdicionais").html(infoAdicional + " - " + $('#cpf').val()) : '-';
        }else{
            $("#modalInfoAdicionais").html('-');
        }

        $("#modalObservacoes").html($('#observacao').val() !== "" ? $('#observacao').val() : '-');

       // Mostra o modal de confirmação
        const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        confirmationModal.show();

    });

    function atualizarMascara(moeda) {

        if (moeda === 'euro') {
            $('#valorMoeda').inputmask("currency", { numericInput: true, rightAlign: false, alias: 'numeric', prefix: '€ ' });
        } else if (moeda === 'dolar') {
            $('#valorMoeda').inputmask("currency", { numericInput: true, rightAlign: false, alias: 'numeric', prefix: 'US$ ' });
        }else {
            $('#valorMoeda').inputmask("currency", { radixPoint:",",numericInput: true, rightAlign: false, alias: 'numeric', prefix: 'R$ ' });
        }
    }

    // Monitorar a seleção do usuário e atualizar a máscara
    $("#moeda").change(function() {
        const moedaSelecionada = $("#moeda").find(':selected').data('alias') ;

       // console.log("tipo > " + moedaSelecionada);
        atualizarMascara(moedaSelecionada);
        $('#valorMoeda').val('').trigger('input'); // Limpar o campo ao trocar a moeda
    });

    // Inicialize a máscara com a opção padrão (Real)
    atualizarMascara('real');
});


$("#confirmForm").on('click',  function(){
    Swal.fire({
        title: 'Deseja Prosseguir com o Solicitação de Reembolso?',
        showCancelButton: true,
        confirmButtonText: 'Salvar',
        cancelButtonText: 'Cancelar',
        icon: 'question'
    }).then((result) => {
        if (result.isConfirmed) {
           const form = document.getElementById('frmReembolso');
           let formData = new FormData($(form)[0]);

            if($('#hiddenPerfil').val() == "analista"){
                formData.append("colaborador", $("#requerente").find(':selected').data('cpf'));
                formData.append("colaboradorNome", $('#requerente option:selected').text().trim());
                formData.append("dependente", $("#beneficiario").find(':selected').data('cpf'));
                formData.append("dependenteNome",  $('#beneficiario option:selected').text().trim());
            }else{
                formData.append("colaborador", $("#beneficiario").find(':selected').data('cpf'));
                formData.append("colaboradorNome", $('#beneficiario option:selected').text().trim());
                formData.append("dependente", '');//$("#beneficiario").find(':selected').data('cpf'));
                formData.append("dependenteNome",  '');//$('#beneficiario option:selected').text().trim());
            }

            formData.append("competenciaBeneficios", $('#competenciaBeneficios option:selected').text().trim());
            formData.append("data_cadastro", new Date().getTime());
            formData.append("beneficioTiposId",$('#beneficio').val());
            formData.append("competenciaReembolso", $('#competenciaReembolso').val());
            formData.append("lancamentoContratual", $('#cbContrato').val());
            formData.append("moeda", $('#moeda').val() === "" ? $('#moedaHidden').val() : $('#moeda').val());
            formData.append("tipoMoeda", $('#moeda').val() === "" ? 'real' : $("#moeda").find(':selected').data('alias'));

            $.ajax({
                url:'?/reembolso/cadastrarReembolso',
                type: 'POST',
                dataType: 'JSON',
                data: formData,
                processData: false, // Não processar os dados
                contentType: false, // Não defina o tipo de conteúdo
                enctype: 'multipart/form-data',

                success: function(response){
                    //console.log(response);

                    if(!response.success){
                       swal_error(response.msg);
                        return;
                    }

                    // Remove o modal de confirmação
                    const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
                    confirmationModal.hide();

                    Swal.fire(
                        'Sucesso',
                        'Solicitação de Reembolso Concluída com Sucesso. \n\n <strong>Número de Protocolo</strong>\n' + response.protocolo,
                        'success'
                    ).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                })

                },
                error: function(fail){
                    swal_error("Ocorreu um erro interno, tente mais tarde!");
                }
            })
        }
    });
});
/**
 * Convert em KB o arquivo
 * */
function bytesToKB(bytes) {
    return (bytes / 1024).toFixed(2); // Arredonde para 2 casas decimais
}


/**
 * Regra para quando selecionar o requerente mostrar o beneficiário
 * */
$("#requerente").change( async function(){
    //const getUserCPF = $(this).val() || false;
    const idFuncional = $(this).val() || false;
    const getUserCPF = $(this).find(':selected').data('cpf') || false;
    const tipoBeneficio  = $('#beneficio').find(':selected').data('tipo');

   // console.log(tipoBeneficio);

    if( idFuncional ){
        await $.ajax({
            type: 'GET',
            dataType: 'JSON',
            //url: `?/educationDependAll/${getUserCPF}`,
            url: `?/reembolso/loadBeneficiario/${idFuncional}/${tipoBeneficio}`,
            success: function(data){
                //console.log(data);

                const select = document.getElementById('beneficiario');

                // Limpe todas as opções existentes
                select.innerHTML = '<option value=\"\">Selecione o Beneficiário</option>';

                data.forEach(optionData => {
                    const option = document.createElement('option');
                    option.value =optionData.id_funcional;
                    option.text = optionData.nome;
                    option.setAttribute("data-cpf", optionData.cpf);
                    option.setAttribute("data-cpf-requerente", getUserCPF);
                    select.appendChild(option);
                });
            }
        });
    }
});

/**
 * Ao abrir o select busca as informações do beneficiario
 * */
//$("#beneficio").on("select2:open",  function (e) {
    // Realizar ação ao abrir o Select2

$("#beneficio").on("change",  function (e) {
    if($(this).val() !== "") {
        const idFuncional = $("#hiddenIdFuncional").val(); //9999999
        const tipoBeneficio = $(this).find(':selected').data('tipo');
        const cpfRequerente = $("#hiddenCpfRequerente").val(); //9999999
        const select = document.getElementById('beneficiario');

        /**
         *  Ao selecioanr o benefico relaiza algumas ações
         * */

        $("#requerente").prop("disabled", false);
        $("#beneficiario").prop("disabled", false);
        if($(this).val() === "") {
            $("#requerente").prop("disabled", true);
            $("#beneficiario").prop("disabled", true);

        }
        $("#requerente").val(null).trigger("change");
        $("#beneficiario").val(null).trigger("change");

       // console.log(idFuncional + " " + tipoBeneficio + " " + cpfRequerente);
        $.ajax({
            type: 'GET',
            dataType: 'JSON',
            url: `?/reembolso/loadBeneficiario/${idFuncional}/${tipoBeneficio}`,
            success: function (data) {
                //console.log(data);

                // Limpe todas as opções existentes
                select.innerHTML = '<option value=\"\">Selecione o Beneficiário</option>';
                data.forEach(optionData => {
                    const option = document.createElement('option');
                    option.value = optionData.id_funcional;
                    option.text = optionData.nome;
                    option.setAttribute("data-cpf", optionData.cpf);
                    option.setAttribute("data-cpf-requerente", cpfRequerente);
                    select.appendChild(option);
                });

            },
            error: function (fail) {
                swal_error("Ocorreu um erro interno, tente novamente mais tarde!");
            }
        });
    }
});
/**
 * Ao selecionar o beneficiário, busca as informações de contrato
 * */
$("#beneficiario").change( async function(){
    if($(this).val() !== "") {

        let idDependente = $(this).val();
        let cpfRequerente = $(this).find(':selected').data('cpf');
        let idBeneficio = $('#beneficio').val();
        let select = document.getElementById('cbContrato');
        // console.log("idBeneficio: " + idBeneficio, "cpfRequerente: " + cpfRequerente, "idDependente: " + idDependente);

        await $.ajax({
            type: 'GET',
            dataType: 'JSON',
            url: `?/reembolso/contratoPorBeneficio/${cpfRequerente}/${idDependente}/${idBeneficio}`,
            success: function (data) {
                console.log(data);
               if (data !== "") {
                    $("#btnEnviar").prop("disabled", false);

                    // Limpe todas as opções existentes
                    select.innerHTML = '<option value=\"\">Selecione o Contrato</option>';

                    data.forEach(optionData => {
                        const option = document.createElement('option');
                        option.value = optionData.id;
                        option.text = optionData.identificacao_contrato + " - " + formata_para_moeda(optionData.total);
                        select.appendChild(option);
                    });
                }

            }
        });
    }
});

/**
 * Converte a data
 * entrada : 2023-05
 * saida : maio de 2023
 * */
function converterDataParaTexto(data) {
    const partes = data.split('-'); // Divide a data em ano e mês
    const ano = partes[0];
    const mesNumerico = parseInt(partes[1], 10); // Converte o mês em número

    // Array de nomes de meses
    const nomesDosMeses = [
        'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
        'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
    ];

    // Obtém o nome do mês correspondente
    const nomeDoMes = nomesDosMeses[mesNumerico - 1]; // O índice começa em 0

    // Monta o texto
    const texto = `${nomeDoMes} de ${ano}`;

    return texto;
}

/**
 * Converte formato
 * entrada: 2023-05 - mensal
 * saida: 05/2023 - mensal
 * */
function converterFormato(data) {

    // Use uma expressão regular para extrair o ano e o mês
    const regex = /^(\d{4})-(\d{2}) - (.+)$/;
    const matches = data.match(regex);

    if (matches && matches.length === 4) {
        const ano = matches[1];
        const mes = matches[2];
        const descricao = matches[3];

        // Crie o novo formato
        const novoFormato = `${mes}/${ano} - ${descricao}`;
        return novoFormato;
    } else {
        // Retorna a entrada original se não corresponder ao formato esperado
        return data;
    }
}

/**
 * Função para atualizar o nome do arquivo exibido no label
 */

function updateFileName(input) {
    var label = input.nextElementSibling;
    var fileName = input.files[0].name;
    label.innerText = fileName;
}