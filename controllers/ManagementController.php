<?php

class ManagementController extends AbstractController{

    public function managementIndex(){
        return html('management/index.php');
    }

    public function gridTeto(){
        set('tetosPagamento', get_tetos());
        return html("management/gridTeto.php");
    }
}

?>