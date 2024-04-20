// Assuming you're using jQuery for AJAX
$(document).ready(function() {
    $('#loginBtn').click(function(event) {
  
      // Get the values from the form fields
      var username = $('#username').val();
      var password = $('#password').val();
  
      // Send a POST request to the PHP file
      $.post('server/loginFake.php', { username: username, password: password }, function(response) {
        // Handle the response from the PHP file
        window.location.href="dashboard.php"
        // You can perform actions based on the response here
      });
    });
  });
  