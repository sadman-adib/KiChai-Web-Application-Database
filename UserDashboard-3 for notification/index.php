<?php 
$data = [];
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

if(isset($_SESSION['user_ID'])) {
    $userID = $_SESSION['user_ID'];

        // Prepare the SQL statement using placeholders for user input
        $sql = "SELECT pname, stype, DateTime, des,
                 CASE
                    WHEN accept = 1 AND complete = 1 THEN 'Completed'
                    WHEN accept = 1 AND complete IS NULL THEN 'Accepted'
                    ELSE 'Not Accepted'
                END AS current_progress
        FROM (
            SELECT CONCAT(s.first_name, ' ',s.last_name) AS pname,
                   c.service_type AS stype,
                   c.date_time DateTime,
                   c.description as des ,
                   c.accept as accept,
                   c.complete as complete
            FROM  call_outs c
            JOIN specialist s ON c.specialist_id = s.specialist_ID
            WHERE c.user_id = ?
            UNION ALL
            SELECT v.company_name AS pname,
                   c.service_type AS stype,
                   c.date_time as DateTime,
                   c.description as des ,
                   c.accept as accept,
                   c.complete as complete 
            FROM call_outs c
            JOIN vendor v ON c.vendor_id = v.vendor_ID
            WHERE c.user_id = ?
        ) AS combined_data
        order by DateTime desc;";

        // Prepare the SQL statement
        $stmt = mysqli_prepare($conn, $sql);

        // Bind parameters to the placeholders
        mysqli_stmt_bind_param($stmt, "ii", $userID, $userID);


        // Execute the query
        mysqli_stmt_execute($stmt);

        // Get the result set
        $result = mysqli_stmt_get_result($stmt);

        // Check if the query executed successfully
        if ($result && mysqli_num_rows($result) > 0) {
            // Fetch the data from the result set
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row; // Store each row of data in an array
            }
        }
        else {
           // echo "No data found"; // Display message if no data found
        }
} else {
    //echo "User not logged in"; // Display message if user is not logged in
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KI CHAI</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400&display=swap">
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    .scrollable-table-container {
        height: 100%;
      max-height: 670px; /* Adjust the height as needed */
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
    font-family: 'Arial', sans-serif; /* Adjust the font family as needed */
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
    margin-left: auto; /* Align to the right */
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
    align-self: flex-start; /* Align button to the left */
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
        margin-left: 10px; /* Adjust for mobile */
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
        order: -1; /* Time appears first on mobile */
    }

    .card .see-more {
        width: 100%;
        margin-top: 15px;
    }
    .card-rating {
    display: flex;
    align-items: center;
    color: #FFD700; /* Star rating color */
    font-size: 1em; /* Adjust size as needed */
}

.card-rating i {
    /* If using FontAwesome, for example */
    margin-right: 5px; /* Space between stars */
}

.card-rating i.filled {
    /* Class for filled star */
    content: "\f005"; /* FontAwesome filled star */
}

.card-rating i.half-filled {
    /* Class for half-filled star */
    content: "\f089"; /* FontAwesome half-filled star */
}

.card-rating i.unfilled {
    /* Class for unfilled star */
    content: "\f006"; /* FontAwesome unfilled star */
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
        <?php foreach($data as $row): ?>
            <div class="card">
            <div class="card-header">
                <span class="pname" name="pname"><h2><?php echo '<h4> Professional Name : </h4>'. $row['pname'];?></h2> </span>
                <span class="service-type" name="service-type"><?php echo '<h4> Current Progress : </h4> '.$row['current_progress']; ?></span>
                <div class="card-rating">
                </div>
            </div>
            <div class="card-body">
            <p class="user-description"><?php echo'<h4> Information : </h4>'. $row['des']; ?></p>
            <div class="city" name="city"><?php echo '<h4> Date & Time : </h4>'.$row['DateTime']; ?></div>
            <div class="service-type" name="service-type"><?php echo '<h4> Service : </h4>'.$row['stype']; ?></div>
            </div>
            <div class="card-footer">
                <!-- Store selected professional data in session variables -->
                <!-- Continue button -->
            </div>
    </div>
            <?php endforeach; ?>
    </div>
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
    
    /* Date picker */

    function updateTime() {
    const hours = document.getElementById('hours').value;
    const minutes = document.getElementById('minutes').value;
    console.log(`Selected time: ${hours}:${minutes}`);
    }

    const calendarContainer = document.getElementById('calendarContainer');
    const dateDisplay = document.getElementById('dateDisplay');
    const calendarHeader = document.getElementById('calendarHeader');
    const calendarGrid = document.getElementById('calendarGrid');

    function toggleCalendar() {
    calendarContainer.classList.toggle('active');
    }

    function selectDate(day) {
    const selectedDate = new Date(2024, 2, day); // March 2024
    dateDisplay.textContent = selectedDate.toDateString();
    toggleCalendar();
    updateCalendar();
    }

    function updateCalendar() {
    calendarGrid.innerHTML = '';
    const daysInMonth = new Date(2024, 2, 31).getDate(); // March has 31 days

    for (let day = 1; day <= daysInMonth; day++) {
        const dayDiv = document.createElement('div');
        dayDiv.classList.add('calendar-day');
        if (new Date(2024, 2, day).toDateString() === dateDisplay.textContent) {
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

    /*time picker*/
    

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

     /* dropdwon area design control */

    // Function to change dropdown color
    function changeDropdownColor(select) {
        select.style.backgroundColor = '#fff';
        select.style.color = '#494949';
        select.style.border = '2px solid #ffb700'; // Changed border to 2px solid with color #ffb700
    }

    // Inside the selectDate function, after setting the selected date
    function selectDate(day) {
        const selectedDate = new Date(2024, 2, day); // March 2024
        const datePickerDisplay = document.getElementById('dateDisplay');
        datePickerDisplay.textContent = selectedDate.toDateString();
        changeDatePickerDisplayColor(datePickerDisplay); // Call the function to change styles
        toggleCalendar();
        updateCalendar();
    }

    // Function to change date picker display color
    function changeDatePickerDisplayColor(datePickerDisplay) {
        datePickerDisplay.style.backgroundColor = '#fff';
        datePickerDisplay.style.color = '#494949';
        datePickerDisplay.style.border = '2px solid #ffb700'; // Changed border to 2px solid with color #ffb700
    }

    function changeDropdownColor(select) {
            select.style.backgroundColor = '#fff';
            select.style.color = '#494949';
            select.style.border = '2px solid #ffb700'; // Changed border to 2px solid with color #ffb700
        }

        // Function to calculate current time + minutes
        function calculateTime(minutes) {
            var currentTime = new Date(); // Current time
            var futureTime = new Date(currentTime.getTime() + (minutes * 60000)); // Add minutes to current time
            return futureTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }); // Format future time
        }

        // Function to handle time selection
        document.getElementById('Select-time').onchange = function() {
            var selectedTime = this.value; // Get selected time value
            var futureTime = calculateTime(selectedTime); // Calculate future time
            console.log("Current time: " + new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }));
            console.log("Selected time + " + selectedTime + " minutes: " + futureTime);
        };
    
    
</script>
</body>
</html>
