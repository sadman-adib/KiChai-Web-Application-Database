<?php
session_start();

// Check if the session variables are set
if (isset($_SESSION['button_1_data'])) {
    // Retrieve the review data from session
    $button1Data = $_SESSION['button_1_data'];
} else {
    exit("No review data available");
}

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

// Check if the "continue" button is clicked
if (isset($_POST['continue'])) {
    // Get the job ID from the form
    $jobId = $_POST['selected_job_id'];

    // Prepare and execute the SQL UPDATE query
    $stmt = $conn->prepare("UPDATE call_outs SET accept = '1' WHERE job_id = ?");
    $stmt->bind_param("i", $jobId);
    $stmt->execute();
    $stmt->close();

    // Redirect to the specified page after the update
    header("Location: http://localhost:3000/vendorDashboard-1/index.php");
    exit();
}

// Close the database connection
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
    <style>
        .scrollable-table-container {
            height: 100%;
            max-height: 670px;
            /* Adjust the height as needed */
            overflow: auto;
        }

        /*new CSS */

        .card {
            background: #FFFBF7;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            margin-bottom: 1em;
            display: flex;
            flex-direction: column;
            padding: 20px;
            font-family: 'Arial', sans-serif;
            /* Adjust the font family as needed */
        }

        .card-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .card-header img {
            border-radius: 50%;
            margin-right: 15px;
        }

        .card-header .username {
            font-size: 1.2em;
            font-weight: bold;
            color: #333;
        }

        .card-header .service-type {
            background-color: #E8F0FE;
            color: #1967D2;
            padding: 5px 10px;
            border-radius: 16px;
            font-size: 0.9em;
            margin-left: auto;
            /* Align to the right */
            white-space: nowrap;
        }

        .card-info {
            display: flex;
            align-items: center;
            font-size: 0.8em;
            color: #555;
            margin-bottom: 20px;
        }

        .card-info div {
            display: flex;
            align-items: center;
            margin-right: 15px;
        }

        .card-info div img {
            margin-right: 5px;
        }

        .card-info div.time {
            margin-left: auto;
        }

        .card-body {
            margin-bottom: 20px;
        }

        .card-body .title {
            color: #333;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .card-body .user-description {
            color: #666;
            font-size: 0.9em;
        }

        .card .see-more {
            background-color: #FFA000;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 20px;
            font-size: 0.9em;
            cursor: pointer;
            align-self: flex-start;
            /* Align button to the left */
        }

        .card .see-more:hover {
            background-color: #DB9200;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card {
                flex-direction: column;
                padding: 15px;
            }

            .card-header .service-type {
                margin-left: 10px;
                /* Adjust for mobile */
            }

            .card-info {
                flex-direction: column;
                align-items: flex-start;
            }

            .card-info div {
                margin-bottom: 10px;
                margin-right: 0;
            }

            .card-info div.time {
                margin-left: 0;
                order: -1;
                /* Time appears first on mobile */
            }

            .card .see-more {
                width: 100%;
                margin-top: 15px;
            }

            .card-rating {
                display: flex;
                align-items: center;
                color: #FFD700;
                /* Star rating color */
                font-size: 1em;
                /* Adjust size as needed */
            }

            .card-rating i {
                /* If using FontAwesome, for example */
                margin-right: 5px;
                /* Space between stars */
            }

            .card-rating i.filled {
                /* Class for filled star */
                content: "\f005";
                /* FontAwesome filled star */
            }

            .card-rating i.half-filled {
                /* Class for half-filled star */
                content: "\f089";
                /* FontAwesome half-filled star */
            }

            .card-rating i.unfilled {
                /* Class for unfilled star */
                content: "\f006";
                /* FontAwesome unfilled star */
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <img class="logo" src="assets/images/c5abd606624e92030a4e5501e1f9c44de4a0fecd.png">
        <nav class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="http://localhost:3000/vendorDashboard-1/index.php"><i class="fas fa-home"></i>&nbsp;&nbsp;&nbsp;&nbsp;Home</a></li>
                <li><a href="http://localhost:3000/dashboard%20kaaj%20chai%20-%20hired/index.php"><i class="fas fa-user-friends"></i> &nbsp;&nbsp;Accepted</a></li>
                <li><a href="http://localhost:3000/dashboard%20kaaj%20chai%20-%20pw/index.php"><i class="fas fa-map-marker-alt"></i> &nbsp;&nbsp;&nbsp;&nbsp;Previous work</a></li>
                <li><a href="http://localhost:3000/dashboard%20kaaj%20chai%20-%20notification/index.php"><i class="fas fa-bell"></i> &nbsp;&nbsp;&nbsp;&nbsp;Notifications</a></li>
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
            <div class="scrollable-table-container">
                <?php foreach ($button1Data as $row) : ?>
                    <div class="card">
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                            <div class="card-header">
                                <h2><?php echo '<h4> Name : </h4>' . $row['name']; ?></h2>
                                <span class="service-type"><?php echo '<h4> Service : </h4> ' . $row['service_type']; ?></span>
                                <span class="em" name="em"><?php echo '<h4> Emergency : </h4> ' . $row['em']; ?></span>

                                <div class="card-rating">

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="jid"> <?php echo '<h4> Job ID : </h4>' . $row['job_id']; ?></div>
                                <div class="date"> <?php echo '<h4> Date & Time : </h4>' . $row['dt']; ?></div>
                                <div class="city"><?php echo '<h4> City : </h4>' . $row['city']; ?></div>
                                <div class="post-code"><?php echo '<h4> Post Code : </h4>' . $row['post_code']; ?></div>
                                <p class="user-description"><?php echo '<h4> Description : </h4>' . $row['des']; ?></p>
                            </div>
                            <div class="card-footer">

                                <input type="hidden" name="selected_job_id" value="<?php echo $row['job_id']; ?>">
                                <!-- Continue button -->
                                <button class="see-more" type="submit" name="continue" onclick="showAlert()">Accept</button>
                            </div>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div>
            <p class="text"></p>
            <div class="button-container-2">
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function showAlert() {
            alert("Job Accepted Successfully !");
        }
        // Function to populate the hour and minute selectors
        function populateTimeSelectors() {
            const hourSelector = document.getElementById('hourSelector');
            const minuteSelector = document.getElementById('minuteSelector');
            for (let i = 1; i <= 12; i++) {
                const hourOption = document.createElement('option');
                hourOption.value = hourOption.textContent = String(i).padStart(2, '0');
                hourSelector.appendChild(hourOption);
            }
            for (let i = 0; i < 60; i++) {
                const minuteOption = document.createElement('option');
                minuteOption.value = minuteOption.textContent = String(i).padStart(2, '0');
                minuteSelector.appendChild(minuteOption);
            }
        }

        // Function to set the time display
        function setTime() {
            const selectedHour = document.getElementById('hourSelector').value;
            const selectedMinute = document.getElementById('minuteSelector').value;
            const selectedAmPm = document.getElementById('ampmSelector').value;
            document.getElementById('timeDisplay').textContent = `${selectedHour}:${selectedMinute} ${selectedAmPm}`;
        }

        // Initialize selectors
        populateTimeSelectors();

        // Function to change dropdown color
        function changeDropdownColor(select) {
            select.style.backgroundColor = '#fff';
            select.style.color = '#494949';
            select.style.border = '2px solid #ffb700'; // Changed border to 2px solid with color #ffb700
        }

        // Date picker functions
        const calendarContainer = document.getElementById('calendarContainer');
        const dateDisplay = document.getElementById('dateDisplay');
        const calendarHeader = document.getElementById('calendarHeader');
        const calendarGrid = document.getElementById('calendarGrid');

        function toggleCalendar() {
            calendarContainer.classList.toggle('active');
        }

        function selectDate(day) {
            const selectedDate = new Date(2024, 4, day); // May 2024
            dateDisplay.textContent = selectedDate.toDateString();
            toggleCalendar();
            updateCalendar();
        }

        function updateCalendar() {
            calendarGrid.innerHTML = '';
            const daysInMonth = new Date(2024, 4, 31).getDate(); // May has 31 days

            for (let day = 1; day <= daysInMonth; day++) {
                const dayDiv = document.createElement('div');
                dayDiv.classList.add('calendar-day');
                if (new Date(2024, 4, day).toDateString() === dateDisplay.textContent) {
                    dayDiv.classList.add('selected');
                }
                dayDiv.textContent = day;
                dayDiv.onclick = () => selectDate(day);
                calendarGrid.appendChild(dayDiv);
            }
        }

        window.onclick = function(event) {
            if (!event.target.matches('.date-picker-display')) {
                if (calendarContainer.classList.contains('active')) {
                    calendarContainer.classList.remove('active');
                }
            }
        }

        updateCalendar();
    </script>
</body>

</html>