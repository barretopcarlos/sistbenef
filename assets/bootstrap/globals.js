function moeda(a, e, r, t) {
    let n = ""
      , h = j = 0
      , u = tamanho2 = 0
      , l = ajd2 = ""
      , o = window.Event ? t.which : t.keyCode;
    if (13 == o || 8 == o)
        return !0;
    if (n = String.fromCharCode(o),
    -1 == "0123456789".indexOf(n))
        return !1;
    for (u = a.value.length,
    h = 0; h < u && ("0" == a.value.charAt(h) || a.value.charAt(h) == r); h++)
        ;
    for (l = ""; h < u; h++)
        -1 != "0123456789".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
    if (l += n,
    0 == (u = l.length) && (a.value = ""),
    1 == u && (a.value = "0" + r + "0" + l),
    2 == u && (a.value = "0" + r + l),
    u > 2) {
        for (ajd2 = "",
        j = 0,
        h = u - 3; h >= 0; h--)
            3 == j && (ajd2 += e,
            j = 0),
            ajd2 += l.charAt(h),
            j++;
        for (a.value = "",
        tamanho2 = ajd2.length,
        h = tamanho2 - 1; h >= 0; h--)
            a.value += ajd2.charAt(h);
        a.value += r + l.substr(u - 2, u)
    }
    return !1
}	

function formata_para_moeda(valor){
    valor = new Intl.NumberFormat('pt-BR', {style: 'currency',currency: 'BRL', minimumFractionDigits: 2})
          .format(`${valor}`)
          .replace("R$", "")
          .trim()
    return valor;
}

const swal_confirma = async ()=>{
    const { isConfirmed: confirmou } = await Swal.fire({
        title:'Confirma a ação?',
        icon: 'success',
        showCancelButton: true,
        cancelButtonText: 'Cancelar'
    })
    return confirmou;
}

const swal_error = (error = 'Falha Interna') =>{
    Swal.fire({
        title: 'Erro:',
        text: `${error}`,
        icon: 'error'
    });
}

const swal_sucesso = (msg = '') =>{
    Swal.fire({
        title: 'Sucesso',
        text: `${msg}`,
        icon: 'success'
    });
}

const swal_info = (title = 'Atenção', info = '') =>{
    Swal.fire({
        title: "<strong>"+`${title}`+"</strong>",
        text: `${info}`,
        icon: 'info'
    });
}

(()=>{

    $('select.selectize').each(function(){
        const id = $(this).attr("id") || false;
    
        const dt = $(this).selectize({
            sortField: 'text'
        });
        
        if( id ){
            window[`select_${id}`] = dt[0].selectize;
        }
    });

    $("select.s2").each(function(){
        $(this).select2({width: '100%'})
    });
    
    let eventos_in_handler = 0;

    $(document).bind("ajaxStart", ()=>{
        eventos_in_handler++;
        $(".loading").addClass("on");
    });

    $(document).bind("ajaxStop", ()=>{
        eventos_in_handler--;
        if( eventos_in_handler <= 0 ){
            $(".loading").removeClass("on")
        }
    });


})();






