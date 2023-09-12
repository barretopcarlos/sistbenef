$(document).ready(function() {
    var tiposBeneficio = jsonData;
    
    $('#beneficioTable').DataTable({
        responsive: true,
        data: tiposBeneficio,
        columns: [
            { data: 'id', title: 'ID' },
            { data: 'beneficio', title: 'Benefício' },
            { data: 'diaLimite', title: 'Dia Limite da Entrega'},
            { data: 'reembolso', title: 'Reembolso' },
            { data: 'tetoGasto', title: 'Teto de Gasto' },
            { data: 'editar', title: '', orderable: false },
            
            
        ]
    });
});


$(document).on('click', '.editar', function(event) {
   
    var button = $(this);
    var id = button.data('id');
    var beneficio = button.data('beneficio');
    var diaLimite = button.data('dialimite'); 
    var reembolso = button.data('reembolso');
    var tetoGasto = button.data('tetogasto'); 

    // Preencher campos da modal
    $('#modalId').val(id);
    $('#modalBeneficio').val(beneficio);
    $('#modalDiaLimite').val(parseInt(diaLimite));
    $('input[name="modalReembolso"][value="'+reembolso+'"]').prop('checked', true);
    $('input[name="modalTetoGasto"][value="'+tetoGasto+'"]').prop('checked', true);

    // Abre a modal
    $('#confirmationModal').modal('show');
});


const form = document.getElementById('updateForm');
const atualizarBt = document.getElementById('confirmForm');

atualizarBt.addEventListener('click', function () {

    const campoNaoPreenchido = document.getElementById('campo-nao-preenchido');
    const modalBeneficio = document.getElementById('modalBeneficio');
    const modalDiaLimite = document.getElementById('modalDiaLimite');

    if (modalBeneficio.value === '' || modalDiaLimite.value === '' ) {
        
        campoNaoPreenchido.style.display = 'block'; // Mostra a mensagem de erro

    } else {

        campoNaoPreenchido.style.display = 'none'; // Mostra a mensagem de erro

        form.submit(); // Enviar o formulário se os campos estiverem preenchidos
        
        // Fecha o modal
        const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        confirmationModal.hide();

        // Recarrega a DataTable (exemplo com jQuery DataTables)
        //$('#beneficioTable').DataTable().ajax.reload(); 
    }

});


// Evento disparado ao fechar a modal
$('#confirmationModal').on('hidden.bs.modal', function () {
    var campoNaoPreenchidoDiv = document.getElementById('campo-nao-preenchido');
    campoNaoPreenchidoDiv.style.display = 'none';
});