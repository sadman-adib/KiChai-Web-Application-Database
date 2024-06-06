<?php
session_start(); // Starting the session

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

$pid = null;

// Check if the session variable containing email exists
if (isset($_SESSION['username']) || isset($_SESSION['email'])) {
    // Prepare and bind SQL statement with a parameterized query to prevent SQL injection
    $sql = "SELECT CONCAT(first_name, ' ',last_name) as first_name, specialist_ID, phone, user_description, city FROM specialist WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if (isset($_SESSION['username'])) {
        $stmt->bind_param("s", $_SESSION['username']);
    }

    if (isset($_SESSION['email'])) {
        $stmt->bind_param("s", $_SESSION['email']);
    } // Bind session email to the query parameter // Bind session email to the query parameter
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user data found
    if ($result->num_rows > 0) {
        // Fetch user data
        $row = $result->fetch_assoc();
        $name = $row["first_name"];
        $phone = $row["phone"];
        $about = $row["user_description"];
        $location = $row["city"];
        $pid = $row["specialist_ID"];

        $_SESSION['specialist_id'] = $pid;
    } else {
        // Handle if user data not found
        $name = "Name not found";
        $phone = "Phone not found";
        $about = "About not found";
        $location = "Location not found";
    }

    // Close statement
    $stmt->close();
} else {
    // Handle if session email variable is not set
    $name = "Name not found";
    $phone = "Phone not found";
    $about = "About not found";
    $location = "Location not found";
}

// Check if button-1 is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['kajchai']) && isset($_SESSION['specialist_id'])) {

    $pid = $_SESSION['specialist_id'];

    // Retrieve data based on condition for button-1
    // Example query: Retrieve data where condition is true
    $sql = "SELECT CONCAT(users.first_name, ' ', users.last_name) AS name, job_id, service_type, call_outs.city AS city, call_outs.post_code AS post_code, call_outs.emergency AS em, call_outs.date_time AS dt, call_outs.description AS des
    FROM call_outs
    JOIN users ON users.user_ID = call_outs.user_id
    WHERE call_outs.specialist_id = ? AND call_outs.accept IS NULL AND call_outs.complete IS NULL";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pid); // Bind vendor_id
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query executed successfully
    if ($result->num_rows > 0) {
        // Fetch the data from the result set
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row; // Store each row of data in an array
        }

        // Store the data array in a session variable
        $_SESSION['button_1_data'] = $data;
    } else {
        // Handle query result if no rows found
        $_SESSION['button_1_data'] = array(); // Empty array if no data found
    }

    // Close statement
    $stmt->close();

    // Redirect to screen one
    header("Location: http://localhost:3000/dashboard%20kaaj%20chai%20sp/index.php");
    exit; // Make sure to exit after redirection to prevent further execution of the current script
}

