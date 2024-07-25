// Assuming you're using jQuery for AJAX
$(document).ready(function() {
    $('#loginBtn').click(function(event) {
  
      // Get the values from the form fields
      var username = $('#username').val();
      var password = $('#password').val();

      if(!username || username=='' || !password || password==''){
        mitsAlert(MITSALERT_ERROR, "Riempire i campi richiesti", nullFieldCallback)
        return;
      }
  
      // Send a POST request to the PHP file
      $.post(URL_LOGIN, { username: username, password: password }, function(response) {
        // Handle the response from the PHP file
        r = JSON.parse(response)
        if(r.success){
          window.location.href="./dashboard.php"
        }else{
          alert("Username o password non validi")
        }
        // You can perform actions based on the response here
      });
    });
  });

function nullFieldCallback(){
  $("#username").addClass("field-error");  
  $("#password").addClass("field-error");
}