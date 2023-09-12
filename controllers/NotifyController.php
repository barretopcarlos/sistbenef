<?php
class NotifyController extends AbstractController{

    public function load(){
        set('entrada', load_notificacoes('entrada',$_POST));        
        set('enviados', load_notificacoes('enviados',$_POST));        
        set('lidas', load_notificacoes('lidas',$_POST));        
        set('naolidas', load_notificacoes('naolidas',$_POST));        

        set('datasNotificacao',loadDatasNotificacao());

        return html('notify/load.php');
    }

    public function new(){
        layout("layout/nomenu.php");

        if (!empty($_POST))
        {
            $IdNotificacao = saveNotify($_POST);

            if (!empty($_FILES))
                saveNotifyFile($IdNotificacao, $_FILES);

            return redirect("notify");
        }

        return html('notify/new.php');
    }

    public function details(){
        layout("layout/nomenu.php");
        $id = params("id");
        set('id', $id);        
        $destinatario = $_SESSION['username'];

        $verifica = verificaSeFoiLida($id);
        if (!empty($verifica))
        {
            $lidoBase = $verifica[0]->lido;
            $destinatarioBase = $verifica[0]->destinatario;

            if ($destinatario==$destinatarioBase && $lidoBase=='N'){
                //notificacao lida ao destinatario clicar sobre ela
                notificacao_lida($id);
                set('lstNotificacao', details_notify($id));    
                
                set('lstNotificacaoReplys', details_notify_replys($id));    
                
                set('lstNotificacaoFile', details_notify_file($id));        
                return redirect("notify/load");
    
            }
        
        }

        set('lstNotificacao', details_notify($id));        
        set('lstNotificacaoReplys', details_notify_replys($id));    
        set('lstNotificacaoFile', details_notify_file($id));        

        return html('notify/details.php');
    }
    
    public function add(){
        try{
                if( empty($_POST['descricao']) ):
                    throw new Exception("É necessário informar qual a descrição");
                endif;
            $msg        = add_notify($_POST);
        }catch(Exception $e){
            $msg = $e->getMessage();
        }
        
        return html('notify/save.php');
    }


    public function reply(){
        layout("layout/nomenu.php");
        $id = params("id");
        set('id', $id);        

        $lstNotificacao = details_notify($id);
        set('lstNotificacao', $lstNotificacao[0]);        

        return html('notify/new.php');
    }



}