<div class="header">
    <div class="headerImage">
        <img src="https://pge.rj.gov.br/site/img/logo.png" alt="PGE - RJ" class="logo">
    </div>
    <div class="headerTitulo">
        <h2 >Benefícios</h2>
    </div>
</div>
<h2>Auxilio Educação</h2>
<h3>Consolidado</h3>
<table id="example" class="display" style="width:100%">
        <thead>
            <tr>               
                <th>Beneficiário</th>
                <th>CPF</th>
                <th>Valor</th>                
                <th>Competência</th>
                <th>Status</th>                
            </tr>
        </thead>
        <tbody>
            <?php      
             foreach ($dependentes as $position => $dependente) {
            ?>
                <tr>                    
                    <td><?php echo $dependente->colaborador_nome; ?></td>
                    <td><?php echo $dependente->colaborador; ?></td>
                    <td><?php echo number_format($dependente->valor,2,",","."); ?></td>                  
                    <td><?php echo $dependente->competencia; ?></td>
                    <td><?php echo $dependente->status; ?></td>                                 
                </tr>    
            <?php } ?>  
        </tbody>        
    </table>

<script type="text/javascript" >  
$(document).ready(function() {
    $('#example').DataTable({
        "language": {
        "sProcessing":    "Procesando...",
        "sLengthMenu":    "Mostrar _MENU_ registros",
        "sZeroRecords":   "Não foram encontrados registros",
        "sEmptyTable":    "Não há dados disponível",
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
   
});
</script>