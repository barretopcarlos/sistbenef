<?php
class ContaController extends AbstractController{


    public function openDadosBancarios(){

        $cpf = $_SESSION['cpf'];

        try {
            $dadosBancarios = load_dados_conta_bancaria($cpf);
            set('dadosBancarios', $dadosBancarios);
            return html('conta/consultarDadosBancarios.php');
        } catch (Exception $e) {
            $msg = $e->getMessage();
        }
    }
    
}