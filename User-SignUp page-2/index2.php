<?php
session_start(); // Start the session to store form data temporarily

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if file was uploaded successfully
    if (isset($_FILES["Vendor-image"]) && $_FILES["Vendor-image"]["error"] == UPLOAD_ERR_OK) {
      $file_tmp = $_FILES['Vendor-image']['tmp_name'];
      $file_type = $_FILES['Vendor-image']['type'];
      
      // Read image data
      $vendorImageData = file_get_contents($file_tmp);
    } 
    
    else {
        // Handle file upload error
        echo "Error uploading file.";
        exit();
    }

    // Retrieve other form data
    $about = isset($_POST["about"]) ? $_POST["about"] : '';

    // Store file data and other form data in session variables
    $_SESSION['vendor_image_data'] = $vendorImageData;
    $_SESSION['about'] = $about;

    // Redirect to the next page
    header("Location: http://localhost:3000/OTP%20user/index4.php");
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
            <div class="step active"><span>2</span></div>
          </div>
          <div class="progress-line"></div>
        </div>          
        <h4 class="welcome-message">Additional information</h4>        
      </div>
    </div>
    <div>
      <form id="signupForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <div>
          <div>
            <label for="Vendor-image" class="label-1">Upload your picture</label>
            <input class="default-stroke" type="file" name="Vendor-image" id="vendor-image" accept="image/*" >
            <textarea class="default-stroke-4" name="about" id="about" rows="1" cols="20" placeholder="Tell us something about the you ..."></textarea>
        </div>
        <button type="submit" class="button">CONTINUE</button>
        <div>
          <label class="text-1"><a class="login" href="http://localhost:3000/Vendor%20&%20Specialist%20login%20page%20for%20all/page1.php">Log in!</a>You already have an account?</label>
        </div>
      </form>
    </div>
    <script>
      // Add event listeners for input fields
      const inputFields = document.querySelectorAll('input[type="text"], input[type="number"], textarea');
      
      inputFields.forEach(inputField => {
        inputField.addEventListener('input', () => {
          // Check if input field has value
          if (inputField.value.trim() !== '') {
            inputField.classList.add('input-filled'); 
          } else {
            inputField.classList.remove('input-filled'); 
          }
        });
      })
      
      // Add event listener for form submission
      document.getElementById("signupForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent the default form submission
        
        // Check if all required fields are filled
        var picture = document.getElementById("vendor-image").value.trim();
        var about = document.getElementById("about").value.trim();

        if (picture === "" || about === "" ) {
          alert("Please fill out all required fields.");
        } else {
          // Proceed to the next screen
          this.submit(); // Submit the form
        }
      });
    </script>
</body>
</html>
