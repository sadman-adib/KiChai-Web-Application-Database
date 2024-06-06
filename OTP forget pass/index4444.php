<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>KI CHAI</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" />
    <link rel="stylesheet" href="index.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  </head>
  <body class="body">
     <div class="main-container">
      <Div>
        <img class="left-section" src="assets/images/ba983ffcee38c5372ec7c56618bb44733880cd57.png">
      </Div>
      <div class="right-section">
        <div class="right-top-section">
          <img class="logo" src="assets/images/logo.png">
          <h4 class="welcome-message">Please verify your account!</h4>  
          <p class="info">We sent a verification code to email. Enter the code from the email in the field below.</p> 
        </div>
      </div>
        <div>
            <form class="otp-form" action="/submit-otp" id="otp-form" method="post">
                <p class="info-1">Type your 6 digit security code</p>
                <div class="row">
                  <!-- OTP Input 1 -->
                  <div class="input-field col s2">
                    <input id="otp1" type="text" class="validate center-align otp" maxlength="1">
                  </div>
                  <!-- OTP Input 2 -->
                  <div class="input-field col s2">
                    <input id="otp2" type="text" class="validate center-align otp" maxlength="1">
                  </div>
                  <!-- OTP Input 3 -->
                  <div class="input-field col s2">
                    <input id="otp3" type="text" class="validate center-align otp" maxlength="1">
                  </div>
                  <!-- OTP Input 4 -->
                  <div class="input-field col s2">
                    <input id="otp4" type="text" class="validate center-align otp" maxlength="1">
                  </div>
                  <!-- OTP Input 5 -->
                  <div class="input-field col s2">
                    <input id="otp5" type="text" class="validate center-align otp" maxlength="1">
                  </div>
                  <!-- OTP Input 6 -->
                  <div class="input-field col s2">
                    <input id="otp6" type="text" class="validate center-align otp" maxlength="1">
                  </div>
                </div>
              <div>
                <label class="text-1"><a class="sign-up" href="http://localhost:3000/Vendor%20&%20Specialist%20login%20page%20for%20all/Vendor%20&%20Specialist%20login%20page%20for%20all/page1.php">Login screen</a>Go back to</label>
              </div>
              <a id="submit-btn" class="button" href="http://localhost:3000/vendor%20and%20Specialist%20Reset%20Password/vendor%20and%20Specialist%20Reset%20Password/index3.php">RESET</a>

          </form>
        </div>
     <script>
      document.addEventListener('DOMContentLoaded', function () {
        var inputs = document.querySelectorAll('.otp');
        inputs.forEach(function(input, idx) {
            input.addEventListener('keyup', function (e) {
            if (e.target.value.length === e.target.maxLength && idx < inputs.length - 1) {
                inputs[idx + 1].focus();
            }
            });

            input.addEventListener('keydown', function (e) {
            if (e.key === "Backspace" && e.target.value.length === 0 && idx > 0) {
                inputs[idx - 1].focus();
            }
            });
        });
        });
     
        document.addEventListener('DOMContentLoaded', function () {
          var submitBtn = document.getElementById('submit-btn');
          submitBtn.addEventListener('click', function() {
            var otpInputs = document.querySelectorAll('.otp');
            var otp = Array.from(otpInputs).map(input => input.value).join('');
            // Create form data
            var formData = new FormData();
            formData.append('otp', otp);
            formData.append('csrf-token', document.getElementById('csrf-token').value); // Include CSRF token
    
            // Fetch API to submit form data
            fetch('/submit-otp', {
              method: 'POST',
              body: formData
            })
            .then(response => {
              if (response.ok) {
                // Handle successful form submission
                console.log('Form submitted successfully');
              } else {
                // Handle error response
                console.error('Form submission failed');
              }
            })
            .catch(error => {
              // Handle network errors
              console.error('Error:', error);
            });
          });
        });

        document.getElementById('otp-form').addEventListener('input', function(event) {
            let value = event.target.value;
            value = value.replace(/[^0-9]/g, '');
            event.target.value = value;
            });

      </script>
  </body>
</html>

