<?php 
$habilitaEdicao = false;
$idd = null;
$anexoContrato = null;


    if( isset($msg) && !empty($msg) ):
        phpAlert($msg);
    endif;

    if (!empty($_FILES))
    {
        if ($_FILES['arquivo']['size'] <= MAX_FILE_SIZE * MB)
        {
            $anexoContrato = $_FILES['arquivo']['tmp_name'];
        }else{
            echo "<script>alert('O tamanho do arquivo excedeu ".MAX_FILE_SIZE." MB.');</script>";
        }
     
        

    }



    if (!empty($_POST))
    {
        $identificacaoContrato = $_POST['educacao']['identificacao_contrato'];
        $valorTotal = $_POST['educacao']['total'];

        $inicioVigencia="";
        if (!empty($_POST['educacao']['inicio_vigencia'])){
            $inicioVigencia = new DateTime($_POST['educacao']['inicio_vigencia'], new DateTimeZone('America/Sao_Paulo'));
            $inicioVigencia = $inicioVigencia->format('Y-m-d');
        }
        
        $fimVigencia="";
        if (!empty($_POST['educacao']['fim_vigencia'])){
            $fimVigencia = new DateTime($_POST['educacao']['fim_vigencia'], new DateTimeZone('America/Sao_Paulo'));
            $fimVigencia = $fimVigencia->format('Y-m-d');
        }
       
        $contratoSelecionado = $_POST['educacao']['contrato'];
        $beneficiarioSelecionado = $_POST['educacao']['beneficiario'];
        $dependenteSelecionado = $_POST['educacao']['dependente'];

        $ds = explode('_',$dependenteSelecionado);
        $ds[0] = str_replace("null","", $ds[0]);
        $dependenteSelecionado = implode('_',$ds);



        $dependentes = file_get_contents(BASEURL."?/educationDependAll/$beneficiarioSelecionado");
        $dependentes = json_decode($dependentes );
        

    }else{
        $permitted_chars = md5($_SESSION['username'].date('dmYHis'));

        $identificacaoContrato = substr(str_shuffle($permitted_chars), 0, 6).'-'.date('dmYHis');
        $valorTotal = '';
        $inicioVigencia = '';
        $fimVigencia = '';
        $contratoSelecionado = '';
        $beneficiarioSelecionado = '';
        $dependenteSelecionado = '';
        $dependentes = '';
    }



	if (!empty($editLancamento)){
		$habilitaEdicao = true;
		$editContrato = $editLancamento[0];

		$identificacaoContrato = $editContrato->identificacao_contrato;
	        $valorTotal = $editContrato->total;

        	$inicioVigencia = '';
       		$tmpVigencia = $editContrato->inicio_vigencia;
		if (!empty($tmpVigencia)){
			$tmpVigencia = explode("/",$tmpVigencia);
			$inicioVigencia = $tmpVigencia[2].'-'.$tmpVigencia[1].'-'.$tmpVigencia[0];
		
		}

       		$tmpVigencia = $editContrato->fim_vigencia;
		if (!empty($tmpVigencia)){
			$tmpVigencia = explode("/",$tmpVigencia);
			$fimVigencia = $tmpVigencia[2].'-'.$tmpVigencia[1].'-'.$tmpVigencia[0];
		
		}

        	$contratoSelecionado = $editContrato->id_contrato;
        	$beneficiarioSelecionado = $editContrato->colaborador;

		//echo "Opa....";
        	//print_r($editContrato);
		//echo "<br><br>";
		//print_r($dependentes);

	  	$dependentes = file_get_contents(BASEURL."?/educationDependAll/$beneficiarioSelecionado");
        	$dependentes = json_decode($dependentes );

		$dependenteSelecionado = $editContrato->dependente.'_'.$editContrato->nome_dependente;
        	

	}


?>

<style>
    label {
        font-size: 16px;    
        font-weight: bold;
        font-family: Arial, Helvetica, sans-serif;
    }

    #btn_add, #mtn{
        display: inline-block;
        padding: 8px 16px;
        font-size: 18px;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        outline: none;
        color: #fff;
        background-color: #40539C;
        border: none;
        border-radius: 10px;
    }

    .d-none{
        display: none;
    }

    .content_data{
        margin-top: 2rem;
    }

    button:disabled{
        background-color: #ddd !important;
    }

    .fx{
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: center;
    }
