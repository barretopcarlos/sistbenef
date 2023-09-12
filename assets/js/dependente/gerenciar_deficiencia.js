$(document).ready(function() {
    
    var deficiencias = jsonData;
    
    $('#deficienciaTable').DataTable({
        responsive: true,
        data: deficiencias,
        columns: [
            { data: 'id', title: 'ID' },
            { data: 'nome', title: 'Dependente' },
            { data: 'nome_deficiencia', title: 'Tipo de Deficiência'},
            { data: 'editar', title: '' , orderable: false, width: '50px'  },
            { data: 'excluir', title: '' , orderable: false, width: '50px' },
        ]
    });
});

$(window).on('resize', function () {
    table.columns.adjust().draw();
});


//EDIÇÃO
$(document).on('click', '.editar', function(event) {

var button = $(this);
var id = button.data('id');
var id_dependente = button.data('id_dependente');
var dependente = button.data('nome');
var id_deficiencia = button.data('id_deficiencia');

// Preencher campos da modal
$('#modalId').val(id);
$('#modalIdDependente').val(id_dependente);
$('#modalNome').val(dependente);
$('#modalDeficiencia').val(id_deficiencia);
$('#modalTipoAcao').val('editar');

// Definir título e ação do botão
$('#confirmationModalLabel').text('Alteração de Tipo de Deficiência');
$('#texto-confirm').text('Deseja prosseguir com a alteração do tipo de deficiência?');
$('#confirmForm').off('click').on('click', function () {
    
    const campoNaoPreenchido = document.getElementById('campo-nao-preenchido');
    const modalDeficiencia = document.getElementById('modalDeficiencia');
    const modalNome = document.getElementById('modalNome');

    if (modalDeficiencia.value === '' || modalNome.value === '' ) {
        campoNaoPreenchido.style.display = 'block'; // Mostra a mensagem de erro
    } else {

        campoNaoPreenchido.style.display = 'none'; // Mostra a mensagem de erro

        form.submit(); // Enviar o formulário se os campos estiverem preenchidos
        
        // Fecha o modal
        const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        confirmationModal.hide();
    }
});

// Abre a modal
$('#confirmationModal').modal('show');
});


//EXCLUSAO
$(document).on('click', '.excluir', function(event) {

var button = $(this);
var id = button.data('id');
var id_dependente = button.data('id_dependente');
var dependente = button.data('nome');
var id_deficiencia = button.data('id_deficiencia'); 

$('#modalDeficiencia').prop('disabled', true);

// Preencher campos da modal
$('#modalId').val(id);
$('#modalIdDependente').val(id_dependente);
$('#modalNome').val(dependente);
$('#modalDeficiencia').val(id_deficiencia);
$('#modalTipoAcao').val('excluir');

// Definir título e ação do botão
$('#confirmationModalLabel').text('Aviso');
$('#texto-confirm').text('Deseja prosseguir com a exclusão do tipo de deficiência?');
$('#confirmForm').off('click').on('click', function () {

    form.submit();

    // Fecha o modal
    const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
    confirmationModal.hide();
});

// Abre a modal
$('#confirmationModal').modal('show');
});



const form = document.getElementById('updateForm');
const atualizarBt = document.getElementById('confirmForm');

atualizarBt.addEventListener('click', function () {

const campoNaoPreenchido = document.getElementById('campo-nao-preenchido');
const modalDeficiencia = document.getElementById('modalDeficiencia');
const modalNome = document.getElementById('modalNome');

if (modalDeficiencia.value === '' || modalNome.value === '' ) {
    campoNaoPreenchido.style.display = 'block'; // Mostra a mensagem de erro
} else {

    campoNaoPreenchido.style.display = 'none'; // Mostra a mensagem de erro

    form.submit(); // Enviar o formulário se os campos estiverem preenchidos
    
    // Fecha o modal
    const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
    confirmationModal.hide();
}

});

