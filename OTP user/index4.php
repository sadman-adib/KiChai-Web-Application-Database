<?php
ob_start(); // Start output buffering at the very beginning
session_start(); // Start the session if not already started

$msg = ""; // Initialize $msg variable

// Check if OTP is submitted
if (isset($_POST['otp'])) {
    $otp = $_POST['otp'];

    // Check if OTP is "000000"
    if ($otp === "000000") {
        $_SESSION['otp_verified'] = true;
    } else {
        $_SESSION['otp_verified'] = false;
        $msg = "Invalid OTP. Please try again.";
    }
}

// Check if OTP is successfully verified and form data is submitted
if (isset($_SESSION['otp_verified']) && $_SESSION['otp_verified'] && isset($_POST['submit']) && $_SERVER["REQUEST_METHOD"] == "POST") {


    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $phone = $_SESSION['Phone-number'];
    $retype_password = $_SESSION['retype_password'];
    $city = $_SESSION['city'];
    $post_code = $_SESSION['post_code'];
    $vendorImageData= isset($_SESSION['vendor_image_data']) ? $_SESSION['vendor_image_data'] : '';
    $about = isset($_SESSION['about']) ? $_SESSION['about'] : '';

    $userID = rand(11111,33333); // Generate a random 5-digit ID
    $conn = new mysqli("localhost", "root", "", "kichay");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO users (user_ID, first_name, last_name, phone, email, city, post_code, pass, profile_pic, description) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("isssssisbs", $userID, $first_name, $last_name, $phone, $email, $city, $post_code, $retype_password, $vendorImageData, $about);

    if ($stmt->execute()) {
        // Clean the output buffer and turn off output buffering
        //print_r($_SESSION);
        header("Location: http://localhost:3000/UserDashboard-1/index.php");
        exit();
    } else {
        $msg = "Error inserting data: " . $conn->error;
    }
}
ob_end_flush(); // Flush the output buffer and turn off output buffering at the end of the script if not already done
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
        <h4 class="welcome-message">Please verify your account!</h4>  
        <p class="info">We sent a verification code to email. Enter the code from the email in the field below.</p> 
      </div>
    </div>
    <div>
    <form class="otp-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="otp-form" method="post" enctype="multipart/form-data">

        <p class="info-1">Type your 6 digit security code</p>
        <div class="row">
          <!-- OTP Input 1 -->
          <div class="input-field col s2">
            <input id="otp1" type="text" class="validate center-align otp" name="otp" maxlength="1">
          </div>
          <!-- OTP Input 2 -->
          <div class="input-field col s2">
            <input id="otp2" type="text" class="validate center-align otp" name="otp" maxlength="1">
          </div>
          <!-- OTP Input 3 -->
          <div class="input-field col s2">
            <input id="otp3" type="text" class="validate center-align otp" name="otp" maxlength="1">
          </div>
          <!-- OTP Input 4 -->
          <div class="input-field col s2">
            <input id="otp4" type="text" class="validate center-align otp" name="otp" maxlength="1">
          </div>
          <!-- OTP Input 5 -->
          <div class="input-field col s2">
            <input id="otp5" type="text" class="validate center-align otp" name="otp" maxlength="1">
          </div>
          <!-- OTP Input 6 -->
          <div class="input-field col s2">
            <input id="otp6" type="text" class="validate center-align otp" name="otp" maxlength="1">
          </div>
        </div>
        <div>
          <label class="text-1"><a class="sign-up" href="http://localhost:3000/Vendor%20&%20Specialist%20login%20page%20for%20all/page1.php">Login screen</a>Go back to</label>
        </div>
        <button id="submit-btn" class="button" type="submit">Continue</button>
      </form>
    </div>
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

    var submitBtn = document.getElementById('submit-btn');
    submitBtn.addEventListener('click', function (event) {
        event.preventDefault();  // Prevent the default form submission
        var otpInputs = document.querySelectorAll('.otp');
        var otp = Array.from(otpInputs).map(input => input.value).join('');

        // Create form data
        var formData = new FormData();
        formData.append('otp', otp);
        formData.append('submit', 'true'); // Add a flag to indicate form submission

        // Fetch API to submit form data
        fetch('<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.redirected) {
                window.location.href = response.url; // Redirect if there's a redirection response
            }
            return response.text();
        })
        .then(data => {
            console.log(data); // Log or handle response data if needed
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    document.getElementById('otp-form').addEventListener('input', function(event) {
        let value = event.target.value;
        value = value.replace(/[^0-9]/g, '');
        event.target.value = value;
    });
});
</script>

</body>
</html>
