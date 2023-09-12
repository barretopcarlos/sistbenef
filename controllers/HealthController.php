<?php
class HealthController extends AbstractController{
     
    function mainNavigation() {
        return html('index.php');
    }
    public function healthIndex() {   
        $cpf='';
        if ($_SESSION['perfil']=='beneficiario')
            $cpf = $_SESSION['cpf'];
        set('funcionarios', loadFuncionarios($cpf));
        return html('health/index.php');
    }

}