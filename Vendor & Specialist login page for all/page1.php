<?php
session_start();
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "kichay";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {

    // Retrieve username and password from form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Query to check if user exists
    $sql = "(SELECT email AS username, pass FROM users WHERE email = '$username' AND pass = '$password')
    UNION ALL 
    (SELECT email AS username, pass FROM vendor WHERE email = '$username' AND pass = '$password')
    UNION ALL 
    (SELECT email AS username, pass FROM specialist WHERE email = '$username' AND pass = '$password')";

    $result = $conn->query($sql);
      
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['username']; // Assuming the column name for the username is 'username'
        
        // Check if the username exists in each table individually
        $userQuery = "SELECT * FROM users WHERE email = '$username'";
        $vendorQuery = "SELECT * FROM vendor WHERE email = '$username'";
        $specialistQuery = "SELECT * FROM specialist WHERE email = '$username'";
        
        $userResult = $conn->query($userQuery);
        $vendorResult = $conn->query($vendorQuery);
        $specialistResult = $conn->query($specialistQuery);
        
        if ($userResult->num_rows > 0) {
            // Username found in 'usertable'
            $_SESSION['username'] = $username;
            echo "<script>alert('Login successful!')</script>";
            header("location: http://localhost:3000/UserDashboard-1/index.php");
            exit();
        } elseif ($vendorResult->num_rows > 0) {
            // Username found in 'vendortable'
            $_SESSION['username'] = $username;
            echo "<script>alert('Login successful!')</script>";
            header("location: http://localhost:3000/vendorDashboard-1/index.php");
            exit();
        } elseif ($specialistResult->num_rows > 0) {
            // Username found in 'specialisttable'
            $_SESSION['username'] = $username;
            echo "<script>alert('Login successful!')</script>";
            header("location: http://localhost:3000/specialist%20Dashboard-1/index.php");
            exit();
        } else {
            // Username not found in any table
            echo "<script>alert('Invalid username or password. Please try again.')</script>";
        }
    } else {
        // Invalid login
        echo "<script>alert('Invalid username or password. Please try again.')</script>";
    }
  }

//print_r($_SESSION);
// Close connection
$conn->close();
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
      <Div>
        <img class="left-section" src="assets/images/ba983ffcee38c5372ec7c56618bb44733880cd57.png">
      </Div>
      <div class="right-section">
        <div class="right-top-section">
          <img class="logo" src="assets/images/logo.png">
          <h4 class="welcome-message">Welcome, login to your account!</h4>        
        </div>
      </div>
        <div>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
              <div>
                <input class="default-stroke" type="text" id="username" name="username" placeholder="Username">
              </div>
              <div >
                <input class="default-stroke-2" type="password" id="password" name="password" placeholder="Password">
                <span class="password-toggle" onclick="togglePassword()"><i class="far fa-eye"></i></span>
              </div>
              <div class="check-box">
                <label ><input type="checkbox" name="remind-me"> Remind me </label>
              </div>
              <button class="button" type="submit" name="login">Login Now</button>
              <div>
                <label class="text-1"><a class="sign-up" href="http://localhost:3000/usertype/page2.php">Sign up!</a>Don’t have an account yet?</label>
              </div>
          </form>
        </div>
     <script>
      function togglePassword() {
        var passwordField = document.getElementById("password");
        if (passwordField.type === "password") {
          passwordField.type = "text";
          document.querySelector(".password-toggle i").classList.remove("far", "fa-eye");
          document.querySelector(".password-toggle i").classList.add("fas", "fa-eye-slash");
        } else {
          passwordField.type = "password";
          document.querySelector(".password-toggle i").classList.remove("fas", "fa-eye-slash");
          document.querySelector(".password-toggle i").classList.add("far", "fa-eye");
        }
      }
      document.getElementById("username").addEventListener("input", function() {
      if (this.value.trim() !== "") {
          this.classList.add("input-filled");
        } else {
          this.classList.remove("input-filled");
        }
      });
      document.getElementById("password").addEventListener("input", function() {
      if (this.value.trim() !== "") {
          this.classList.add("input-filled");
        } else {
          this.classList.remove("input-filled");
        }
      });
      </script>
  </body>
</html>

