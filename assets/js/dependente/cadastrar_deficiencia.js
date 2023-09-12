document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('cadastroDeficiencia');
    const modalDependente = document.getElementById('modalDependente');
    const modalTipoDeficiencia = document.getElementById('modalTipoDeficiencia');
    const openModalButton = document.getElementById('openConfirmationModal');
    const confirmFormButton = document.getElementById('confirmForm');
    const erroValidacao = document.getElementById('erroValidacao');

    openModalButton.addEventListener('click', function () {

        event.preventDefault();
    
        if (!form.dependente.value || !form.tipoDeficiencia.value ) {
            erroValidacao.style.display = 'block'; // Mostra a mensagem de erro
        } else {
            erroValidacao.style.display = 'none'; // Esconde a mensagem de erro

            // índice da opção selecionada
            const dependenteIndex = form.dependente.selectedIndex;
            const tipoDeficienciaIndex = form.tipoDeficiencia.selectedIndex;

            // opção selecionada usando o índice
            const dependenteSelectedOption = form.dependente.options[dependenteIndex];
            const tipoDeficienciaSelectedOption = form.tipoDeficiencia.options[tipoDeficienciaIndex];

            // Valor e o texto da opção selecionada
            const dependenteValue = dependenteSelectedOption.value;
            const dependenteText = dependenteSelectedOption.textContent;

            const tipoDeficienciaValue = tipoDeficienciaSelectedOption.value;
            const tipoDeficienciaText = tipoDeficienciaSelectedOption.textContent;

            // Preencher o conteúdo do modal com os textos das opções selecionadas
            modalDependente.textContent = dependenteText;
            modalTipoDeficiencia.textContent = tipoDeficienciaText;

            // Mostra o modal de confirmação
            const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            confirmationModal.show();
        }


    });

    confirmFormButton.addEventListener('click', function () {
        form.submit(); 
    });
});


const dependenteSelect = document.getElementById('dependente');
const tipoDeficienciaSelect = document.getElementById('tipoDeficiencia');

dependenteSelect.addEventListener('change', () => {
    if (dependenteSelect.value !== '') {
        tipoDeficienciaSelect.removeAttribute('disabled');
    } else {
        tipoDeficienciaSelect.setAttribute('disabled', 'true');
    }
});