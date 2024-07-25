$(document).ready(function() {
    $('body').append(`
        <div id="loadingWheelArea" class="modal">
            <div id="loadingSpinner" class="spinner"></div>
        </div>
    `);
});

function showLoadingSpinner() {
    $("#loadingWheelArea").show()
}

// Funzione per nascondere l'elemento di caricamento
function hideLoadingSpinner() {
    $("#loadingWheelArea").hide()
}