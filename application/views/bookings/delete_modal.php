<div class='modal fade' id="modalDelete" tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
    <div class='modal-dialog modal-dialog-centered'>
        <div class='modal-content'>
            <div class='modal-header modal-header-danger'>
                <h2 class='modal-title' id='exampleModalLabel'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i>Cancelamento</h2>
            </div>
            <div class='modal-body'>
                <?= $cancel_msg ?>
            </div>
            <div class='modal-footer'>
                <button id="bookingDelete" type='submit' name='cancel' class='btn btn-outline-danger' value="">Sim</button>
                <button type='button' class='btn btn-outline-primary' data-dismiss='modal'>Não</button>
            </div>
        </div>
    </div>
</div>