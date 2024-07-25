productList = []
maxConfirmTimer = "03:00"
cdInterval = null
poolInterval = null

html5QrcodeScanner = new Html5QrcodeScanner(
    "qrreader", { fps: 10, qrbox: 0 })

$(document).ready(() => {
    $("#goBackBtn").click(prevoiusPage)

    $("#prSelByQr").click(() => { openModal("qr") })
    $("#prSelByCode").click(() => { openModal("code") })
    $("#prSelByName").click(() => { openModal("name") })

    $("#confirmSelByCode").click(confirmSelByCode)

    $("#saveNewLoan").click(saveNewLoan)

    $('input[type="date"]').val(getActualDate());
    loadUsers()
    loadResponsibles()
})

function findDescriptionFromCode(newCode) {
    $.get(FROM_CODE_TO_DESCRIPTION_URL,
        {
            code: newCode
        },
        (response) => {
            response = JSON.parse(response)
            if (response.success == true) {

                $("#selProductId").val(response.id)
                $("#selProductCode").val(response.pCode)
                $("#selProductDesc").val(response.description)
            } else {
                alert("Nessun prodotto associato a questo codice " + newCode)
            }
        }
    )
}

function confirmSelByCode() {

    if ($("#selPCode").val() && $("#selPCode").val() != "") {
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

function getActualDate() {
    const today = new Date();
    const yyyy = today.getFullYear();
    let mm = today.getMonth() + 1; // Months start at 0!
    let dd = today.getDate();

    if (dd < 10) dd = '0' + dd;
    if (mm < 10) mm = '0' + mm;

    const formattedToday = yyyy + '-' + mm + '-' + dd;

    return formattedToday;
}

function getAcualDateTime() {
    const today = new Date();
    const yyyy = today.getFullYear();
    let mm = today.getMonth() + 1; // Months start at 0!
    let dd = today.getDate();

    let hh = today.getHours()
    let min = today.getMinutes()
    let ss = today.getSeconds()

    if (dd < 10) dd = '0' + dd;
    if (mm < 10) mm = '0' + mm;

    formattedTodayDT = `${yyyy}-${mm}-${dd} ${hh}:${min}:${ss}`;

    return formattedTodayDT;
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

    switch (productEntryKind) {
        case "qr": {
            prepareModalForQr()
            break;
        }
        case "code": {
            prepareModalForCode()
            break;
        }
        case "name": {
            prepareModalForName()
            break;
        }
    }

    $('#productModal').show()
}

function prepareModalForQr() {
    $("#selectByQrBox").show()
    var boxWidth = parseInt($(".modal-content").width() / 3)

    html5QrcodeScanner = new Html5QrcodeScanner(
        "qrreader", { fps: 10, qrbox: { width: 250, height: 250 } });

    html5QrcodeScanner.render(onScanSuccess);
}

function prepareModalForCode() {
    $("#selectByCodeBox").show()
}

function prepareModalForName() {

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

function checkFields() {
    //TODO
    return true;
}

function addProductToLoanList() {
    if (!checkFields()) {
        alert("Alcuni campi non sono stati correttamente compilati")
        return;
    }
    newProduct = {
        id: $("#selProductId").val(),
        qty: $("#quantity").val(),
        startDate: $("#startDate").val(),
        endDate: $("#endDate").val()
    }

    productList.push(newProduct)
}

function updateFieldsForNewObject() {
    //TODO
    return;
}

function addObject() {
    addProductToLoanList();
    updateFieldsForNewObject();
}


function saveNewLoan() {
    showLoadingSpinner()
    if (productList.length == 0) {
        addProductToLoanList()
    }

    loanData = {
        borrowerId: $("#borrower").val(),
        borrowTS: getAcualDateTime(),
        products: productList
    }

    proceedWithUserConfirmation(loanData)
}

function proceedWithUserConfirmation(loanData) {
    event.preventDefault()
    $.post(SEND_CONFIRM_LOAN_EMAIL,
        loanData,
        (response) => {
            hideLoadingSpinner()
            response = JSON.parse(response)
            if (response.status=="success") {
                openConfirmLoanModal(response.borrowerMail, response.newLoanId)
            } else {
                alert("Qualcosa è andato storto, riprova o contatta Bidinost")
            }
        }
    )
}

function openConfirmLoanModal(mail, loanId) {
    $("#borrowerMail").text(mail)
    $("#confirmTimer").text(maxConfirmTimer)

    $(".confirmMsg").hide()
    $("#waitingConfirmMsg").show()
    $("#confirmLoanModal").show()

    startConfirmCountdown()
    startConfirmationWatcher(loanId)
}

function startConfirmCountdown() {
    cdInterval = setInterval(subtractSecToCuntdown, 1000)
}

async function subtractSecToCuntdown() {
    countDown = $("#confirmTimer").text().split(":");
    cdMin = parseInt(countDown[0])
    cdSec = parseInt(countDown[1])

    cdSec -= 1
    if (cdSec == -1) {
        cdSec = 59
        cdMin -= 1
    }

    $("#confirmTimer").text((cdMin < 10 ? "0" : "") + cdMin.toString() + ":" + (cdSec < 10 ? "0" : "") + cdSec.toString())

    if (cdMin == 0 && cdSec == 0) {
        clearInterval(cdInterval)
        $(".confirmMsg").hide()
        $("#confirmationFailureMsg").show()
        await new Promise(r => setTimeout(r, 5000))
        window.location.href = "newLoan.php"
    }
}

function startConfirmationWatcher(loanId) {
    poolInterval = setInterval(() => { watchLoanConfirm(loanId) }, 5000)
}

function watchLoanConfirm(loanId) {

    if ($("#confirmTimer").text() == "00:00") {
        clearInterval(poolInterval)
        return
    }

    $.post(LOAN_CONFIRM_WATCHER,
        {
            id: loanId
        },
        async (response) => {
            response = JSON.parse(response)
            if (response.status) {
                if (response.loanStatus) {

                    $(".confirmMsg").hide()
                    $("#confirmMsgReceived").show()
                    clearInterval(cdInterval)
                    clearInterval(poolInterval)
                    await new Promise(r => setTimeout(r, 3000))
                    window.location.href= "loanHistory.php"
                }
            } else {
                alert("Errore di comunicazione con il server")
            }
        }
    )
}