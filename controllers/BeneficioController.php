<?php
class BeneficioController extends AbstractController{

    
    public function openBeneficio(){
        return html('beneficio/cadastrarBeneficio.php');
    }

    
    public function cadastrarBeneficio(){

        try {
            $insercao = add_beneficio($_POST);

            if ($insercao == true) {
                $msg = true;
            } else {
                $msg = false;
            }

        } catch (Exception $e) {
            $msg = $e->getMessage();
        }
    
        set('tipoBeneficios', load_tipos_beneficios());        
        set('msg', $msg); 

        return html('beneficio/addBeneficio.php');

    }

    public function openConsultarBeneficio(){
        try {
            $tipoBeneficios = load_tipos_beneficios();
            set('tipoBeneficios', $tipoBeneficios);
            return html('beneficio/consultarBeneficio.php');
        } catch (Exception $e) {
            $msg = $e->getMessage();
        }
    }

    function atualizarBeneficio(){   

        $id = $_POST['id'];

        try {
            $atualizacao = att_beneficio($id, $_POST);

            if ($atualizacao == true) {
                $msg = true;
            } else {
                $msg = false;
            }
        } catch (Exception $e) {
            $msg = $e->getMessage();
        }

        $tipoBeneficios = load_tipos_beneficios();
        set('tipoBeneficios', $tipoBeneficios);
        set('msg', $msg);        
        return html('beneficio/consultarBeneficio.php');

    }


    // private function updateBeneficio(){        
    //     $id = $_POST['id'];
    //     updateBeneficio($id, $_POST);
    //     set('tipoBeneficios', load_tipos_beneficios());        
    //     return html('beneficio/addBeneficio.php');
    // }

    // public function openBeneficio(){
    //     set('tipoBeneficios', load_tipos_beneficios());        

    //     return html('beneficio/addBeneficio.php');
    // }

    // public function createBeneficio(){
    //     if (!empty($_POST['btn_edit'])) updateBeneficio();  

    //     try{
    //         $msg        = add_beneficio($_POST);
    //     }catch(Exception $e){
    //         $msg = $e->getMessage();
    //     }
        
    //     set('tipoBeneficios', load_tipos_beneficios());        

    //     return html('beneficio/addBeneficio.php');

    // }


    // private function updateBeneficio(){        
    //     $id = $_POST['id'];
    //     updateBeneficio($id, $_POST);
    //     set('tipoBeneficios', load_tipos_beneficios());        
    //     return html('beneficio/addBeneficio.php');
    // }

/*
    public function deleteMural(){       
        $id = params('id');
        $msg = deleteMural($id);
        set('lstMural', load_mural());        
        set('tipoBeneficios', load_tipos_beneficios());  

        $resultado = array('status'=>$msg);
        return render(json_encode($resultado), NULL);
    }
*/
}