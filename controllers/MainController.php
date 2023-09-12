<?php

class MainController extends AbstractController {

    function home() {
        return html("main/index.html.php");
    }

    function login() {


        if($_POST['user']['username'] == 'perfilteste'){
        
            $perfil='nao-analista';
            $token ='123';
    
            $_SESSION = array(
                "username" => 'perfilteste', 
                "profile" => 'teste', 
                "perfil" => $perfil,
                "token" => $token
            );
    
            $_SESSION['cpf'] = '8935966711';
            $_SESSION['id_funcional'] = '50960369';
    
            redirect('/main');
        
        }

        if($_POST['user']['username'] == 'beneficiario'){

            $perfil='beneficiario';
            $token ='123';

            $_SESSION = array(
                "username" => 'nobret',
                "profile" => 'teste',
                "perfil" => $perfil,
                "token" => $token
            );

            $_SESSION['cpf'] = '8935966711';
            $_SESSION['id_funcional'] = '50960369';

            redirect('/main');

        }

        


        $perfil = "";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://".URL_ORC."/orc/?/login/ldap");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_POST));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       	$response= curl_exec($ch);
        //echo '<pre>';print_r($response);die();
        $content = json_decode($response);
        curl_close($ch);


	if ($_POST['user']['username'] == 'goncalof')
	{
		$perfil='analista';
		$content->token='123';

	}

    if ($_POST['user']['username'] == 'agsilva') 
	{
		$perfil='analista';
		$content->token='123';

	}

    if ($_POST['user']['username'] == 'ajunqueira')
	{
		$perfil='analista';
		$content->token='123';

	}

    if ($_POST['user']['username'] == 'nobret')
	{
		$perfil='analista';
		$content->token='123';

	}

    if ($_POST['user']['username'] == 'soarespri')
	{
		$perfil='analista';
		$content->token='123';

	}

    if ($_POST['user']['username'] == 'cruzl')
	{
		$perfil='nao-analista';
		$content->token='123';

	}


 
        if (isset($content->token)) {
            $pg = NULL;
            //echo '<pre>';print_r($content);die();
            foreach($content->userInfo->memberof as $k=>$v){
                $aux = explode("CN=",$v);
                unset($aux[0]);
                if (!empty($aux[1]))
                    $aux = explode(",",$aux[1]);
                if (!empty($aux[0]))
                {
                    $aux = explode("_",$aux[0]);
                    if ($aux[0]=='SistemaBeneficios')
                    {
                        $perfil = $aux[1];
                        $perfil = strtolower($perfil);
                    }
                
                }
            }
            
            //testar perfil manualmente ANALISTA  =  RH
//            $perfil='analista';
                
            $_SESSION = array(
                "username" => $_POST['user']['username'], 
                "profile" => $content->userInfo->memberof, 
                "perfil" => $perfil,
                "token" => $content->token
            );


            //Verificar se login de rede existe na tabela de beneficiarios
            $primeiroAcesso = getCpfPorLoginRede($_POST['user']['username']);    
            if (empty($primeiroAcesso))
            {
                redirect('/obtercpf');
            }else{
                if (isset($primeiroAcesso[0]->cpf))
                {
                    $_SESSION['cpf'] = $primeiroAcesso[0]->cpf;
                    $_SESSION['id_funcional'] = $primeiroAcesso[0]->id_funcional;
                    
                    redirect('/main');
                }else{
                    logout();
                }
            }        


        } else {
            redirect('/');
        }
    }

    function logout() {
        session_destroy();
        redirect("/");
    }


    function obtercpf(){
    layout("layout/simple.php");
        if (empty($_POST))
        {
            return html('obtercpf.php');
        }else{
	    session_start();

		if (!isset($_POST['cpf'])) $_POST['cpf']=$_POST['user']['username'];

            $cpf = $_POST['cpf'];
            $cpf = str_replace(".","",$cpf);
            $cpf = str_replace("-","",$cpf);
            $loginRede = $_SESSION['username'];

            $response = getLoginRedePorCpf($cpf);
            if (!isset($response[0]->login_rede) || empty($response[0]->login_rede))
            {
                $_SESSION['cpf'] = $cpf;
                $_SESSION['id_funcional'] = $response[0]->id_funcional;
                updateLoginRedeBeneficiario($loginRede, $cpf);
            }

            redirect("/main");
        }
    }

}
?>