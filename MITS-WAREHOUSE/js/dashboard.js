$(document).ready(()=>{
    $('#loanBtn').click(loanPage);
    $("#warehouseBtn").click(warehousePage);
    $('#clientBtn').click(clientPage);
    $("#quitBtn").click(logout);
})

function logout(){
    $.get("/server/sessionQuit.php")
    window.location.href="index.php"
}

function warehousePage(){
    window.location.href="warehouseManager.php";
}

function clientPage(){
    window.location.href="clientManager.php";
}

function loanPage(){
    window.location.href="loanManager.php";
}