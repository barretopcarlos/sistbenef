<?php
class MuralController extends AbstractController{
     

    public function openMural(){
        set('lstMural', load_mural());        
        set('tipoBeneficios', load_tipos_beneficios());        

        return html('management/addMural.php');
    }

    public function createMural(){

        if (!empty($_POST['btn_edit'])) updateMural();  

        try{
                if( empty($_POST['descricao']) ):
                    throw new Exception("É necessário informar qual a descrição");
                endif;
            $msg        = add_mural($_POST);
        }catch(Exception $e){
            $msg = $e->getMessage();
        }
        
        set('lstMural', load_mural());        
        set('tipoBeneficios', load_tipos_beneficios());        

        return html('management/addMural.php');

    }


    private function updateMural(){        
        $id = $_POST['id'];
        updateMural($id, $_POST);
        set('lstMural', load_mural());        
        set('tipoBeneficios', load_tipos_beneficios());        
        return html('management/addMural.php');
    }


    public function deleteMural(){       
        $id = params('id');
        $msg = deleteMural($id);
        set('lstMural', load_mural());        
        set('tipoBeneficios', load_tipos_beneficios());  

        $resultado = array('status'=>$msg);
        return render(json_encode($resultado), NULL);
    }

}