html5QrcodeScanner = new Html5QrcodeScanner(
    "qrreader", { fps: 10, qrbox: 0 })

$(document).ready(() => {
    $("#goBackBtn").click(prevoiusPage)

    $("#prSelByQr").click(()=>{openModal("qr")})
    $("#prSelByCode").click(()=>{openModal("code")})
    $("#prSelByName").click(()=>{openModal("name")})

    $("#confirmSelByCode").click(confirmSelByCode)

    setActualDate()
    loadUsers()
    loadResponsibles()


})

function findDescriptionFromCode(newCode){
    $.get(FROM_CODE_TO_DESCRIPTION_URL,
        {
            code:newCode
        },
        (response)=>{
            response = JSON.parse(response)
            if(response.success == true){
                
                $("#selProductId").val(response.id)
                $("#selProductCode").val(response.pCode)
                $("#selProductDesc").val(response.description)
            }else{
                alert("Nessun prodotto associato a questo codice " + newCode)
            }
        }
    )
}

function confirmSelByCode(){

    if($("#selPCode").val() && $("#selPCode").val()!=""){
        findDescriptionFromCode($("#selPCode").val())
        $('#productModal').hide()
    }
}

function onScanSuccess(decodedText, decodedResult) {
    // Handle on success condition with the decoded text or result.
    
    findDescriptionFromCode(decodedText)
    html5QrcodeScanner.clear()
    $('#productModal').hide()
}

function setActualDate() {
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
        success: function (users) {
            // Aggiungi gli utenti alla dropdown
            var userDropdown = $("#borrower");
            userDropdown.empty();
            $.each(users, function (index, user) {
                userDropdown.append($("<option>").val(user.id).text(user.name));
            });
        },
        error: function (xhr, status, error) {
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
        success: function (responsibles) {
            // Aggiungi i responsabili alla dropdown
            var responsibleDropdown = $("#responsible");
            responsibleDropdown.empty();
            $.each(responsibles, function (index, responsible) {
                responsibleDropdown.append($("<option>").val(responsible.id).text(responsible.name));
            });
        },
        error: function (xhr, status, error) {
            // Gestione degli errori
            console.error("Errore durante il recupero dei responsabili:", error);
        }
    });
}

function openModal(productEntryKind) {

    $('.productSelectionBox').hide()

    switch(productEntryKind){
        case "qr":{
            prepareModalForQr()
            break;
        }
        case "code":{
            prepareModalForCode()
            break;
        }
        case "name":{
            prepareModalForName()
            break;
        }
    }

    $('#productModal').show()
}

function prepareModalForQr(){
    $("#selectByQrBox").show()
    var boxWidth = parseInt($(".modal-content").width()/3)

    html5QrcodeScanner = new Html5QrcodeScanner(
        "qrreader", { fps: 10, qrbox: { width: 250, height:250} });

    html5QrcodeScanner.render(onScanSuccess);
}

function prepareModalForCode(){
    $("#selectByCodeBox").show()
}

function prepareModalForName(){
    
}

// Chiudi la modal alla pressione del pulsante di chiusura o cliccando al di fuori di essa
$(window).click(function (event) {
    if (event.target.id == 'productModal') {
        $('#productModal').hide()
        html5QrcodeScanner.clear(); 
    }
});

$('.close').click(function () {
    $('#productModal').hide()
    html5QrcodeScanner.clear();
});