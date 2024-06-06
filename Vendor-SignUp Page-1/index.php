<?php
session_start(); // Start the session to store form data temporarily

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $cname = $_POST['Company-name'];
    $email = $_POST['E-mail'];
    $phone = $_POST['Phone-number'];
    $password = $_POST['password'];
    $retype_password = $_POST['retype-password'];
    $city = $_POST['City'];
    $post_code = $_POST['Post-Code'];

    // Store form data in session variables
    $_SESSION['Company-name'] = $cname;
    $_SESSION['email'] = $email;
    $_SESSION['Phone-number']= $phone;
    $_SESSION['password'] = $password;
    $_SESSION['retype_password'] = $retype_password;
    $_SESSION['city'] = $city;
    $_SESSION['post_code'] = $post_code;

    // Redirect to another page
    header("Location: http://localhost:3000/Vendor-SignUp%20page-2/index2.php");
    exit();
}
?>

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
    <div>
      <img class="left-section" src="assets/images/ba983ffcee38c5372ec7c56618bb44733880cd57.png">
    </div>
    <div class="right-section">
      <div class="right-top-section">
        <img class="logo" src="assets/images/logo.png">
        <div class="progress-bar">
          <div class="steps">
            <div class="step active"><span>1</span></div>
            <div class="step"><span>2</span></div>
            <div class="step"><span>3</span></div>
          </div>
          <div class="progress-line"></div>
        </div>          
        <h4 class="welcome-message">Basic information</h4>        
      </div>
    </div>
    <div>
      <form id="signupForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div>
          <div>
            <input class="default-stroke" type="text" id="Company-name" name="Company-name" placeholder="Company name" required>
          </div>
            <input class="default-stroke-5" type="email" id="E-mail" name="E-mail" placeholder="E-mail" required>
            <input class="default-stroke-8" type= "Number" id="Phone-number" name="Phone-number" placeholder="Phone-number" required>
          <div class="row">
            <div class="group city">
                <input class="default-stroke-6" type="text" id="City" name="City" placeholder="City" required>
            </div>
            <div class="form-group post-code">
                <input class="default-stroke-7" type="text" id="Post-Code" name="Post-Code" placeholder="Post Code" required>
            </div>
          </div>
        </div>
        <div >
            <input class="default-stroke-2" type="password" id="password" name="password" placeholder="Password" required>
            <span class="password-toggle-1" onclick="togglePassword1('password')"><i class="far fa-eye"></i></span>
        </div>
          <div>
            <input class="default-stroke-3" type="password" id="retype-password" name="retype-password" placeholder="Retype Password" required>
            <span class="password-toggle" onclick="togglePassword('retype-password')"><i class="far fa-eye"></i></span>
          </div>
        </div>
        <button id="continueBtn" class="button" type="submit">CONTINUE</button>
        <div>
          <label class="text-1"><a class="sign-up" href="http://localhost:3000/Vendor%20&%20Specialist%20login%20page%20for%20all/page1.php">Log in!</a>You already have an account?</label>
        </div>
      </form>
    </div>
  <script>
    // Add input-filled class when inputs are not empty
    document.querySelectorAll("input[type='text'], input[type='email'], input[type='Number'], input[type='password']").forEach(function(input) {
      input.addEventListener("input", function() {
        if (this.value.trim() !== "") {
          this.classList.add("input-filled");
        } else {
          this.classList.remove("input-filled");
        }
      });
    });
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

    document.getElementById("continueBtn").addEventListener("click", function(event) {
      event.preventDefault(); // Prevent the default behavior of the button
      
      var cname = document.getElementById("Company-name").value.trim();
      var email = document.getElementById("E-mail").value.trim();
      var phone = document.getElementById("Phone-number").value.trim();
      var password = document.getElementById("password").value.trim();
      var retypePassword = document.getElementById("retype-password").value.trim();
      var city = document.getElementById("City").value.trim();
      var postCode = document.getElementById("Post-Code").value.trim();

      if (cname === "" || email === "" || phone ==="" || password === "" || retypePassword === "" || city === "" || postCode === "") {
        alert("Please fill out all required fields.");
      } else if (password !== retypePassword) {
        alert("Passwords do not match.");
      } else {
        // Proceed to the next page
        document.getElementById("signupForm").submit();
      }
    });
  </script>
</body>
</html>
