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
.nav-pills .btn {
  color: #45773B;
  font-weight:bold;
  border:#efefef solid;
  border-radius: 50px;
}

.nav-pills .btn:hover {
  background: #45773B;
  color: #FFFFFF;
  border-radius: 50px;

}

</style>    
<div class="container">   


    <div class="row nav-pills mb-3" id="pills-tab" role="tablist">
        <?php if ($perfil=='analista'){ ?>
            <div class="col-md-3 col-sm-3 mb-1 col-3" role="presentation">
                <button class="btn" id="pills-profile-tab" onClick="location.href='<?= url_for('education/addContrato'); ?>'" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Cadastrar Instituição</button>
            </div>
        <?php } ?>
        
        <div class="col-md-3 col-sm-3 mb-1 col-3" role="presentation">
            <a class="btn" id="pills-contact-tab" onClick="location.href='<?= url_for('education/addLancamentoContratual'); ?>'" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Cadastrar Contrato</a>
        </div>
        <div class="col-md-3 col-sm-3 mb-1 col-3" role="presentation">
            <button class="btn" id="pills-mural-tab" onClick="location.href='<?= url_for('education/formAll'); ?>'" data-bs-toggle="pill" data-bs-target="#pills-mural" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Solicitar Reembolso</button>
        </div>

        <?php if ($perfil=='analista'){ ?>
            <div class="col-md-3 col-sm-3 mb-1 col-3" role="presentation">
                <a class="btn" id="pills-advice-tab" onClick="location.href='<?= url_for('education/view'); ?>'" data-bs-toggle="pill" data-bs-target="#pills-advice" type="button" role="tab" aria-controls="pills-advice" aria-selected="true">Análise de Benefícios</a>
            </div>
        <?php } ?>
        
    </div>


</div>


