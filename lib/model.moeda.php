<?php

function load_dados_moeda(){
    $sql = "SELECT * FROM moeda";
    return find_objects_by_sql($sql);
}

?>