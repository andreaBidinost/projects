// Assuming you're using jQuery for AJAX
$(document).ready(function() {
    $('#loginBtn').click(function(event) {
  
      // Get the values from the form fields
      var username = $('#username').val();
      var password = $('#password').val();
  
      // Send a POST request to the PHP file
      $.post(URL_LOGIN, { username: username, password: password }, function(response) {
        // Handle the response from the PHP file
        r = JSON.parse(response)
        if(r.success){
          window.location.href="dashboard.php"
        }else{
          alert("Username o password non validi")
        }
        // You can perform actions based on the response here
      });
    });
  });
  