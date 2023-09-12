<form method="POST" action="<?php echo url_for('education/view'); ?>" >
  <input type="hidden" name="_method" id="_method" value="POST" />
    <div class="container ">

   
        <p>Competência
        
            <select name="educacao[comp]" class="form-select" style="width:100px;">
              <option value="">Todos</option>
                  <?php
                  foreach ($competencias as $position => $registro) { 
                  echo "<option value=".$registro->competencia.">".$registro->competencia."</option>";                
                  }?>
            </select>
           
         </p>

         <p>
              Status
              <select name="educacao[status]" id="status" class="form-select"  style="width:100px;">
                <option value="">Todos</option>
                <?php forEach( $status AS $index => $registro ): ?>
                    <?php if( empty($registro->status) ): continue; endif; ?>
                    <option value="<?= $registro->status; ?>">
                        <?= $registro->status; ?>
                    </option>
                <?php endforeach; ?>
              </select>
         </p>
         <p>     
          <input type="submit" value="buscar" class="btn btn-primary"/>
        </p>

    </div>

    <div>
  </div>
</form> 
