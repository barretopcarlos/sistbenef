<!-- Modal de saída -->
<div class="modal fade" id="sair" tabindex="-1" aria-labelledby="entradaEstoqueLabel" aria-hidden="false" style="z-index:9999;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" >
        <div class="modal-content modal-pge">
            <div class="modal-header">
                <h1 class="modal-title title-navbar fs-4" id="entradaEstoqueLabel">Deseja sair do portal benefícios?</h1>
                <button type="button" class="btn-close-pge" data-bs-dismiss="modal" aria-label="Close" id="close">
                    x
                </button>
            </div>

            <div class="modal-body" >

                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10 fs-pge">
                        <a class="btn nbtnw" href="<?php echo url_for('logout'); ?>">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.6667 15.3333H7.33332C6.96513 15.3333 6.66666 15.0348 6.66666 14.6667C6.66666 14.2985 6.96513 14 7.33332 14H12.6667C13.0348 14 13.3333 13.7015 13.3333 13.3333V2.66666C13.3333 2.29847 13.0348 1.99999 12.6667 1.99999L7.33332 1.99999C6.96513 1.99999 6.66666 1.70151 6.66666 1.33332C6.66666 0.965134 6.96513 0.666657 7.33332 0.666657L12.6667 0.666656C13.7712 0.666656 14.6667 1.56209 14.6667 2.66666V13.3333C14.6667 14.4379 13.7712 15.3333 12.6667 15.3333Z" fill="#FFFFFF"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.65906 8.87324C1.22473 8.37209 1.22473 7.62791 1.65906 7.12676L4.44353 3.91391C5.25189 2.98118 6.78445 3.55288 6.78445 4.78715L6.78445 6H10.7844C11.5208 6 12.1178 6.59695 12.1178 7.33333V8.66666C12.1178 9.40304 11.5208 10 10.7844 10L6.78445 10V11.2128C6.78445 12.4471 5.25189 13.0188 4.44353 12.0861L1.65906 8.87324ZM3.04505 7.56338C2.82789 7.81395 2.82789 8.18604 3.04505 8.43662L5.45112 11.2128V9.66667C5.45112 9.11438 5.89883 8.66667 6.45112 8.66667L10.7844 8.66666V7.33333L6.45112 7.33333C5.89883 7.33333 5.45112 6.88562 5.45112 6.33333L5.45112 4.78715L3.04505 7.56338Z" fill="#FFFFFF"/>
                            </svg> Sim, sair!
                        </a>
                    </div>

                    <div class="col-md-1"></div>
                </div>

            </div>
            <!--<div class="modal-footer ">

            </div>-->
        </div>
    </div>
</div>