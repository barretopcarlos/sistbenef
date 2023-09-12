<?php

function get_tetos($tipoBeneficio=null){
$where = "";    

    if (!empty($tipoBeneficio))
        $where = "AND vt.id_tipo_beneficio='$tipoBeneficio' ";

    $sql = "SELECT
        vt.*,bt.beneficio
        FROM valor_teto AS vt
        INNER JOIN beneficio_tipos AS bt ON vt.id_tipo_beneficio = bt.id
        WHERE 1=1
        $where
        ORDER BY vt.id DESC
    ";

    return find_objects_by_sql($sql);
}

?>