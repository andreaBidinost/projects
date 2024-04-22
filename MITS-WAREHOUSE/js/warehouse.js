$(document).ready(()=>{
    $("#goBackBtn").click(prevoiusPage)    
    $("#newBtn").click(newProductPage);
    $("#uploadBtn").click(uploadProductPage);
    $('#downloadBtn').click(downloadProductPage);
    $("#viewBtn").click(viewProductsPage);
})

function newProductPage(){
    window.location.href="newProduct.php"
}

function uploadProductPage(){
    window.location.href="uploadProduct.php";
}

function downloadProductPage(){
    window.location.href="downloadProduct.php";
}

function viewProductsPage(){
    window.location.href="viewProductList.php";
}

function prevoiusPage(){
    window.location.href="dashboard.php"
}