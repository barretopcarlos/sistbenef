$(document).ready(function() {
    var dadosBancarios = jsonData; 
    
    $('#beneficioTable').DataTable({
        responsive: true,
        data: dadosBancarios,
        columns: [
            { data: 'id', title: 'ID' },
            { data: 'codigo_banco', title: 'Cód. Banco Benefício' },
            { data: 'nome_banco_beneficio', title: 'Banco Benefício'},
            { data: 'agencia', title: 'Agência Benefício' },
            { data: 'conta_corrente', title: 'Conta Benefício'},
            { data: 'banco_pagamento', title: 'Cód. Banco Pagamento' },
            { data: 'nome_banco_pagamento', title: 'Banco Pagamento' },
            { data: 'agencia_pagamento', title: 'Agência Pagamento' },
            { data: 'conta_pagamento', title: 'Conta Pagamento' }
        ]
    });
});