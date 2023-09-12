document.addEventListener('DOMContentLoaded', function () {
    
    const form = document.getElementById('cadastroBeneficio');
    
    const modalTipoBeneficio = document.getElementById('modalTipoBeneficio');
    const modalDiaLimite = document.getElementById('modalDiaLimite');
    const modalTetoGasto = document.getElementById('modalTetoGasto');
    const modalReembolso = document.getElementById('modalReembolso');

    const openModalButton = document.getElementById('openConfirmationModal');
    const confirmFormButton = document.getElementById('confirmForm');

    const erroValidacao = document.getElementById('erroValidacao');

    openModalButton.addEventListener('click', function () {

        event.preventDefault();
    
        if (!form.tipoBeneficio.value || !form.diaLimite.value || !form.tetoGasto.value || !form.reembolso.value) {
            erroValidacao.style.display = 'block'; // Mostra a mensagem de erro
        } else {
            erroValidacao.style.display = 'none'; // Esconde a mensagem de erro

            // Preenche o conteúdo do modal
            modalTipoBeneficio.textContent = form.tipoBeneficio.value;
            modalDiaLimite.textContent = form.diaLimite.value;
            modalTetoGasto.textContent = form.tetoGasto.value;
            modalReembolso.textContent = form.reembolso.value;

            // Mostra o modal de confirmação
            const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            confirmationModal.show();
        }


    });

    confirmFormButton.addEventListener('click', function () {
        form.submit(); // Envia o formulário
    });
});