//print_r($_SESSION['button_1_data']); // Display button-1 data array
$conn->close();
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
                <li><a href="http://localhost:3000/specialist%20Dashboard-1/index.php"><i class="fas fa-home"></i>&nbsp;&nbsp;&nbsp;&nbsp;Home</a></li>
                <li><a href="http://localhost:3000/dashboard%20kaaj%20chai%20-%20hired%20sp/index.php"><i class="fas fa-user-friends"></i> &nbsp;&nbsp;Accepted</a></li>
                <li><a href="http://localhost:3000/dashboard%20kaaj%20chai%20-%20pw%20sp/index.php"><i class="fas fa-map-marker-alt"></i> &nbsp;&nbsp;&nbsp;&nbsp;Previous work</a></li>
                <li><a href="http://localhost:3000/dashboard%20kaaj%20chai%20-%20notification%20sp/index.php"><i class="fas fa-bell"></i> &nbsp;&nbsp;&nbsp;&nbsp;Notifications</a></li>
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
        <div class="custom-container">
            <img class="profile-pic" src="assets\images\see_pic.png">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <button class="button-1" name="kajchai"></button>
            </form>
            <label class="name"><?php echo $name; ?></label> <br>
            <label class="phone-number"><?php echo $phone; ?></label>
            <label class="about"><?php echo $about; ?></label>
            <label class="location"><i class="fas fa-map-marker-alt">&nbsp;&nbsp;<?php echo $location; ?></i></label>

            <div class="calendar-container">
                <div class="calendar">
                    <div class="header">
                        <div class="month">July 2021</div>
                        <div class="btns">
                            <!-- today -->
                            <div class="btn today">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                            <!-- previous month -->
                            <div class="btn prev">
                                <i class="fas fa-chevron-left"></i>
                            </div>
                            <!-- next month -->
                            <div class="btn next">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                    </div>
                    <div class="weekdays">
                        <div class="day">Sun</div>
                        <div class="day">Mon</div>
                        <div class="day">Tue</div>
                        <div class="day">Wed</div>
                        <div class="day">Thu</div>
                        <div class="day">Fri</div>
                        <div class="day">Sat</div>
                    </div>
                    <div class="days">
                        <!-- render days with js -->
                    </div>
                </div>
            </div>

            <div class="credits">
                <a href="https://www.youtube.com/channel/UCiUtBDVaSmMGKxg1HYeK-BQ">
                    Created with <span><i class="fas fa-heart"></i></span> by
                    <span>Open Source Coding</span>
                </a>
            </div>


        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.sidebar-menu li a').click(function() {
                $('.sidebar-menu li a').removeClass('active'); // Remove 'active' class from all navigation items
                $(this).addClass('active'); // Add 'active' class to the clicked navigation item
            });
        });

        /*calendar script */

        const daysContainer = document.querySelector(".days");
        const nextBtn = document.querySelector(".next");
        const prevBtn = document.querySelector(".prev");
        const todayBtn = document.querySelector(".today");
        const month = document.querySelector(".month");

        const months = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December",
        ];

        const days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

        const date = new Date();
        let currentMonth = date.getMonth();
        let currentYear = date.getFullYear();

        const renderCalendar = () => {
            date.setDate(1);
            const firstDay = new Date(currentYear, currentMonth, 1);
            const lastDay = new Date(currentYear, currentMonth + 1, 0);
            const lastDayIndex = lastDay.getDay();
            const lastDayDate = lastDay.getDate();
            const prevLastDay = new Date(currentYear, currentMonth, 0);
            const prevLastDayDate = prevLastDay.getDate();
            const nextDays = 7 - lastDayIndex - 1;

            month.innerHTML = `${months[currentMonth]} ${currentYear}`;

            let days = "";

            for (let x = firstDay.getDay(); x > 0; x--) {
                days += `<div class="day prev">${prevLastDayDate - x + 1}</div>`;
            }

            for (let i = 1; i <= lastDayDate; i++) {
                if (
                    i === new Date().getDate() &&
                    currentMonth === new Date().getMonth() &&
                    currentYear === new Date().getFullYear()
                ) {
                    days += `<div class="day today">${i}</div>`;
                } else {
                    days += `<div class="day">${i}</div>`;
                }
            }

            for (let j = 1; j <= nextDays; j++) {
                days += `<div class="day next">${j}</div>`;
            }

            daysContainer.innerHTML = days;
            hideTodayBtn();
        };

        nextBtn.addEventListener("click", () => {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar();
        });

        prevBtn.addEventListener("click", () => {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar();
        });

        todayBtn.addEventListener("click", () => {
            currentMonth = date.getMonth();
            currentYear = date.getFullYear();
            renderCalendar();
        });

        function hideTodayBtn() {
            if (
                currentMonth === new Date().getMonth() &&
                currentYear === new Date().getFullYear()
            ) {
                todayBtn.style.display = "none";
            } else {
                todayBtn.style.display = "flex";
            }
        }

        renderCalendar();
    </script>

</body>

</html>