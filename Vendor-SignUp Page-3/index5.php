<?php
session_start(); // Start the session to store form data temporarily

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve interests from POST data or set it as an empty array if not provided
    $interests = isset($_POST['interests']) ? $_POST['interests'] : array();

    // Retrieve emergency service provider from POST data or set it as 'No' if not provided
    $emergencyService = isset($_POST['Emergency-service-provider']) ? $_POST['Emergency-service-provider'] : 'No';

    // Store form data in $_SESSION variables
    $_SESSION['interests'] = $interests;
    $_SESSION['emergencyService'] = $emergencyService;

    header("location: http://localhost:3000/OTP%20vendor/index44.php");
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
            <div class="step active"><span>3</span></div>
          </div>
          <div class="progress-line"></div>
        </div>          
        <h4 class="welcome-message">Interests</h4>        
      </div>
    </div>
    <div>
    <form id="interestsForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">

        <div class="scrollable-checklist">
          <label>
            <input name="interests[]" value="Plumber" id="Plumber" type="checkbox" >
            <span>Plumber</span>
          </label>
          <label>
            <input name="interests[]" value="Technician" id="Technician" type="checkbox" >
            <span>Technician</span>
          </label>
          <label>
            <input name="interests[]" value="Electrician" id="Electrician" type="checkbox">
            <span>Electrician</span>
          </label>
          <label>
            <input name="interests[]" value="Mechanic" id="Mechanic" type="checkbox">
            <span>Mechanic</span>
          </label>
          <label>
            <input name="interests[]" value="Furniture-Assembly" id="Furniture-Assembly" type="checkbox" >
            <span>Furniture Assembly</span>
          </label>
          <label>
            <input name="interests[]" value="Moving-Help" id="Moving-Help"  type="checkbox" >
            <span>Moving Help</span>
          </label>
          <label>
            <input name="interests[]" value="AC-repair" id="AC-repair" type="checkbox" >
            <span>AC repair</span>
          </label>
          <label>
            <input name="interests[]" value="Curpainter" id="Curpainter" type="checkbox" >
            <span>Curpainter</span>
          </label>
          <label>
            <input name="interests[]" value="Mounting-job" id="Mounting-job" type="checkbox">
            <span>Mounting job</span>
          </label>
        </div>
        <label class="Emergency-service-provider" for="Emergency-service-provider">
          <div class="tooltip">
            <i class="fas fa-info-circle"></i>
            <span class="tooltiptext">if you are available to work emergency then enable this option.</span>
          </div>
          <input class="ellipse" type="radio" name="Emergency-service-provider" value="Emergency-service-provider" id="Emergency-service-provider">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Can you Provide Emergency Service
        </label>
        <button type="submit" name="submit" class="button">CONTINUE</button>
        <div>
          <label class="text-1"><a class="sign-up" href="http://localhost:3000/Vendor%20&%20Specialist%20login%20page%20for%20all/page1.php">Log in!</a>You already have an account?</label>
        </div>
      </form>
    </div>
    <?php if(isset($msg)): ?>
    <div><?php echo $msg; ?></div>
    <?php endif; ?>
  </div>
  <script>
    document.getElementById("interestsForm").addEventListener("submit", function(event) {
      var checkboxes = document.querySelectorAll('input[name="interests[]"]');
      var isChecked = false;
      
      checkboxes.forEach(function(checkbox) {
        if (checkbox.checked) {
          isChecked = true;
        }
      });
      
      if (!isChecked) {
        alert("Please select at least one interest.");
        event.preventDefault();
      }
    });
  </script>
</body>
</html>