</style>

<div class="container" style="margin-bottom: 100px;">


<?php
	if ($habilitaEdicao===true){
		$idd = array_keys($_GET)[0];
		$idd = explode("/",$idd);
		$idd = array_reverse($idd);
		$idd = $idd[0];
		$form=BASEURL.'/?/education/editLancamentoContratual/';

	}else{
		$form="";
	}
?>

    <form action="<?=$form?>" method="POST" enctype="multipart/form-data">
        <div class="row">
                <input type="hidden" name="educacao[id]" value="<?=$idd?>">
  
            <div class="col-4">
                <span>Beneficiário</span>
                <select  id="colaborador" name="educacao[beneficiario]" class="form-select"  required >
                  <option value="">Pesquisar</option>
                      <?php foreach ($funcionarios as $position => $funcionario): 
                            $textoFuncionario = $funcionario->nome;
                            $funcionarioSelected = "";
                                    if (!empty($beneficiarioSelecionado))
                                    {
                                        if($funcionario->CPF == $beneficiarioSelecionado)
                                            $funcionarioSelected = " selected ";
                                    }else{
                                        $funcionarioSelected = "";
    
                                    }   
                      ?>
                            <option value="<?= $funcionario->cpf; ?>" <?=$funcionarioSelected?>>
                                <?= $textoFuncionario; ?>
                            </option>;                
                      <?php endforeach; ?>
                  </select>
            </div>
           
            
            <div class="col-4">
            <?php 
                                                    
      
                //print_r($dependentes);        
		//echo "<br><br>";
		//print_r($dependenteSelecionado);    
            ?>
                <span>Dependentes</span>
                <select class="form-select"  name="educacao[dependente]" id="depentesBeneficiario" required >
                    <option value="">Selecione</option>
                    <?php foreach ($dependentes as $position => $funcionario): 
                            $textoDependente = $funcionario->ID_REG.'_'.$funcionario->NOME;
                            $nomeDependente = $funcionario->NOME;
                            $dependenteSelected = "";

                            if (!empty($dependenteSelecionado))
                            {
                                if($textoDependente == $dependenteSelecionado)
                                    $dependenteSelected = " selected ";
                            }else{
                                $dependenteSelected = "";

                            }   
                            
                      ?>
                            <option value="<?= $textoDependente; ?>" <?=$dependenteSelected?>>
                                <?= $nomeDependente; ?>
                            </option>;                
                      <?php endforeach; ?>
                </select>
            </div> 



         
            <div class="col-4">
                <span>Instituição</span>
                <select name="educacao[contrato]" class="form-select" id="contrato" required >
                    <option value="">Selecione</option>
                    <?php forEach( $contratos AS $contrato ): 
                    $textoContrato = $contrato->nome_contrato . " - " . mask($contrato->cnpj_contrato, "##.###.###/####-##");
                    $contratoSelected = "";
                                if (!empty($contratoSelecionado))
                                {
                                    if($contrato->id == $contratoSelecionado)
                                        $contratoSelected = " selected ";
                                }else{
                                    $contratoSelected = "";

                                }    
                    ?>
                        <option value="<?= $contrato->id; ?>" <?=$contratoSelected?>>
                            <?=$textoContrato ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

        <div>

        <br><br>
        <div class="row">
            <div class="col-2">
                <span>Identificação Contrato</span>
                <input type="text" class="form-control" name="educacao[identificacao_contrato]" value="<?=$identificacaoContrato?>" readonly id="nome_contrato" required >
            </div>
    
            <div class="col-2">
                <span>Valor Mensalidade</span>
                <input type="text" class="form-control" name="educacao[total]" value="<?=$valorTotal?>" class="spec" id="total" required >
            </div>
            <div class="col-2">
                <span>Início da Vigência</span>
                <input type="date"  name="educacao[inicio_vigencia]" value="<?=$inicioVigencia?>" class="form-control" id="inicioVigencia" required >
            </div>
            <div class="col-2">
                <span>Fim da Vigência</span>
                <input type="date"  name="educacao[fim_vigencia]" value="<?=$fimVigencia?>" class="form-control" id="fimVigencia" required >
            </div>

        <div>
        <br>
        <div class="row">
            <div class="col-4">
            <?php
                $arquivoObrigatorio = " required ";
                if ($habilitaEdicao===true) $arquivoObrigatorio = "";
            ?>
                <input type="file" <?=$arquivoObrigatorio?>  name="arquivo" class="form-control"  id="arquivo" value="<?=$anexoContrato?>">
            </div>

	    <?php
		if ($habilitaEdicao===true){

	    ?>	
         	   <div class="col-3">
          	      <input type="submit" class="btn-lg btn-warning" id="btn_edit" value="Editar"></input>
	            </div>
	
	    <?php
		}else{
	    ?>	
		    <div class="col-3">
	                <button type="button" class="btns" id="btn_add">Cadastrar</button>
	            </div>
	    <?php
		}
	    ?>	
        

        </div>

        <div class="content_data d-none">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Comp.</th>
                        <th>Valor</th>
                        <th>Dependente</th>
                    </tr>
                </thead>

                <tbody>
                    
                </tbody>
            </table>
        </div>
        
        <br><br>
    </form>
   

    <br><br>
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Beneficiário</th>
                <th>ID Dependente</th>
                <th>Dependente</th>
                <th>Instituição</th>
                <th>Contrato</th>
                <th>Meses</th>
                <th>Valor Mensalidade</th>
                <th>Início Vigência</th>
                <th>Fim Vigência</th>
                <th></th>
            
            </tr>
        </thead>

        <tbody>
            <?php forEach($lstLancamentos AS $row ): ?>
                
                <tr>
                    <td><?= $row->id; ?></td>
                    <td><?= $row->colaborador; ?></td>
                    <td><?= $row->dependente; ?></td>
                    <td><?= $row->nome_dependente; ?></td>
                    <td><?= $row->nome_contrato; ?></td>
                    <td><?= $row->identificacao_contrato; ?></td>
                    <td><?= $row->meses; ?></td>
                    <td><?= $row->total; ?></td>
                    <td><?= $row->inicio_vigencia; ?></td>
                    <td><?= $row->fim_vigencia; ?></td>
                    <td>
                            <button type="button" 
                            onClick="window.open('<?php echo url_for("/load/file/" . $row->id . "/lancamento_contratual") ?>','_blank')"
                            class="btn btn-primary btn-sm fa-solid fa-file"
                            title="Visualizar contrato">Visualizar
                            </button>
                            
                            <button type="button" 
                            onClick="window.open('<?php echo url_for("/education/editLancamentoContratual/" . $row->id . "") ?>','_self')"
                            class="btn btn-primary btn-sm fa-solid fa-edit"
                            title="Editar contrato">Editar
                            </button>
                       
                            <button type="button" 
                            onClick="if (confirm('Deseja excluir o contrato?')) { window.open('<?php echo url_for("/education/deleteLancamentoContratual/" . $row->id . "") ?>','_self') }"
                            class="btn btn-primary btn-sm fa-solid fa-trash"
                            title="Excluir contrato">Excluir
                            </button>
                            
                      
                            <button type="button" 
                            class="btn btn-primary btn-sm fa-solid fa-lock" 
                            title="Aletar Fim da Vigência"
                            data-bs-toggle="modal" 
                            data-bs-target="#exampleModal" 
                            onClick="$('#id_contrato').val('<?= $row->id; ?>')">Fim Vigência
                            </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>  
    </table>

    




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Fim da Vigência</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      
      <div class="modal-body">
            <form method="POST" action="<?=url_for('education/updateVigenciaContrato');?>">
            
                <div class="col-12">
                    <input type="hidden"  name="id_contrato" class="form-control" id="id_contrato">
                </div>
                <div class="col-4">
                    <label for="">Fim da Vigência</label>
                    <input type="date"  name="fim_vigencia_modal" class="form-control" id="fim_vigencia_modal" required >
                </div>
                <div class="col-12">
                    <label for="">Justificativa</label>
                    <input type="text"  name="justificativa_modal" class="form-control" id="justificativa_modal" required >
                </div>
                <div class="col-12">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>

            </form>
            
      </div>

      
      <div class="modal-footer">
      </div>


    </div>
  </div>
