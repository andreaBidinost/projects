$(document).ready(()=>{
    populateResponsibles()

    $("#goBackBtn").click(prevoiusPage)    

    $(".submit").click(submitData)
})

function populateResponsibles() {
    $.get(URL_GET_LOAN_RESPONSIBLES, function(data) {
      // Parse the response as JSON
      var responsibles = JSON.parse(data);

      // Clear existing options
      $('#responsible').empty();

      // Add new options from responsibles array
      $.each(responsibles, function(index, responsible) {
        $('#responsible').append('<option value="' + responsible.id + '">' + responsible.name + '</option>');
      });
    });
  }

function submitData(){
    var productName = $('#product-name').val();
    var photo = $('#photo').prop('files')[0];
    var demoLink = $('#demo-link').val();
    var notes = $('#notes').val();
    var responsible = $('#responsible').val();
    var available = $('#available').val();

    // Create FormData object and append input values
    var formData = new FormData();
    formData.append('product-name', productName);
    formData.append('photo', photo);
    formData.append('demo-link', demoLink);
    formData.append('notes', notes);
    formData.append('responsible', responsible);
    formData.append('available', available);

    $.post(URL_INSERT_NEW_PRODUCT,formData,(response)=>{
        console.log(response)
    })
}


function prevoiusPage(){
    window.location.href="warehouseManager.php"
}