<?php
session_start();

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
if (isset($_SESSION['user_ID'])) {
    $userID = $_SESSION['user_ID'];
}

// Check if button-1 is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['button-1'])) {
    // Retrieve data based on condition for button-1
    // Example query: Retrieve data where condition is true
    $sql = "(SELECT 
    CONCAT(first_name, ' ',last_name) AS pname,
    specialist.specialist_ID as pid,
    per_hour_rate,
    city,
    service_type,
    emergency as em,
    user_description,
    ROUND(AVG(rating.rating)) AS avg_rating,
    COUNT(rating.rating) AS rating_count
FROM 
    specialist
JOIN 
    services ON specialist.specialist_ID = services.specialist_id
LEFT JOIN
    rating  ON specialist.specialist_ID = rating.specialist_ID
WHERE 
    emergency = 'Emergency-service-provider'
GROUP BY
    specialist.specialist_ID
)

UNION ALL

(SELECT 
    company_name AS pname,
    vendor.vendor_ID as pid,
    per_hour_rate,
    city,
    service_type,
    emergency as em,
    user_description,
    ROUND(AVG(rating.rating)) AS avg_rating,
    COUNT(rating.rating) AS rating_count
FROM 
    vendor
JOIN 
    services ON vendor.vendor_ID = services.vendor_id 
    LEFT JOIN
    rating  ON vendor.vendor_ID = rating.vendor_id
WHERE 
    emergency = 'Emergency-service-provider'
GROUP BY
    vendor.vendor_ID
)

ORDER BY
    avg_rating DESC; ";

    $result = $conn->query($sql);

    // Check if the query executed successfully
    if ($result) {
        // Fetch the data from the result set
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row; // Store each row of data in an array
            //print_r($data);
        }

        // Store the data array in a session variable
        $_SESSION['button_1_data'] = $data;
    } else {
        // Handle query error
        $_SESSION['button_1_data'] = array(); // Empty array if there's an error
    }

    // Redirect to screen one
    header("Location: http://localhost:3000/UserDashboard-3%20for%20ekhn%20chai/index.php");
    exit; // Make sure to exit after redirection to prevent further execution of the current script
}

// Check if button-2 is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['button-2'])) {
    $sql2 = "(SELECT 
    first_name AS pname,
    specialist.specialist_ID as pid,
    per_hour_rate,
    city,
    service_type,
    emergency as em,
    user_description,
    ROUND(AVG(rating.rating)) AS avg_rating,
    COUNT(rating.rating) AS rating_count
FROM 
    specialist
JOIN 
    services ON specialist.specialist_ID = services.specialist_id
LEFT JOIN
    rating  ON specialist.specialist_ID = rating.specialist_ID
GROUP BY
    specialist.specialist_ID
)

UNION ALL

(SELECT 
    company_name AS pname,
    vendor.vendor_ID as pid,
    per_hour_rate,
    city,
    service_type,
    emergency as em,
    user_description,
    ROUND(AVG(rating.rating)) AS avg_rating,
    COUNT(rating.rating) AS rating_count
FROM 
    vendor
JOIN 
    services ON vendor.vendor_ID = services.vendor_id 
    LEFT JOIN
    rating  ON vendor.vendor_ID = rating.vendor_id
GROUP BY
    vendor.vendor_ID
)
ORDER BY
    avg_rating DESC; ";

    $result2 = $conn->query($sql2);

    // Check if the query executed successfully
    if ($result2) {
        // Fetch the data from the result set
        $data = array();
        while ($row = $result2->fetch_assoc()) {
            $data[] = $row; // Store each row of data in an array
            //print_r($data);
        }

        // Store the data array in a session variable
        $_SESSION['button_2_data'] = $data;
    } else {
        // Handle query error
        $_SESSION['button_2_data'] = array(); // Empty array if there's an error
    }
    // Redirect to screen two
    header("Location: http://localhost:3000/UserDashboard-3%20pre%20chai/index.php");
    exit; // Make sure to exit after redirection to prevent further execution of the current script
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
    <div class="container">
        <img class="logo" src="assets/images/c5abd606624e92030a4e5501e1f9c44de4a0fecd.png">
        <nav class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="http://localhost:3000/UserDashboard-1/index.php"><i class="fas fa-home"></i>&nbsp;&nbsp;&nbsp;&nbsp;Home</a></li>
                <li><a href="http://localhost:3000/UserDashboard-3%20for%20previous%20work/index.php"><i class="fas fa-map-marker-alt"></i> &nbsp;&nbsp;&nbsp;&nbsp;Previous work</a></li>
                <li><a href="http://localhost:3000/UserDashboard-3%20for%20notification/index.php"><i class="fas fa-bell"></i> &nbsp;&nbsp;&nbsp;&nbsp;Notifications</a></li>
                <li><a href="http://localhost:3000/UserDashboard-3%20for%20rating/index.php"><i class="review-icon fas fa-star"></i> &nbsp;&nbsp;&nbsp;Complete & Rating</a></li>
            </ul>
            <div class="button-container">
                <button class="button">
                    <a href="http://localhost:3000/Vendor%20&%20Specialist%20login%20page%20for%20all/page1.php" class="button">
                        <i class="fas fa-sign-out-alt"></i>&nbsp;Logout
                    </a>
                </button>
            </div>
        </nav>
        <div class="main-content">
            <h1 class="welcome-text">Welcome,<label class="user-name" value="'"></label></h1>
            <span class="dashboard">Dashboard</span>
        </div>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="custom-container">
                <button class="button-1" name="button-1"></button>
                <button class="button-2" name="button-2"></button>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.sidebar-menu li a').click(function() {
                $('.sidebar-menu li a').removeClass('active'); // Remove 'active' class from all navigation items
                $(this).addClass('active'); // Add 'active' class to the clicked navigation item
            });
        });
    </script>

</body>

</html>