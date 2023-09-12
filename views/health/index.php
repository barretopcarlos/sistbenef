<?php $perfil = $_SESSION['perfil'];?>
<style>

.body {
    margin: 0;
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    font-size: 14px;
    line-height: 20px;
    color: #333;
    background-color: black;
}
.card {  
display: flex;
box-shadow: 0px 0px 10px rgb(0 0 0 / 25%);
max-width: 290px;
border-radius: 10px;
position: relative;
margin: 10px;
transition: 0.3s all ease-in-out;
border: 1px solid #eeeeee;
width: 190px;
float: left;
background-color: #003B67;
    color: #ffffff;
    
}

table {  
box-shadow: 0px 0px 10px rgb(0 0 0 / 25%);
max-width: 290px;
border-radius: 10px;
position: relative;
margin: 10px;
transition: 0.3s all ease-in-out;
border: 1px solid #eeeeee;
background-color: #003B67;
    color: #ffffff;
    
}

.card .icon {
    background-color: #000000;
    color: black;
    font-size: 3px;
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
    box-shadow: 5px 0px 12px -4px rgb(0 0 0 / 50%);
    z-index: 1;
    width: 40px;
    padding: 21px;
 
}

.card > div {
    padding: 10px 30px;
    transition: 0.3s all ease-in-out;
    display: flex;
    align-items: center;
    width: 190px;
}

.card .text {
    background-color: #003B67;
    color: #ffffff;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
    font-size: 16px;
 
}

</style>



<div class="container">   
   

        <div class="row">
            <?php if ($perfil=='analista'){ ?>
            <a href="<?= url_for('health/addContrato'); ?>" class="col-2">
                <table class="table">
                    <tr>
                        <td style="background-color: #000000;border-radius: 10px;"><img src="images/inst-de-ensino.png" alt="" style="width:52px;"></td>
                        <td style="color:#fff;vertical-align: middle;">Cadastrar Profissional / Empresa</td>
                    </tr>
                </table>

            </a>
            <?php } ?>

            <a href="<?= url_for('health/addLancamentoContratual'); ?>" class="col-2">
                <table class="table">
                    <tr>
                        <td style="background-color: #000000;border-radius: 10px;"><img src="images/contrato.png" alt="" style="width:52px;"></td>
                        <td style="color:#fff;vertical-align: middle;">Cadastrar Contrato</td>
                    </tr>
                </table>
            </a>

            <a href="<?= url_for('health/formAll'); ?>" class="col-2">
                <table class="table">
                    <tr>
                        <td style="background-color: #000000;border-radius: 10px;"><img src="images/cad-beneficiario.png" alt="" style="width:52px;"></td>
                        <td style="color:#fff;vertical-align: middle;">Solicitar Reembolso</td>
                    </tr>
                </table>
            </a>

            <?php if ($perfil=='analista'){ ?>
            <a href="<?= url_for('health/view'); ?>" class="col-2">
                <table class="table">
                    <tr>
                        <td style="background-color: #000000;border-radius: 10px;"><img src="images/analise-de-beneficio.png" alt="" style="width:52px;"></td>
                        <td style="color:#fff;vertical-align: middle;">Análise de Benefícios</td>
                    </tr>
                </table>
            </a>
            <?php } ?>


    
        </div>





</div>


