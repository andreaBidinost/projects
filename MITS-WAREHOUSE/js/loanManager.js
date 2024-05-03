$(document).ready(()=>{
    $("#goBackBtn").click(prevoiusPage)    
    $("#newBtn").click(newLoanPage);
    $("#returnBtn").click(returnLoanPage);
    $('#loanHistoryBtn').click(loanHistoryPage);
    $("#availableBtn").click(availablePage);
})

function newLoanPage(){
    window.location.href="newLoan.php"
}

function returnLoanPage(){
    window.location.href="returnLoan.php";
}

function loanHistoryPage(){
    window.location.href="loanHistory.php";
}

function availablePage(){
    window.location.href="availableItems.php";
}

function prevoiusPage(){
    window.location.href="dashboard.php"
}