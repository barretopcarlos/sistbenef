<?php 
    if( isset($msg) ):
         phpAlert($msg);
    endif;    
?>

<div class="header">
    <div class="headerImage">
        <img src="https://pge.rj.gov.br/site/img/logo.png" alt="PGE - RJ" class="logo">
    </div>
    <div class="headerTitulo">
        <h2 >Benefícios Alteração</h2>
    </div>
</div>

<?php if( !empty($infos_educacao) ): ?>
    <h2>Auxilio Educação (Todos)</h2>

    <form method="POST" action="<?php echo url_for('education/formEdit'); ?>"  enctype="multipart/form-data">
    <input type="hidden" name="_method" id="_method" value="POST" />
    <input type="hidden" name="educacao[idd_registro]" value="<?= $infos_educacao->id; ?>">
    <input type="hidden" name="educacao[idd_colaborador]" value="<?= $infos_educacao->colaborador; ?>">
    <input type="hidden" name="educacao[nmm_comp]" value="<?= $infos_educacao->competencia; ?>">
    


        <div>
            <p>Beneficiário: </p>
                <p>
                    <input type="text" disabled  value="<?= $infos_educacao->colaborador_nome; ?>" style="width:700px;">
                </p>
        </div>

        <p>Competência:
            <input type="month" readonly value="<?= $infos_educacao->competencia; ?>" name="competencia">
        </p>    
        <hr>

        <p>Dependente:</p>
            <div>	
                <p>Valor solicitado:
                    <input 
                        type="text" 
                        required 
                        name="educacao[valor]"
                        onKeyPress="return(moeda(this,'.',',',event))"
                        value="<?= number_format($infos_educacao->valor, 2, ",", "."); ?>"
                    >
                </p>
                    
                        

                <p> Observação
                    <textarea name="educacao[observacao]" cols="15" rows="5" required><?= $infos_educacao->observacao_ultima_edicao; ?></textarea>
                </p>
            </div>
        <br/>


        <div>
            <p>     
                <input type="submit" value="Enviar" />
            </p>
        </div>
    </form> 

<?php else: ?>
    <p>Registro não encontrado!</p>
<?php endif; ?>
