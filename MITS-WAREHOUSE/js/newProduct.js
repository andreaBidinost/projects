$(document).ready(() => {
  allowMultipleImageUpload()
  populateResponsibles()

  $("#goBackBtn").click(prevoiusPage)

  $("#available-loan").change(changeLoanAvailability)

  $(".submit").click(submitData)
})

function changeLoanAvailability(){
  $("#available-loan").val() == "SI" ? $(".loanDetails").show() : $(".loanDetails").hide()
}

function allowMultipleImageUpload() {

  $("#photo").attr('multiple', true);
}
function populateResponsibles() {
  $.get(URL_GET_LOAN_RESPONSIBLES, function (data) {
    // Parse the response as JSON
    var responsibles = JSON.parse(data);

    // Clear existing options
    $('#responsible').empty();

    // Add new options from responsibles array
    $.each(responsibles, function (index, responsible) {
      $('#responsible').append('<option value="' + responsible.id + '">' + responsible.name + '</option>');
    });
  });
}

function submitData() {
  var productName = $('#product-name').val();
  var quantity = $("#quantity").val();
  var photos = $('#photo').prop('files');
  var demoLink = $('#demo-link').val();
  var notes = $('#notes').val();
  var responsible = $('#responsible').val();
  var available_loan = $('#available-loan').val();
  
  var notes_loan_go = $('#notes-loan-go').val();
  var notes_loan_back = $('#notes-loan-back').val();
  var photo_loan_back = $('#photo-loan-back').val();

  

  // Create FormData object and append input values
  var formData = new FormData();
  formData.append('product-name', productName);  
  formData.append('quantity', quantity)
  formData.append('demo-link', demoLink);
  formData.append('notes', notes);
  formData.append('responsible', responsible);
  formData.append('available-loan', available_loan);
  
  formData.append('notes-loan-go', notes_loan_go);
  
  formData.append('notes-loan-back', notes_loan_back);

  for (var i = 0; i < photos.length; i++) {
    formData.append('photos[]', photos[i]); // Usa 'photo[]' per gestire più file
  }

  for (var i = 0; i < photo_loan_back.length; i++) {
    formData.append('photos-loan-back[]', photo_loan_back[i]); // Usa 'photo[]' per gestire più file
  }

  $.ajax({
    url: URL_INSERT_NEW_PRODUCT,
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      response = JSON.parse(response);
      openModal(response.pCode, response.description);
    },
    error: function (xhr, status, error) {
      console.log(error)
    }
  });

}


function prevoiusPage() {
  window.location.href = "warehouseManager.php"
}

async function openModal(productCode, description) {
  $("#qrCode").empty()
  new QRCode("qrCode", {
    text: productCode,
    width: 200,
    height: 200,
    colorDark: "#000000",
    colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.H
  })


  description = description.replace("'", "&#39;")

  $("#productCode").text("Codice nuovo prodotto: " + productCode)
  hiddenPCode = $("<input type='hidden' id='hidePrCode' value='" + productCode + "'>")
  $("body").append(hiddenPCode)

  await new Promise(r => setTimeout(r, 1000))
  addInfoToQr(productCode, description)
  $('#qrModal').show()
}


// Chiudi la modal alla pressione del pulsante di chiusura o cliccando al di fuori di essa
$(window).click(function (event) {
  if (event.target == $('#qrModal')) {
    $('#qrModal').hide()
  }
});

$('.close').click(function () {
  $('#qrModal').hide()
});

// Gestisci il download dell'immagine alla pressione del pulsante "Scarica Foto"
$('#download-link').click(function () {
  var imageSrc = $('#qrCode img').attr('src')

  var a = document.createElement("a"); //Create <a>
  a.href = imageSrc //Image Base64 Goes here
  a.download = $("#hidePrCode").val() + ".png"; //File name Here

  a.click(); //Downloaded file
});

function addInfoToQr(prCode, prDescription) {
  // Immagine in base64
  var base64Image = $('#qrCode img').attr('src')

  // Creazione di un elemento immagine
  var image = new Image();
  image.src = base64Image;

  image.onload = function () {
    // Creazione di un canvas
    var canvas = document.getElementsByTagName("canvas")[0];
    var ctx = canvas.getContext("2d");

    heightTextBlock = image.height * 0.1
    lines = Math.ceil(prDescription.length / 35)

    // Impostazione delle dimensioni del canvas
    canvas.width = image.width;
    canvas.height = image.height + (heightTextBlock * (lines + 2)); // Altezza + 25% per lo spazio bianco

    // Disegno dell'immagine sul canvas
    ctx.drawImage(image, 0, 0);

    ctx.fillStyle = "white"
    ctx.fillRect(0, image.height, canvas.width, (lines + 2) * heightTextBlock) // Rettangolo dal 15% in basso

    ctx.fillStyle = "black";
    ctx.font = "10px Arial";
    ctx.textAlign = "center";

    nLine = 0
    for (i = 0; i < prDescription.length; i = i + 35, nLine++) {
      subStr = prDescription.substring(i, i + 35)
      ctx.fillText(subStr, canvas.width / 2, canvas.height - heightTextBlock * (lines + 1 - nLine)); // Posizione: centrato e 10% dall'alto
    }

    ctx.fillStyle = "black";
    ctx.font = "bold 20px Arial";
    ctx.textAlign = "center";

    // Disegno del testo sul canvas
    ctx.fillText(prCode, canvas.width / 2, canvas.height); // Posizione: centrato e 10% dall'alto

    var pngUrl = canvas.toDataURL();
    $("#qrCode img").attr('src', pngUrl)
  };
}

$('#csv-file').change(function (event) {
  var file = event.target.files[0];
  if (file) {
    // Leggi il contenuto del file CSV
    var reader = new FileReader();
    reader.onload = function (e) {
      var csvContent = e.target.result;
      sendData(csvContent); // Invia i dati al server
    };
    reader.readAsText(file);
  }
});

// Funzione per inviare i dati al server
function sendData(csvContent) {
  $.ajax({
    url: URL_UPLOAD_CSV,
    type: 'POST',
    data: { csvContent: csvContent },
    success: function (response) {
      // Gestisci la risposta dal server
    },
    error: function (xhr, status, error) {
      // Gestisci gli errori
    }
  });
}

// Evento click per il pulsante "Carica CSV"
$('#csv-upload').click(function () {
  $('#csv-file').click(); // Simula il click sull'input file
});
