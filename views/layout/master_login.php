<?php $versao_assets = time(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="pt-BR">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Benefícios</title>


        <!-- MATERIALIZE CSS -->
        <!-- Compiled and minified CSS -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

        <!-- Compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
            


        <!-- Bootstrap CSS -->
        <link href="assets/bootstrap/bootstrap.css" rel="stylesheet">


        <!-- Font Awersome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>

        <link rel="stylesheet" href="assets/bootstrap/selectize.bootstrap3.min.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />
        <link rel="stylesheet" href="assets/css/estilo.css">

	    <script src="assets/bootstrap/jquery.min.js"></script>
        <script src="assets/bootstrap/selectize.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        <link  rel="stylesheet" href="assets/js/sweetalert2/select2.min.css" />
        <script src="<?=BASEPATH?>/bootstrap/select2.min.js"></script>


        <link rel="stylesheet" href="assets/bootstrap/fontawesome.min.css">
        
        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <script src="assets/bootstrap/popper.min.js"></script>
        <script src="assets/bootstrap/bootstrap.bundle.js"></script>

        <script type="text/javascript" src="assets/js/paginator.js"></script>
        <script src="<?=BASEPATH?>/bootstrap/globals.js?t=<?= $versao_assets; ?>" defer></script>
    </head>

<body>
        <?php if( isset($_SESSION['user']) ): ?>

                <div class="pre-topo">

            
                

                <nav class="navbar navbar-expand" style="background:#223161;color:white">
                    <div class="container-fluid">
                        <span class="navbar-brand">
                            <h1 class="h4">Sistema de Beneficios</h1>

                        </span>
                        
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="navbar-collapse collapse w-100">
                        <span>1.0.1</span>
                        <?php if ($env == ENV_DEVELOPMENT) echo "<b style='color:orange'>&nbsp;DEV</b>";?>

                       
                             <ul class="navbar-nav ms-auto">

                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <li class="nav-item">
                                    <a href="<?= url_for('main'); ?>">
                                        <i class="fa-solid fa-home" title="Página inicial" style="font-size:2em"></i>
                                    </a>
                                </li>
                                <?php if ($_SESSION['perfil']=='analista'){ ?>    
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <li class="nav-item">
                                    <a href="<?= url_for('management'); ?>">
                                        <i class="fa fa-gears" title="Gerencial" style="font-size:2em"></i>
                                    </a>
                                </li>
                                <?php } ?>

                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <li class="nav-item">
                                    <a href="<?= url_for('education'); ?>">
                                        <i class="fa fa-graduation-cap" title="Educação" style="font-size:2em"></i>
                                    </a>
                                </li>
             
                               
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <li class="nav-item">
                                    <a href="<?= url_for('main_health'); ?>">
                                        <i class="fa fa-heartbeat" title="Saúde" style="font-size:2em"></i>
                                    </a>
                                </li>
                                
                                
                                <?php if ($_SESSION['perfil']=='analista'){ ?>    
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                <li class="nav-item">
                                    <a href="<?= url_for('report'); ?>">
                                        <i class="fa fa-pie-chart" title="Relatórios" style="font-size:2em"></i>
                                    </a>
                                </li>
                                <?php } ?>

                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                <li class="nav-item">
                                    <a href="<?= url_for('notify'); ?>">
                                        <i class="fa fa-bell" title="Notificações" style="font-size:2em"></i>
                                        <?php $novas = novasNotificacoes(); ?>
                                        <?php if (isset($novas[0]->novas) && $novas[0]->novas>0){ ?>
                                            <span class="translate-middle badge rounded-pill bg-danger" title="Mensagens Não Lidas">
                                                <?=$novas[0]->novas; ?>
                                            </span>
                                        <?php } ?>

                                    </a>



                                </li>


                                <!--
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <li class="nav-item">
                                    <a href="<?= url_for('main'); ?>">
                                        <i class="fa fa-book" title="Manuais" style="font-size:2em"></i>
                                    </a>
                                </li>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <li class="nav-item">
                                    <a href="<?= url_for('main'); ?>">
                                        <i class="fas fa-bell" style="font-size:2em"></i>
                                    </a>
                                </li>
                                -->
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <li class="nav-item">
                                    <a href="<?=url_for('logout'); ?>">
                                        <i class="fa fa-sign-out" title="Sair do Sistema" style="font-size:2em"></i>
                                    </a>
                                </li>



                             </ul>
                        </div>

                        <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
                            <ul class="navbar-nav ms-auto" style="background-color:white">
                                
                                <li class="nav-item navbar-right">
                                    <img src="https://pge.rj.gov.br/site/img/logo.png"/>
                                </li>
                                
                            </ul>

                        </div>
                    </div>
                </nav>

<br>

            

                <a href='' name="topo" tabindex="0" accesskey="2"></a>

                <div class="menu-topo">
                    <div class="container">
                             <!-- nome e perfil do usuario autenticado -->               
                            <span><?php  echo '<< '.$_SESSION['username'].' - '.$_SESSION['perfil'].' >>';?></span>
                            
                        <div class="limpar"></div>
                    </div>
                </div>

                <div class="menu-aberto">
                    <div class="container">
                    </div>

                    <div class="limpar"></div>
                </div>

        <?php endif; ?>

        <?php echo $content; ?>

        <div class="loading">
            <div class="text_loading">...</div>
        </div>

        


<!--



        <button type="button" class="btn btn-primary" id="liveToastBtn">Show live toast</button>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <img src="..." class="rounded me-2" alt="...">
      <strong class="me-auto">Bootstrap</strong>
      <small>11 mins ago</small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      Hello, world! This is a toast message.
    </div>
  </div>
</div>


<script>
  const toastTrigger = document.getElementById('liveToastBtn')
const toastLiveExample = document.getElementById('liveToast')
if (toastTrigger) {
  toastTrigger.addEventListener('click', () => {
    const toast = new bootstrap.Toast(toastLiveExample)

    toast.show()
  })
}

</script>





        <img src="http://localhost/beneficios/assets/img/footer.png" width="100%">
        </img>    

        <footer class="text-center text-lg-start bg-light text-muted" style="background-color:#005A92">
        
        <section class="">
            <div class="container text-center text-md-start mt-5">
            <div class="row mt-3">
                <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                </div>
       
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                <h6 class="text-uppercase fw-bold mb-4">
                    ACESSO RÁPIDO
                </h6>
                <p>
                    <a href="#!" class="text-reset">Angular</a>
                </p>
                <p>
                    <a href="#!" class="text-reset">React</a>
                </p>
                <p>
                    <a href="#!" class="text-reset">Vue</a>
                </p>
                <p>
                    <a href="#!" class="text-reset">Laravel</a>
                </p>
                </div>
       
               
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                <h6 class="text-uppercase fw-bold mb-4">Contato</h6>
                <p><i class="fas fa-home me-3"></i> Rua do Carmo, 27 - Centro - RJ</p>
                <p>
                    <i class="fas fa-envelope me-3"></i>
                    contato@pge.rj.gov.br
                </p>
                <p><i class="fas fa-phone me-3"></i> +55 (21) xxxx-xxxx</p>
                </div>
            </div>
            </div>
        </section>
       
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2023 Copyright:
            <a class="text-reset fw-bold" href="#">GTI</a>
        </div>
        </footer>
       
        -->   
</body>
</html>
