<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
       <!-- Bootstrap CSS -->
        <link href="assets/bootstrap/bootstrap.css" rel="stylesheet">        
        <link rel="stylesheet" href="assets/css/nEstilo.css">
        

        <!-- Bootstrap JS -->
        <script src="assets/bootstrap/bootstrap.bundle.js"></script>


       


<?php
if (!empty($_SESSION))
    redirect("/main");

// Apaga todas as variáveis da sessão
$_SESSION = array();

// Se é preciso matar a sessão, então os cookies de sessão também devem ser apagados.
// Nota: Isto destruirá a sessão, e não apenas os dados!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
// Por último, destrói a sessão
session_destroy();
?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6" >
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="infoResl"> 
                                        <div class="error-container">
                                            <p class="error-message">Resolução não suportada no momento. Contacte o administrador, ou tente novamente em outra resolução.</p>
                                            <a class="error-link" href="http://ocomon/">Clique aqui</a>
                                        </div>
                                    </div>
                                        <!-- Imagem --> 
                                            <img class="logoBene" src="assets/img/portal_beneficios.svg">
                                        <!-- Imagem --> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                        <div class="logoRj">
                                                <!-- Imagem -->
                                                <a href="http://portal/SitePages/Inicio.aspx">
                                                <img class="logopge" src="assets/img/logo.svg">
                                                </a>
                                                <!-- Imagem --> 
                                        </div>
                                </div>
                            </div>
                        </div> <!-- col-md-6 -->
                        <div class="col-md-6">
                            <form class="form-signin" action="<?php echo url_for('login'); ?>" method="post" accept-charset="utf-8" name="form">
                                <input type="hidden" name="_method" id="_method" value="POST" />
                                <input type="hidden" name="user[resource]" value="beneficios"></input>
                                <div class="form-floating">
                                    <input placeholder="." required class="form-control" id="floatInput" type="text" name="user[username]"/>
                                    <label for="floatInput">Usuario</label>
                                </div>
                                    <div class="form-floating">
                                        <input type="password" name="user[password]" required class="form-control" id="floatPassword" placeholder=".">
                                        <label for="floatPassword">Senha</label>
                                    </div>
                                        <!--<a class="esqSenha" href="#">Esqueci minha senha</a>-->
                                            <button class="" type="submit">Entrar</button>
                                                <input type="hidden" name="" value="Entrar">
                            </form>      
                        </div>
                    </div><!-- Row -->        
                </div><!-- Col-md-8 -->
                <div class="col-md-2"></div><!-- Col-md-2 -->
            </div><!-- Row -->
        </div><!-- Container -->


        

   
    

