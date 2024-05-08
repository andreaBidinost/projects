html5QrcodeScanner = new Html5QrcodeScanner(
	"qrreader", { fps: 10, qrbox: 0 })

$(document).ready(() => {
    $("#goBackBtn").click(prevoiusPage)

    $("#prSelByQr").click(openQrSection)
    $("#prSelByCode").click(openCodeSelection)
    $("#prSelByName").click(openNameSection)

    setActualDate()
    loadUsers()
    loadResponsibles()


})

function openCodeSelection(){
    $("#productSelectionBox div").hide()
    html5QrcodeScanner.clear();
    $("#productSelectionBox").show()
    $("#selectByCodeBox").show()
    //TODO
}

function openNameSection(){
    $("#productSelectionBox div").hide()    
    html5QrcodeScanner.clear();
    $("#productSelectionBox").show()
    $("#selectByNameBox").show()
    //TODO
}

function openQrSection(){
    $("#productSelectionBox div").hide()
    $("#productSelectionBox").show()
    $("#selectByQrBox").show()

    var boxWidth = $("#selectByQrBox").width()
    var boxHeight = $("#selectByQrBox").height()

    html5QrcodeScanner = new Html5QrcodeScanner(
        "qrreader", { fps: 10, qrbox: { width: boxWidth, height: boxHeight } });
    
    html5QrcodeScanner.render(onScanSuccess);
}

function onScanSuccess(decodedText, decodedResult) {
    // Handle on success condition with the decoded text or result.
    alert(`Scan result: ${decodedText}`, decodedResult);
    html5QrcodeScanner.clear();
}

function setActualDate(){
    const today = new Date();
    const yyyy = today.getFullYear();
    let mm = today.getMonth() + 1; // Months start at 0!
    let dd = today.getDate();

    if (dd < 10) dd = '0' + dd;
    if (mm < 10) mm = '0' + mm;

    const formattedToday = yyyy + '-' + mm + '-' + dd;

    $('#startDate').val(formattedToday);

}

function prevoiusPage() {
    window.location.href = "loanManager.php"
}

function loadUsers() {
    // Effettua una richiesta AJAX per ottenere l'elenco degli utenti
    $.ajax({
        url: URL_GET_ALL_USERS,
        method: "GET",
        dataType: "json",
        success: function(users) {
            // Aggiungi gli utenti alla dropdown
            var userDropdown = $("#borrower");
            userDropdown.empty();
            $.each(users, function(index, user) {
                userDropdown.append($("<option>").val(user.id).text(user.name));
            });
        },
        error: function(xhr, status, error) {
            // Gestione degli errori
            console.error("Errore durante il recupero degli utenti:", error);
        }
    });
}

function loadResponsibles() {
    // Effettua una richiesta AJAX per ottenere l'elenco dei responsabili
    $.ajax({
        url: URL_GET_RESPONSIBLES,
        method: "GET",
        dataType: "json",
        success: function(responsibles) {
            // Aggiungi i responsabili alla dropdown
            var responsibleDropdown = $("#responsible");
            responsibleDropdown.empty();
            $.each(responsibles, function(index, responsible) {
                responsibleDropdown.append($("<option>").val(responsible.id).text(responsible.name));
            });
        },
        error: function(xhr, status, error) {
            // Gestione degli errori
            console.error("Errore durante il recupero dei responsabili:", error);
        }
    });
}