html5QrcodeScanner = new Html5QrcodeScanner(
    "qrreader", { fps: 10, qrbox: 0 })

$(document).ready(() => {
    $("#goBackBtn").click(prevoiusPage)

    $("#prSelByQr").click(() => { openModal("qr") })
    $("#prSelByCode").click(() => { openModal("code") })
    $("#prSelByName").click(() => { openModal("name") })

    $("#confirmSelByCode").click(confirmSelByCode)

    $("form input").prop("disabled", true)
    $("#responsible").prop("disabled", true)

    loadUsers()

    $("#borrower").change(populateLoanDetails)

    $("#confirmComeBack").click(confirmComeBack)

    $(".advice").hide()
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

function populateLoanDetails() {
    if ($("#selProductId").val() && $("#selProductId").val() != "" && $("#borrower").val() != "") {
        $.post(URL_GET_LOAN_DATA,
            {
                productId: $("#selProductId").val(),
                borrowerId: $("#borrower").val()
            },
            (response) => {
                response = JSON.parse(response)
                if (response.status == "success") {
                    $("#quantity").val(response.qty)
                    $("#startDate").val(response.startDate)
                    $("#endDate").val(response.endDate)
                    $("#responsible").val(response.responsibleName)
                    $("#loanId").val(response.loanId)
                    $(".advice").show()
                    askForPdf(response.loanId)
                } else {
                    alert("Problema nella comunicazione col server")
                }
            }
        )
    }
}

const b64toBlob = (b64Data, contentType = '', sliceSize = 512) => {
    const byteCharacters = atob(b64Data);
    const byteArrays = [];

    for (let offset = 0; offset < byteCharacters.length; offset += sliceSize) {
        const slice = byteCharacters.slice(offset, offset + sliceSize);

        const byteNumbers = new Array(slice.length);
        for (let i = 0; i < slice.length; i++) {
            byteNumbers[i] = slice.charCodeAt(i);
        }

        const byteArray = new Uint8Array(byteNumbers);
        byteArrays.push(byteArray);
    }

    const blob = new Blob(byteArrays, { type: contentType });
    return blob;
}

function askForPdf(id) {
    $.ajax({
        url: URL_GET_PRODUCT_PDF, // Replace with your PHP script URL
        method: 'POST',
        xhrFields: {
            responseType: 'blob' // Set the response type to blob
        },
        success: function (data, status, xhr) {
            // Check if the response is a Blob and the Content-Type is PDF
            const contentType = xhr.getResponseHeader('Content-Type');
            if (data instanceof Blob && contentType.includes('application/pdf')) {
                const blobURL = URL.createObjectURL(data);
                window.open(blobURL, '_blank');
            } else {
                console.error('Expected a PDF file but got:', contentType);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error fetching and opening the PDF:', error);
        }
    });
}

function confirmSelByCode() {

    if ($("#selPCode").val() && $("#selPCode").val() != "") {
        findDescriptionFromCode($("#selPCode").val())
        populateLoanDetails()
        $('#productModal').hide()
    }
}

function onScanSuccess(decodedText, decodedResult) {
    // Handle on success condition with the decoded text or result.
    findDescriptionFromCode(decodedText)
    populateLoanDetails()
    html5QrcodeScanner.clear()
    $('#productModal').hide()
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


function showLoadingSpinner() {
    $("#loadingWheelArea").show()
}

// Funzione per nascondere l'elemento di caricamento
function hideLoadingSpinner() {
    $("#loadingWheelArea").hide()
}

function confirmComeBack() {
    showLoadingSpinner()

    $.post(
        URL_CLOSE_LOAN,
        {
            loanId: $("#loanId").val()
        },
        (response) => {
            response = json.parse(response)
            if (response.status == "success") {
                openConfirmClosedLoan()
            }
        }
    )
}

async function openConfirmClosedLoan() {
    $("#confirmLoanModal").show()
    await new Promise(r => setTimeout(r, 5000))
    window.location.href = "loanManager.php"
}