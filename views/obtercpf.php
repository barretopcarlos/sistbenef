<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
       <!-- Bootstrap CSS -->
        <link href="assets/bootstrap/bootstrap.css" rel="stylesheet">        
        <link rel="stylesheet" href="assets/css/nEstilo.css">

        <!-- Bootstrap JS -->
        <script src="assets/bootstrap/bootstrap.bundle.js"></script>
<div class="container-fluid">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6" >
                            <div class="row">
                                <div class="col-md-12">
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
                            <form class="form-signin" action="" method="post" accept-charset="utf-8" name="form">
                            <h4>Olá, <?=$_SESSION['username']?>!</h4>
                            <p>Insira seu CPF abaixo para prosseguir.</p>
                                <div class="form-floating">
                                    <input placeholder="." title="Digite seu CPF no formato: xxx.xxx.xxx-xx" required class="form-control" id="floatInput" type="text" name="user[username]"/>
                                    <label for="floatInput">CPF</label>
                                </div>
                                   
                                        <!--<a class="esqSenha" href="#">Esqueci minha senha</a>-->
                                            <button class="" type="submit">Verificar</button>
                                                <input type="hidden" name="" value="Verificar">
                            </form>      
                        </div>
                    </div><!-- Row -->        
                </div><!-- Col-md-8 -->
                <div class="col-md-2"></div><!-- Col-md-2 -->
            </div><!-- Row -->
        </div><!-- Container -->


        