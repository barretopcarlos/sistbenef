<?php
//Verifica se perfil do usuário está apto para acesso da funcionalidade 
class ACL  {
    public static $destinatario;
    public static $NomeDestinatario;
    public static $perfil;

    public static function controller($recurso)
    {

    }

    public static function view($recurso)
    {
        $profile = $_SESSION['perfil'];
        self::$perfil = $profile;
        if ($profile == 'beneficiario')
        {
            if ($recurso == 'notify/details')
            {
                self::$destinatario = "0"; //Núcleo de Benefícios 
                self::$NomeDestinatario = "Núcleo de Benefícios"; //Núcleo de Benefícios 
            
            }elseif ($recurso == 'education/addContrato'){
                die(" Você não possui acesso");
            }elseif ($recurso == 'education/view'){
                die(" Você não possui acesso");
            }elseif ($recurso == 'management'){
                die(" Você não possui acesso");
            }elseif ($recurso == 'management/addMural'){
                die(" Você não possui acesso");
            }elseif ($recurso == 'report'){
                die(" Você não possui acesso");
            }elseif ($recurso == 'report/educationview'){
                die(" Você não possui acesso");
            }

            


 
        }elseif ($profile == 'analista')
        {
            
        }

    }

}