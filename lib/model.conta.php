<?php
function load_dados_conta_bancaria($cpf){

    // $sql = "SELECT cb.id, cb.banco_beneficio ,
    //             cb.cpf, cb.agencia_beneficio, 
    //             cb.conta_beneficio, inst.banco,
    //             IFNULL(cb.banco_pagamento, '-') AS banco_pagamento,
    //             IFNULL(cb.agencia_pagamento,'-') AS agencia_pagamento,
    //             IFNULL(cb.conta_pagamento,'-') AS conta_pagamento
    // FROM conta_bancaria cb
    // JOIN instituicao_financeira inst ON cb.banco_beneficio = inst.codigo
    // where cb.cpf = $cpf
    // ORDER BY cb.id";

    $sql = "SELECT cb.id, 
    IFNULL(cb.banco_beneficio, '-') AS banco_beneficio,
    IFNULL(cb.cpf, '-') AS cpf,
    IFNULL(cb.agencia_beneficio, '-') AS agencia_beneficio,
    IFNULL(cb.conta_beneficio, '-') AS conta_beneficio,
    inst_beneficio.banco AS nome_banco_beneficio,
    IFNULL(cb.banco_pagamento, '-') AS banco_pagamento,
    IFNULL(cb.agencia_pagamento, '-') AS agencia_pagamento,
    IFNULL(cb.conta_pagamento, '-') AS conta_pagamento,
    inst_pagamento.banco AS nome_banco_pagamento
    FROM conta_bancaria cb
    JOIN instituicao_financeira inst_beneficio ON cb.banco_beneficio = inst_beneficio.codigo
    LEFT JOIN instituicao_financeira inst_pagamento ON cb.banco_pagamento = inst_pagamento.codigo
    WHERE cb.cpf = $cpf
    ORDER BY cb.id";


    return find_objects_by_sql($sql);
    
}