</div>
</div>


<script defer>
    
const tabela = $('#example').DataTable({
        "order": [[ 0, 'desc' ]],
        "language": {
            "sProcessing":    "Procesando...",
            "sLengthMenu":    "Mostrar _MENU_ registros",
            "sZeroRecords":   "Não foram encontrados registros",
            "sEmptyTable":    "Não há dados disponíveis",
            "sInfo":          "Mostrando registros de _START_ de _END_ de um total de _TOTAL_ registros",
            "sInfoEmpty":     "Mostrando registros de 0 de 0 de um total de 0 registros",
            "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":   "",
            "sSearch":        "Buscar:",
            "sUrl":           "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Carregando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":    "Último",
                "sNext":    "Seguinte",
                "sPrevious": "Anterior"
            }
        }
    });
  
    const btn_add       = $("#btn_add");
    const colaborador   = $("#colaborador");
    const meses         = $("#meses");
    const btn_montar    = $("#mtn");

    
    let dependentes     = {};
    
    const estrutura = {
        dependentes: {},
        meses: 1,

    }

   

    colaborador.on("change", function(){
        const valor = $(this).val() || false;
        const target = $(this);
            if( !valor )
                return;
        $.ajax({
            url: `?/educationDependAll/${valor}`,
            type: 'GET',
            dataType: 'JSON',
                success: function(response){

                    if( response.length <= 0 ){
                        target.val("");
                        swal_error("O Beneficiário não possui dependentes cadastrados");
                        return false;
                    }
                    
                    estrutura.dependentes = response;
                    const options_s = estrutura.dependentes.map( d => `<option value='${d.ID_REG}_${d.NOME}'>${d.NOME}</option>` ).join('');
        
                    
                    $('#depentesBeneficiario').html(options_s);

                    
                },
                error: function(fail){
                    swal_error("Erro interno!");
                    console.error(fail);
                }
        })
    });

    btn_add.on("click", async function(e){
        e.preventDefault();
        const target = $(this).get(0);
            target.disabled = true;

        try{
            const elem = document.querySelectorAll(".needables");
               // if( elem.length <= 0 ) throw("É necessário montar os pagamentos primeiro!");

           // const ok = Array.from(elem).every( e => e.value || false );
             //   if( !ok ){
               //     throw("É necessário preencher todos os campos");
                //}

                
            const confirma = await swal_confirma();
                if( !confirma ){
                    target.disabled = false;
                    return;
                }
    
                $("form").eq(0).submit();
        }catch(e){
            swal_error(e);
            target.disabled = false;
        }

    });


    meses.on("change keypress keyup keydown", function(){
        let valor = +$(this).val() || 0;
        const min   = +$(this).attr("min");


            if( valor < min ){
                $(this).val(min);
                valor = min;
            }

        estrutura.meses = valor;
    });

    $(".spec").on("change keyup keypress keydown", function(e){
        const condition = Array.from(document.querySelectorAll(".spec")).every( e => e.value || false );
        
        $(".btns").each(function(){
            $(this).get(0).disabled = !condition;
        });

    });

    $(document).on("keypress change", ".fm_moeda", function(e){
        moeda(this, '.', ',', e);
        return false;
    });

    $(document).on("change", ".comp_lancamento", function(){
        const valor = $(this).val() || false;
            if( !valor ) return;

        const find = Array.from(document.querySelectorAll(".comp_lancamento")).filter( e => e.value == `${valor}` )
            if( find.length > 1 ){
                    $(this).val('');
                    swal_error(`A competência já está em uso!`);
            }
    });

    $(document).on("change", ".dependentes_lancamento", function(){
        let valor = $(this).val();
        const alvo = $(this).closest("td").find(".hd_dependentes");
        alvo.val(valor);
    });

</script>