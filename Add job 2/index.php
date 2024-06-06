<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kichay";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$userID = $_SESSION['user_ID'] ?? '';
$selectedem = $_SESSION['selected_em'] ?? '';
$selectedId = $_SESSION['selected_prof_id'] ?? '';
$selectedProfName = $_SESSION['selected_prof_name'] ?? '';
$selectedServiceType = $_SESSION['selected_service_type'] ?? '';
$formattedFutureTime = $_SESSION['selectedDateTime'] ?? '';
$location = $_SESSION['city'] ?? '';
$post_code = $_SESSION['post_code'] ?? '';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["continue"])) {
  if (isset($_POST['job_details'], $_POST['per_hour_rate'])) {
    // Capture the job details from the textarea
    $jobDetails = $_POST['job_details'];

    // Capture the per-hour rate from the input field
    $cost = $_POST['per_hour_rate'];

    // Store the job details and per-hour rate in session variables

    // Database connection parameters

    // Function to determine whether the selected ID is a specialist or vendor
    function getProfessionalType($conn, $selectedId)
    {
      $sql = "SELECT COUNT(*) AS count_specialist FROM specialist WHERE specialist_ID = $selectedId";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_assoc($result);
      $countSpecialist = $row['count_specialist'];

      if ($countSpecialist > 0) {
        return 'specialist';
      } else {
        return 'vendor';
      }
    }

    $jobID = rand(1000, 9999);

    // Insert data into call_outs table
    $professionalType = getProfessionalType($conn, $selectedId);

    $sql = "INSERT INTO call_outs (user_id, specialist_id, vendor_id, job_id, service_type, city, post_code, emergency, date_time, description)
        VALUES ('$userID', " . ($professionalType == 'specialist' ? "'$selectedId', NULL" : "NULL, '$selectedId'") . ", '$jobID', '$selectedServiceType', '$location', '$post_code', '$selectedem', '$formattedFutureTime', '$jobDetails')";
    mysqli_query($conn, $sql);

    // Retrieve the job ID of the inserted record

    // Insert data into notification table
    $sql = "INSERT INTO notification (user_id, specialist_id, vendor_id, job_id, date_time, notification_description, service_type, emergency)
        VALUES ('$userID', " . ($professionalType == 'specialist' ? "'$selectedId', NULL" : "NULL, '$selectedId'") . ", '$jobID', '$formattedFutureTime', '$jobDetails', '$selectedServiceType', '$selectedem')";
    mysqli_query($conn, $sql);

    $_SESSION['jobID'] = $jobID;

    header("Location: http://localhost:3000/UserDashboard-1/index.php");
    exit();
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>KI CHAI</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700&display=swap" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400&display=swap" />
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
  <!-- Add job -->
  <div id="myModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <img class="profile-pic" src="assets\images\see_pic.png" alt="Profile Picture">
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="Add-Job-content">
          <lable class="User-name" id="User-name" value="" name="">
            <h2><?php echo $selectedProfName;
                echo '-';
                echo $selectedId;  ?></h2>
          </lable>
          <h4 class="Job-Type">
            <lable style="color: #2A6B53;">Looking for professional: <?php echo $selectedem; ?></lable>
          </h4>
          <p class="text">Last Step To Hire</p>
          <label id="Service-Type" class="selected-box"><?php echo $selectedServiceType; ?></label>
          <label id="Area" class="selected-box"><?php echo $location; ?></label>
          <Label id="post-code" class="selected-box"><?php echo $post_code; ?></Label>
          <label id="Date" type="date" class="Selected-box"><?php echo date('Y-m-d'); ?></label>
          <label id="Select-time" class="selected-box"><?php echo $formattedFutureTime; ?></label>
          <input class="Per-hour-rate" id="Per-hour-rate" type="number" name="per_hour_rate" value="" placeholder="Cost">
          <textarea class="taxt-area" name="job_details" id="Job-details" rows="10" cols="50" placeholder="Write details about your job......"></textarea>

          <button class="see-more-btn" type="submit" name="continue" onclick="showAlert()">Continue</button>
      </form>
    </div>
  </div>
  </div>

  <script>
    function showAlert() {
      alert("Callout and notification created successfully!");
    }
  </script>


</body>

</html>