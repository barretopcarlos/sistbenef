
<div style="width: 100% !important;display: flex;flex-direction: column;justify-content: flex-start;align-items: flex-start;gap: 20px">
    <?php if( count($history) > 0 ): ?>
        <?php forEach( $history AS $index => $row ): ?>
            <?php
                $index++;
                $data = date("d/m/Y", strtotime($row->data_registro));
                $msg = "";
                
                if( $row->tipo == "valor" ):
                    $row->valor_antigo  = number_format($row->valor_antigo, 2, ',', '.'); 
                    $row->valor_novo    = number_format($row->valor_novo, 2, ',', '.');
                    $msg = " <strong>$data</strong> O valor foi alterado de <strong>{$row->valor_antigo}</strong> para <strong>{$row->valor_novo}</strong> ";
                else:
                    $msg = " <strong>$data</strong> O status foi alterado para <strong>{$row->valor_novo}</strong>";
                endif;

                $msg .= "<br> <strong>Obs.:</strong> $row->observacao";
                $msg = "<span style='text-align: left'> {$index} - {$msg}</span>";
            ?>

                <?= $msg; ?>
        <?php endforeach; ?>

    <?php else: ?>
        <span><strong>Nenhum histórico foi encontrado!</strong></span>
    <?php endif; ?>
</div>