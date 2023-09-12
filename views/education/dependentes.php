<?php 
   if ($dependentes){
?>
<p>Dependente:</p>
    
    <select name="educacao[dependente][]" id="colaborador-listt"  style="width:700px;">
            <option value="">Pesquisar</option>
                <?php
                foreach ($dependentes as $position => $dependente) {
                echo "<option value='$dependente->NOME'>".$dependente->NOME."</option>";                
                }?>
      </select>
    
    <div>	
        <p>Valor:<input type="text"  name="educacao[valor][]" onKeyPress="return(moeda(this,'.',',',event))"></p>    
        <p>Boleto:<input type="file" name="educacao[boleto][]" id="boleto" accept="application/pdf, image/png, image/jpeg"/></p>
        <p>Comprovante:<input type="file" name="educacao[comprovante][]" id="comprovante" accept="application/pdf, image/png, image/jpeg"/></p>    
        <input type="hidden"  name="educacao[colaborador_nome][]" value="<?php echo $dependente->COLABORADOR; ?>">
        <p>Competência:<input type="month"  name="educacao[competencia][]" > </p>        
    </div>
    <br/>
    
<?php
   }
?>
