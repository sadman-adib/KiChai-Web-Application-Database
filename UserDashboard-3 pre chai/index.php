<?php
session_start();

// Check if the session variables are set
if (isset($_SESSION['button_2_data'])) {
    // Retrieve the review data from session
    $button2Data = $_SESSION['button_2_data'];
} else {
    // Handle the case when session data is not set
    echo "No review data available";
    exit; // Exit the script
}

if (isset($_SESSION['city'])) {
    $location = $_SESSION['city'];
}

if (isset($_SESSION['post_code'])) {
    $post_code = $_SESSION['post_code'];
}

// Handling form submission for setting time and searching
if (isset($_POST['search']) && isset($_POST['service-type']) && isset($_POST['selected_date']) && isset($_POST['selected_time'])) {
    // Get the selected service type
    $selectedServiceType = $_POST['service-type'];

    // Filter the data based on the selected service type
    $filteredData = array_filter($button2Data, function ($row) use ($selectedServiceType) {
        return $row['service_type'] === $selectedServiceType;
    });

    // Reassign the filtered data
    $button2Data = $filteredData;

    $selectedDate = $_POST['selected_date'];
    $selectedTime = $_POST['selected_time'];

    // Combine the date and time into a single string representing the dateTime
    $formattedFutureTime = date('Y-m-d H:i:s', strtotime("$selectedDate $selectedTime"));

    // Store the dateTime in a session variable
    $_SESSION['selectedDateTime'] = $formattedFutureTime;
}



if (isset($_POST['continue'])) {
    // Code to handle continue button click
    if (isset($_POST['selected_prof_name'], $_POST['selected_service_type'], $_POST['selected_city'], $_POST['selected_prof_id'], $_POST['selected_em'])) {
        // Retrieve form data
        $selectedProfName = $_POST['selected_prof_name'];
        $selectedServiceType = $_POST['selected_service_type'];
        $selectedCity = $_POST['selected_city'];
        $selectedId = $_POST['selected_prof_id'];
        $selectedem = $_POST['selected_em'];

        // Store data into session variables
        $_SESSION['selected_prof_name'] = $selectedProfName;
        $_SESSION['selected_service_type'] = $selectedServiceType;
        $_SESSION['selected_city'] = $selectedCity;
        $_SESSION['selected_prof_id'] =  $selectedId;
        $_SESSION['selected_em'] = $selectedem;

        // print_r($_SESSION);
        // Redirect to another page
        header("Location: http://localhost:3000/Add%20job%202/index.php");
        exit();
    } else {
        // Handle the case when not all required form fields are set
        // You can display an error message or perform other actions
        exit;
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
                <li><a href="http://localhost:3000/UserDashboard-1/index.php"><i class="fas fa-home"></i>&nbsp;&nbsp;&nbsp;&nbsp;Home</a></li>
                <li><a href="http://localhost:3000/UserDashboard-3%20for%20previous%20work/index.php"><i class="fas fa-map-marker-alt"></i> &nbsp;&nbsp;&nbsp;&nbsp;Previous work</a></li>
                <li><a href="http://localhost:3000/UserDashboard-3%20for%20notification/index.php"><i class="fas fa-bell"></i> &nbsp;&nbsp;&nbsp;&nbsp;Notifications</a></li>
                <li><a href="http://localhost:3000/UserDashboard-3%20for%20rating/index.php"><i class="fas fa-star"></i> &nbsp;&nbsp;&nbsp;Complete & Rating</a></li>
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
                <?php foreach ($button2Data as $row) : ?>
                    <div class="card">
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                            <div class="card-header">
                                <h2><?php echo '<h4> Name : </h4>' . $row['pname'];;
                                    echo '-';
                                    echo $row['pid']; ?></h2>
                                <span class="service-type"><?php echo '<h4> Service : </h4> ' . $row['service_type']; ?></span>
                                <span class="count" name="count"><?php echo '<h4> Completed : </h4> ' . $row['rating_count']; ?></span>
                                <div class="card-rating">
                                    <?php
                                    $rating = $row['avg_rating'];
                                    // Display star ratings based on the rating value
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($rating >= $i) {
                                            echo '<i class="fas fa-star filled"></i>'; // Filled star icon
                                        } else {
                                            echo '<i class="far fa-star unfilled"></i>'; // Unfilled star icon
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="rate"> <?php echo '<h4> Per Hour Rate : </h4><i class="fas taka-icon">&#2547;</i>' . $row['per_hour_rate']; ?> /hr</div>
                                <div class="city"><?php echo '<h4> City : </h4>' . $row['city']; ?></div>
                                <p class="user-description"><?php echo '<h4> Description : </h4>' . $row['user_description']; ?></p>
                                <p class="em"><?php echo '<h4> Emergency : </h4>' . $row['em']; ?></p>
                            </div>
                            <div class="card-footer">
                                <!-- Store selected professional data in session variables -->
                                <input type="hidden" name="selected_em" value="<?php echo $row['em']; ?>">
                                <input type="hidden" name="selected_prof_id" value="<?php echo $row['pid']; ?>">
                                <input type="hidden" name="selected_prof_name" value="<?php echo $row['pname']; ?>">
                                <input type="hidden" name="selected_service_type" value="<?php echo $row['service_type']; ?>">
                                <input type="hidden" name="selected_city" value="<?php echo $row['city']; ?>">
                                <!-- Continue button -->
                                <button class="see-more" type="submit" name="continue">Continue</button>
                            </div>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div>
            <p class="text">Select items to find a professional</p>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <select id="Service-Type" name="service-type" class="selected-box" onchange="changeDropdownColor(this)">
                <option value="Plumber">Plumber</option>
    <option value="Technician">Technician</option>
    <option value="Electrician">Electrician</option>
    <option value="Mechanic">Mechanic</option>
    <option value="Furniture Assembly">Furniture Assembly</option>
    <option value="AC Repair">AC Repair</option>
    <option value="Painter">Painter</option>
    <option value="Moving Help">Moving Help</option>
    <option value="Curpainter">Curpainter</option>
    <option value="Mounting job">Mounting job</option>

                </select>
                <label id="Area" class="selected-box"><?php echo $location ?></label>
                <label id="post-code" class="selected-box"><?php echo $post_code ?></label>

                <input class="date-picker-display" type="date" id="dateInput" name="selected_date" placeholder="Date:">

                <input class="time-picker-container" type="time" id="timeInput" name="selected_time" placeholder="Time:">

                <div class="button-container-2">
                    <button class="button" type="submit" name="search">
                        <i class="fas fa-search-alt"></i>&nbsp;Search
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
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