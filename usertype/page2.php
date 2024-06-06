<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>KI CHAI</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;800&display=swap" />
  <link rel="stylesheet" href="SelectUserType.css" />
</head>

<body>
  <div class="container">
    <img class="image" src="assets/images/30583d383c1cbbd7aab4cec90da3707fa5db05b9.png">
    <div class="form">
      <img class="logo" src="assets/images/bfb1d13591fbc38ff31362a29c0fe844661fc6c1.png">
      <label class="welcome-message">Welcome, SignUp to your account!</label>
      <form id="userTypeForm">
        <label class="vendor" for="vendor">Vendor</label>
        <input class="ellipse" type="radio" name="UserType" value="Vendor" id="vendor">
        <label class="specialist" for="specialist">Specialist</label>
        <input class="ellipse-1" type="radio" name="UserType" value="Specialist" id="specialist">
        <label class="customer" for="customer">Customer</label>
        <input class="ellipse-2" type="radio" name="UserType" value="customer" id="customer">
        <div>
          <input class="button" type="submit" value="CONTINUE">
        </div>
        <div>
          <label class="button-1"><a class="sign-up" href="http://localhost:3000/Vendor%20&%20Specialist%20login%20page%20for%20all/page1.php">Log in!</a> Already have an account? </label>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.getElementById("userTypeForm").addEventListener("submit", function(event) {
      event.preventDefault(); // Prevent default form submission

      // Get the value of the selected radio button
      const selectedUserType = document.querySelector('input[name="UserType"]:checked').value;

      // Redirect based on the selected user type
      switch (selectedUserType) {
        case "Vendor":
          window.location.href = "http://localhost:3000/Vendor-SignUp%20Page-1/index.php"; // Replace "vendor_screen.html" with your actual vendor screen URL
          break;
        case "Specialist":
          window.location.href = "http://localhost:3000/Specialist-SignUp%20Page-1/index.php"; // Replace "specialist_screen.html" with your actual specialist screen URL
          break;
        case "customer":
          window.location.href = "http://localhost:3000/user-SignUp%20Page-1/index.php"; // Replace "customer_screen.html" with your actual customer screen URL
          break;
        default:
          console.error("Invalid user type selected");
      }
    });
  </script>
</body>

</html>