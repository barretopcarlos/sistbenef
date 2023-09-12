<?php
class DependenteController extends AbstractController{

    
    public function openDeficiencia(){

        $id = $_SESSION['id_funcional'];

        set('deficiencias', get_deficiencia());
        set('dependentes', get_dependentes($id));
        return html('dependente/cadastrarDeficiencia.php');
    }
   
    public function cadastrarDeficiencia(){

            try {
                $insercao = add_deficiencia($_POST);
    
                if ($insercao == true) {
                    $msg = true;
                } else {
                    $msg = false;
                }
    
            } catch (Exception $e) {
                $msg = $e->getMessage();
            }

            $id = $_SESSION['id_funcional'];
            
            set('deficiencias', get_deficiencia());
            set('dependentes', get_dependentes($id));
            set('msg', $msg); 
            return html('dependente/addDeficiencia.php');
    }

    public function openGerenciarDeficiencia(){

        $id = $_SESSION['id_funcional'];

        try {
            
            $deficiencias_dependentes = load_deficiencias_dependentes($id);
            $deficiencias = load_tipos_deficiencias();

            set('deficiencias_dependentes', $deficiencias_dependentes);
            set('deficiencias', $deficiencias);
            return html('dependente/gerenciarDeficiencia.php');

        } catch (Exception $e) {
            $msg = $e->getMessage();
        }

    }

    function editarExcluirDeficiencia(){   

        $acao = $_POST['modalTipoAcao'];
        $id = $_POST['id'];
        $id_funcional = $_SESSION['id_funcional'];

        if($acao == 'editar'){

            try {
                $atualizacao = att_deficiencia($id, $_POST);

                if ($atualizacao == true) {
                    $msg = true;
                } else {
                    $msg = false;
                }
            } catch (Exception $e) {
                $msg = $e->getMessage();
            }


            set('deficiencias_dependentes', load_deficiencias_dependentes($id_funcional));
            set('deficiencias', get_deficiencia());
            set('dependentes', get_dependentes($id_funcional));
            set('msg', $msg);   

            return html('dependente/gerenciarDeficiencia.php');
            
        }else if($acao == 'excluir'){

            try {
                $atualizacao = delete_deficiencia($id);

                if ($atualizacao == true) {
                    $msg = true;
                } else {
                    $msg = false;
                }
            } catch (Exception $e) {
                $msg = $e->getMessage();
            }

            set('deficiencias_dependentes', load_deficiencias_dependentes($id_funcional));
            set('deficiencias', get_deficiencia());
            set('dependentes', get_dependentes($id_funcional));
            set('msg', $msg);   

            return html('dependente/gerenciarDeficiencia.php');

        }

    }


    
}