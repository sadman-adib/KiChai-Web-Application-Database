<?php
session_start();

// Database connection parameters
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
$selectedpid = $_SESSION['selected_prof_id'] ?? '';
$selectedjid = $_SESSION['selected_job_id'] ?? '';
$selectedProfName = $_SESSION['selected_prof_name'] ?? '';
$selectedServiceType = $_SESSION['selected_service_type'] ?? '';
$formattedFutureTime = $_SESSION['selected_time'] ?? '';
$location = $_SESSION['city'] ?? '';
$post_code = $_SESSION['post_code'] ?? '';
$jobDetails = $_SESSION['job_details'] ?? '';
$cost = $_SESSION['per_hour_rate'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

  $review = $_POST["about"];
  $rating = $_POST["star-rating"];
  $cost = $_POST["per_hour_rate"];

  // Function to determine whether the selected ID is a specialist or vendor
  function getProfessionalType($conn, $selectedpid)
  {
    $sql = "SELECT COUNT(*) AS count_specialist FROM specialist WHERE specialist_ID = $selectedpid";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $countSpecialist = $row['count_specialist'];

    if ($countSpecialist > 0) {
      return 'specialist';
    } else {
      return 'vendor';
    }
  }

  // Insert data into call_outs table
  $professionalType = getProfessionalType($conn, $selectedpid);

  // Insert data into transaction table
  $sql = "INSERT INTO transaction (user_id, specialist_id, vendor_id, job_id, amount)
        VALUES ('$userID', " . ($professionalType == 'specialist' ? "'$selectedpid', NULL" : "NULL, '$selectedpid'") . ", '$selectedjid', '$cost')";
  mysqli_query($conn, $sql);

  // Insert data into rating table
  $sql = "INSERT INTO rating (user_id, specialist_id, vendor_id, job_id, rating, review_description)
        VALUES ('$userID', " . ($professionalType == 'specialist' ? "'$selectedpid', NULL" : "NULL, '$selectedpid'") . ", '$selectedjid', '$rating', '$review')";
  mysqli_query($conn, $sql);

  $sql = ("UPDATE call_outs SET complete = '1' WHERE job_id = $selectedjid");
  mysqli_query($conn, $sql);

  header("Location: http://localhost:3000/UserDashboard-1/index.php");
  exit();
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
  <style>
    /* Hide default radio buttons */
    input[type="radio"] {
      display: none;
    }

    /* Style for stars */
    label.star {
      font-size: 30px;
      cursor: pointer;
      color: #ccc;
    }

    /* Style for filled stars */
    input[type="radio"]:checked~label.star,
    input[type="radio"]:checked~label.star~label.star {
      color: gold;
    }

    /* Ensure that all labels to the left of the selected star are filled */
    input[type="radio"]:checked+label.star {
      color: gold;
    }
  </style>
</head>

<body>
  <div id="myModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <img class="profile-pic" src="assets\images\see_pic.png" alt="Profile Picture">
      <div class="review-content">
        <h2 class="reviewer-name"><?php echo $selectedProfName ?></h2>
        <p class="date-of-work"><span class="postal-code-icon"></span> &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<?php echo $post_code ?></p>
        <h3 class="reviewer-title"><?php echo $selectedServiceType ?></h3>
        <p class="location-of-work"><span class="location-icon"></span> &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; <?php echo $location ?></p>
        <p class="time-of-work"><span class="time-icon"></span> &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<?php echo $formattedFutureTime ?></p>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <input class="Per-hour-rate" id="Per-hour-rate" type="number" name="per_hour_rate" value="" placeholder="Cost">
          <h3 class="review-text-1"><span class="review-icon"></span>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;Review</h3>
          <textarea class="taxt-area" name="about" id="Job-details" rows="10" cols="50" placeholder="Write a review......"></textarea>
      </div>
      <div class="review-rating">
        <input type="hidden" id="rating" name="star-rating" value="0">
        <span class="rating-stars" id="ratingStars">
          <input type="radio" id="star5" name="star-rating" value="5">
          <label class="star" for="star5">&#9733;</label>
          <input type="radio" id="star4" name="star-rating" value="4">
          <label class="star" for="star4">&#9733;</label>
          <input type="radio" id="star3" name="star-rating" value="3">
          <label class="star" for="star3">&#9733;</label>
          <input type="radio" id="star2" name="star-rating" value="2">
          <label class="star" for="star2">&#9733;</label>
          <input type="radio" id="star1" name="star-rating" value="1">
          <label class="star" for="star1">&#9733;</label>
        </span>
        <span class="rating-label">Ratings</span>
      </div>
      <button type="submit" name="submit" class="see-more-btn" onclick="showAlert()">Complete</button>
      </form>
    </div>
  </div>

  <script>
    function showAlert() {
      alert("Job completed successfully!");
    }
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal
    btn.onclick = function() {
      modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }

    document.addEventListener("DOMContentLoaded", function() {
      const stars = document.querySelectorAll('.star');
      const ratingInput = document.getElementById('rating');

      stars.forEach(star => {
        star.addEventListener('click', () => {
          const rating = parseInt(star.getAttribute('for').substring(4));
          ratingInput.value = rating;
          stars.forEach(s => {
            const sRating = parseInt(s.getAttribute('for').substring(4));
            if (sRating <= rating) {
              s.textContent = '★';
            } else {
              s.textContent = '☆';
            }
          });
        });
      });


      const continueBtn = document.querySelector('.see-more-btn');
      continueBtn.addEventListener('click', () => {
        const review = document.getElementById('Job-details').value;
        const rating = parseInt(ratingInput.value);

        // Store review and rating in session variables
        sessionStorage.setItem('review', review);
        sessionStorage.setItem('rating', rating);

        // Redirect to the next screen or perform any other action
        window.location.href = "next_screen.php";
      });
    });
  </script>

</body>

</html>