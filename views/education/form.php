<?php
if(isset($msg))
phpAlert($msg);
?>
<div class="header">
    <div class="headerImage">
        <img src="https://pge.rj.gov.br/site/img/logo.png" alt="PGE - RJ" class="logo">
    </div>
    <div class="headerTitulo">
        <h2 >Benefícios</h2>
    </div>
</div>
<h2>Auxilio Educação</h2>
<form method="POST" action="<?php echo url_for('education/new'); ?>"  enctype="multipart/form-data">
  <input type="hidden" name="_method" id="_method" value="POST" />
    <div>
      <p>Beneficiário:</p>
        <p>
            <select name="educacao[colaborador][]" id="colaborador"  style="width:700px;">
            <option value="">Pesquisar</option>
                <?php
                foreach ($funcionarios as $position => $funcionario) { 
                echo "<option value=".$funcionario->CPF.">".$funcionario->NOME."     ID:".$funcionario->NUMERO."     CPF:".$funcionario->CPF."</option>";                
                }?>
            </select>
           
         </p>
    </div>
    <div id="dependentes-data">
	Pesquise o colaborador para atualizar.
    </div>
    <div>
    <p>     
      <input type="submit" value="Enviar" />
    </p>
  </div>
</form> 

<script type="text/javascript">  
    $(document).ready(function(){
        $('#colaborador').selectize({
        sortField: 'text'
        });   
        
     $("#colaborador").change(function(){					
    var getUserID = $(this).val();				
        if(getUserID != '0')
            {
                $.ajax({
                    type: 'GET',
                    url: '?/educationDepend/'+ getUserID,
                    success: function(data){							
                    $("#dependentes-data").html(data);
                    $('#colaborador-listt').selectize({
                            sortField: 'text'
                            });
                        }
                });
            }
            else{
                $("#dependentes-data").html('');					
            }
        });   
    });

    function moeda(a, e, r, t) {
        let n = ""
          , h = j = 0
          , u = tamanho2 = 0
          , l = ajd2 = ""
          , o = window.Event ? t.which : t.keyCode;
        if (13 == o || 8 == o)
            return !0;
        if (n = String.fromCharCode(o),
        -1 == "0123456789".indexOf(n))
            return !1;
        for (u = a.value.length,
        h = 0; h < u && ("0" == a.value.charAt(h) || a.value.charAt(h) == r); h++)
            ;
        for (l = ""; h < u; h++)
            -1 != "0123456789".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
        if (l += n,
        0 == (u = l.length) && (a.value = ""),
        1 == u && (a.value = "0" + r + "0" + l),
        2 == u && (a.value = "0" + r + l),
        u > 2) {
            for (ajd2 = "",
            j = 0,
            h = u - 3; h >= 0; h--)
                3 == j && (ajd2 += e,
                j = 0),
                ajd2 += l.charAt(h),
                j++;
            for (a.value = "",
            tamanho2 = ajd2.length,
            h = tamanho2 - 1; h >= 0; h--)
                a.value += ajd2.charAt(h);
            a.value += r + l.substr(u - 2, u)
        }
        return !1
    }	

</script>