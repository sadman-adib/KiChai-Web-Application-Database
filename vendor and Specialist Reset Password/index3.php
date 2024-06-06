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
          <h4 class="welcome-message">Reset Your Password</h4>  
          <p class="info">We sent a verification code to email. Enter the code from the email in the field below.</p>      
        </div>
      </div>
        <div>
          <form action="">
            <div>
              <input class="default-stroke" type="password" id="New-password" name="New-password" placeholder="New password">
              <span class="password-toggle" onclick="togglePassword('New-password')"><i class="far fa-eye"></i></span>
            </div>
            <div >
              <input class="default-stroke-2" type="password" id="Confirm-new-password" name="Confirm-new-password" placeholder="Confirm your new password">
              <span class="password-toggle-1" onclick="togglePassword1('Confirm-new-password')"><i class="far fa-eye"></i></span>
            </div>
          </div>
              <button class="button" type="submit">RESET</button>
              <div>
                <label class="text-1"><a class="sign-up" href="http://localhost:3000/Vendor%20&%20Specialist%20login%20page%20for%20all/Vendor%20&%20Specialist%20login%20page%20for%20all/page1.php">Login screen</a>Go back to</label>
              </div>
          </form>
        </div>
     <script>
      function togglePassword(inputId) {
      var passwordField = document.getElementById(inputId);
      var passwordToggle = document.querySelector(`#${inputId} + .password-toggle i`);
      if (passwordField.type === "password") {
        passwordField.type = "text";
        passwordToggle.classList.remove("fa-eye");
        passwordToggle.classList.add("fa-eye-slash");
      } else {
        passwordField.type = "password";
        passwordToggle.classList.remove("fa-eye-slash");
        passwordToggle.classList.add("fa-eye");
      }
    }
    
    function togglePassword1(inputId) {
      var passwordField = document.getElementById(inputId);
      var passwordToggle = document.querySelector(`#${inputId} + .password-toggle-1 i`);
      if (passwordField.type === "password") {
        passwordField.type = "text";
        passwordToggle.classList.remove("fa-eye");
        passwordToggle.classList.add("fa-eye-slash");
      } else {
        passwordField.type = "password";
        passwordToggle.classList.remove("fa-eye-slash");
        passwordToggle.classList.add("fa-eye");
      }
    }

      document.getElementById("Confirm-new-password").addEventListener("input", function() {
      if (this.value.trim() !== "") {
          this.classList.add("input-filled");
        } else {
          this.classList.remove("input-filled");
        }
      });
      document.getElementById("New-password").addEventListener("input", function() {
      if (this.value.trim() !== "") {
          this.classList.add("input-filled");
        } else {
          this.classList.remove("input-filled");
        }
      });
      </script>
  </body>
</html>

