
<?php if( false ): ?>
  <?php foreach ($dependentes as $position => $dependente): ?>
    <p>Dependente: <?php echo $dependente->NOME; ?></p>
      <div>	
          <p>Valor:<input type="text" required name="educacao[valor][]" onKeyPress="return(moeda(this,'.',',',event))"></p>    
          <p>Boleto:<input type="file" name="educacao[boleto][]" id="boleto" accept="application/pdf, image/png, image/jpeg"/></p>
          <p>Comprovante:<input type="file" name="educacao[comprovante][]" id="comprovante" accept="application/pdf, image/png, image/jpeg"/></p>   
          <p>Outros:<input type="file" name="educacao[outros][]" id="outros" accept="application/pdf, image/png, image/jpeg"/></p>   
          
          <input type="hidden"  name="educacao[colaborador_nome][]" value="<?php echo $dependente->COLABORADOR; ?>">
          <input type="hidden"  name="educacao[dependente][]" value="<?php echo $dependente->NOME; ?>">
          <input type="hidden"  name="educacao[colaborador][]" value="<?php echo $dependente->CPF_COLABORADOR; ?>">
          <p>Competência:<input type="month"  name="educacao[competencia][]" > </p>        
      </div>
      <br/>
  <?php endforeach; ?>
<?php endif; ?>


<div class="dps_r">
  <table class="display" style="width:100%">
    <thead>
        <tr>
          <th>Dependente</th>
          <th>Valor</th>
          <th>Competência</th>
          <th>Boleto</th>
          <th>Comprovante</th>
          <th>Outros</th>
          <th>#</th>
        </tr>
    </thead>

    <tbody>
        <?php $index = 0; ?>
        <?php forEach ($dependentes as $position => $dependente): ?>
          <?php $index++; ?>
          <tr>
            <td data-label="nome">
              <?php echo $dependente->NOME; ?>
              <input type="hidden"  name="educacao[colaborador_nome][]" value="<?php echo $dependente->COLABORADOR; ?>">
              <input type="hidden"  name="educacao[dependente][]" value="<?php echo $dependente->NOME; ?>">
              <input type="hidden"  name="educacao[colaborador][]" value="<?php echo $dependente->CPF_COLABORADOR; ?>">
              <input type="hidden" name="educacao[index_of][]" value="<?= $index; ?>">
            </td>

            <td data-label="valor">
              <input type="text" required name="educacao[valor][]" onKeyPress="return(moeda(this,'.',',',event))">
            </td>

            <td data-label="competencia">
                <input type="month"  name="educacao[competencia][]" >
            </td>

            <td data-label="boleto">
              <input type="file" name="educacao[boleto][<?= $index; ?>][]" id="boleto" accept="application/pdf, image/png, image/jpeg"/>
            </td>

            <td data-label="comprovante">
                <input type="file" name="educacao[comprovante][<?= $index; ?>][]" id="comprovante" accept="application/pdf, image/png, image/jpeg"/>
            </td>

            <td data-label="outros">
              <input type="file" name="educacao[outros][<?= $index; ?>][]" id="outros" accept="application/pdf, image/png, image/jpeg"/>
            </td>

            <td>
              <button type="button" class="bt_remover_linha">
                  x
              </button>
            </td>
          </tr>
        <?php endforeach; ?>
    </tbody>

  </table>
</div>


<script defer>
    console.log(JSON.parse(`<?= json_encode($dependentes); ?>`))
</script>