
<h2>Auxilio Educação</h2>

<table id="example" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Valor</th>
            <th>Data Cadastro</th>
        </tr>
    </thead>

    <tbody>
        <?php $index = 0;?>
        <?php forEach($tetosPagamento AS $row ): ?>
            <?php 
                $index++;
                $classe = $index == 1 ? "style='background-color: #c3e6cb !important;'" : '';
            ?>
            <tr>
                <td <?= $classe; ?> ><?= $row->id; ?></td>
                <td <?= $classe; ?> ><?= number_format($row->valor, 2, ",", "."); ?></td>
                <td <?= $classe; ?> ><?= date("d/m/Y H:i:s", strtotime($row->data_cadastro)); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
               
</table>



<script defer type="module">
    const tabela = $('#example').DataTable({
        "order": [[ 0, 'desc' ]],
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
</script>