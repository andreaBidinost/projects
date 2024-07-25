loanStatus = [
    { cssClass: "loan-waiting", msg: "Non preso in carico" },
    { cssClass: "loan-confirmed", msg: "Preso in carico" },
    { cssClass: "loan-terminated", msg: "Riconsegnato" }
]

$(document).ready(function () {
    $("#goBackBtn").click(prevoiusPage);
    loadLoanHistory()

});

function prevoiusPage() {
    window.location.href = "loanManager.php"
}

function loadLoanHistory() {
    $.ajax({
        url: URL_LOAN_HISTORY,
        type: "GET",
        dataType: "json",
        success: function (loanHistory) {
            renderLoanHistory(loanHistory);
        },
        error: function (xhr, status, error) {
            console.error("Errore durante il caricamento dello storico dei prestiti.");
        }
    });
}

function italianDate(engDate) {
    dateParts = engDate.split("-")
    return dateParts[2] + "/" + dateParts[1] + "/" + dateParts[0]
}

function renderLoanHistory(loanHistory) {
    var loanList = $("#loanList");
    loanList.empty();
    $.each(loanHistory, function (index, loan) {
        var listItem = $("<div>").addClass("loan-item").html(`
            <div class="period"> ${italianDate(loan.startDate)} &rarr; ${italianDate(loan.endDate)}</div>
            <div class="brw">${loan.borrower}</div>
            <div class="qty"> ${loan.quantity} pcs</div>
            <div class='loanStatus'> <span class="dot ${loanStatus[loan.lStatus].cssClass}"></span> ${loanStatus[loan.lStatus].msg}</span></div>
            <button class="view-details" loanId="${loan.loanId}"></button>            
        `);
        loanList.append(listItem);

        $(".view-details").click(() => { openLoanDetail($(this).attr("loanId")) });
    });
}

function openLoanDetail(id) {
    $.post(URL_GET_LOAN_DATA,
        { loanId: id },
        (response) => {
            loanDetails = JSON.parse(response)
            $("#loanDetails").html(`
            <p><b>Data di Presa in Carico:</b> ${loanDetails.startDate}</p>
            <p><b>Data di Restituzione:</b> ${loanDetails.endDate}</p>
            <p><b>Destinatario:</b> ${loanDetails.borrower}</p>            
            <p><b>Autorizzatario:</b> ${loanDetails.responsibleName}</p>
            <p><b>Responsabile del materiale:</b> ${loanDetails.responsibleName}</p>
            <p><b>Quantità Prestata:</b> ${loanDetails.qty}</p>
            <p><b>Stato:</b> ${loanStatus[loanDetails.lStatus].msg}</p>
        `);
            $("#loanDetailsModal").show();
        });


}

$(".close").click(function () {
    $("#loanDetailsModal").hide();
});
