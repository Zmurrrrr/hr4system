<?php  
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

$username = $_SESSION['username'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'hr3final9');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for adding attendance
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_attendance'])) {
    $employee_id = $_POST['employee_id'];
    $date = $_POST['date'];  // Get the date
    $time_in = $_POST['time_in'];
    $time_out = $_POST['time_out'];
    $source = $_POST['source'];

    // Check if time_in, time_out, and date are not null
    if (empty($time_in) || empty($time_out) || empty($date)) {
        $error_msg = "Date, Time In, and Time Out cannot be empty.";
    } else {
        // Fetch employee name based on employee_id
        $query = "SELECT employee_name FROM employee_info WHERE employee_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $employee_id);
        $stmt->execute();
        $stmt->bind_result($employee_name);
        
        if ($stmt->fetch()) {
            $stmt->close();

            // Check if the employee_id exists in employee_info
            $check_query = "SELECT COUNT(*) FROM employee_info WHERE employee_id = ?";
            $check_stmt = $conn->prepare($check_query);
            $check_stmt->bind_param('i', $employee_id);
            $check_stmt->execute();
            $check_stmt->bind_result($count);
            $check_stmt->fetch();
            $check_stmt->close();

            if ($count > 0) {
                // Employee ID exists, proceed with insertion
                $insert_query = "INSERT INTO attendance_log (employee_id, employee_name, date, time_in, time_out, source) VALUES (?, ?, ?, ?, ?, ?)";
                $insert_stmt = $conn->prepare($insert_query);
                $insert_stmt->bind_param('isssss', $employee_id, $employee_name, $date, $time_in, $time_out, $source);
                if ($insert_stmt->execute()) {
                    $success_msg = "Attendance log added successfully!";
                } else {
                    $error_msg = "Failed to add attendance log: " . $insert_stmt->error;
                }
                $insert_stmt->close();
            } else {
                $error_msg = "Employee ID does not exist!";
            }
        } else {
            $error_msg = "Failed to fetch employee name!";
        }
    }
}

// Fetch employees for the dropdown
$employees = $conn->query("SELECT employee_id, employee_name FROM employee_info");

$selected_date = '';
$attendance_records = [];

// Handle date selection for viewing records
// Handle date selection for viewing records
if (isset($_POST['selected_date'])) {
    $selected_date = $_POST['selected_date'];
    
    // Only execute the query once
    $attendance_query = "SELECT * FROM attendance_log WHERE `date` = ?";
    $stmt = $conn->prepare($attendance_query);
    $stmt->bind_param('s', $selected_date);

    // Check if the statement preparation was successful
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    // Execute the statement
    if (!$stmt->execute()) {
        die("Error executing query: " . $stmt->error);
    }

    // Get the result
    $result = $stmt->get_result();
    $attendance_records = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
    $conn->close();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Time and Attendance</title>
    <link rel="icon" type="image/webp" href="../img/logo.webp">
    <link rel="stylesheet" href="../css/attendance-dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .dashboard-panel {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }
        label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        select, input[type="date"], input[type="time"], input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 16px;
        }
        form {
            display: flex;
            flex-direction: column;
             margin-bottom: 20px;
             width: 50%; /* Set form width to 50% */
             margin: 0 auto; /* Center the form horizontally */
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        table {
            width: 80%; /* Set table width to 80% for a smaller look */
            margin: 20px auto; /* Center the table */
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .back-button {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body class="light-mode"> <!-- Initially setting light mode -->
    <div class="top-nav">
        <ul>
            <h1 class="logopos">Paradise <br> Hotel</h1><br>
            <li class="top">
                <a class="top1" href="../maindashboard.php">Employee Dashboard</a>
                <div class="top1dropdown">
                    <div class="dropdown-column">
                        <h3>Payroll</h3>
                        <a href="../admin/time-and-attendance-home.php">Time and Attendance</a>
                        <a href="../Employee-information/dashboard2.php">Employee Information</a>
                        <a href="../Employee-information/payroll-processing.php">Payroll Processing</a>
                    </div>           
                    <div class="dropdown-column">
                        <h3>Payroll Settings</h3>
                        <a href="../Employee-information/tax-tables.php">Tax Tables</a>
                        <a href="../Employee-information/overtime-rules.php">Overtime Rules</a>
                        <a href="../Employee-information/payroll-deduction.php">Payroll Deductions</a>
                    </div>          
                    <div class="dropdown-column">
                        <h3>Charts and Graphs</h3>
                        <a href="#">Revenue Trend</a>
                        <a href="#">Profit Margin Trend</a>
                        <a href="#">Cash Flow Chart</a>
                        <a href="#">Financial Ratios Chart</a>
                    </div>

                    <div class="dropdown-column">
                        <h3>Quick Access Links</h3>
                        <a href="#">Frequently Used Reports</a>
                        <a href="#">Recent Transactions</a>
                        <a href="#">Quick Actions</a>
                    </div>            
                </div>
            </li>
            <li class="top">
                <a class="top1" href="#">Employee information</a>
                <div class="top1dropdown">
                    <div class="dropdown-column">
                        <h3><b>Manage Employee</b></h3>
                        <a href="../Employee-information/employee-form.php">Employee Form</a>
                        <a href="../Employee-information/employee-list.php">Employee List</a>
                    </div>
                </div>
            </li>
            <li class="top">
                <a class="top1" href="homeversion2.html">Manage</a>
                <div class="top1dropdown">
                    <div class="dropdown-column">
                        <h3><b>Attendance Tracking</b></h3>
                        <a href="clocking-system.php">Clocking System</a>
                        <a href="timesheet.php">Daily Record</a>
                        <a href="attendance-summary.php">Attendance Summary</a>
                    </div>
                    <div class="dropdown-column">
                        <h3><b>Leave Management</b></h3>
                        <a href="leavemanagement.php">Leave Requests</a>
                        <a href="leave-record.php">Employee Leave Records</a>
                        <a href="leave-type-list.php">List of Leave Types</a>
                    </div>
                    <div class="dropdown-column">
                        <h3><b>Manage Department</b></h3>
                        <a href="department.php">Department</a>

                    </div>
                    <div class="dropdown-column">
                        <h3><b>Shift Management</b></h3>
                        <a href="manage-shift.php">Manage Shift</a>

                    </div>
                    
                </div>
            </li>
            <li class = "top">
                <a class="top1" href="#settings">Settings</a>
                <div class="top1dropdown">
                    <div class="dropdown-column">
                        <h3>General Settings</h3>
                        <a href="#">Company Information</a>
                        <a href="#">Currency Settings</a>
                        <a href="#">Time Zone Settings</a>
                    </div>
                    <div class="dropdown-column">
                        <h3>User Management</h3>
                        <a href="#">User Roles</a>
                        <a href="admin-user-accounts.php">User Accounts</a>
                        <a href="#">Password Management</a>
                        <a href="#">User Permissions</a>
                    </div>
                    <div class="dropdown-column">
                        <h3>Chart of Accounts Settings</h3>
                        <a href="#">Account Structure</a>
                        <a href="#">Account Types</a>
                        <a href="#">Account Templates</a>
                    </div>
                    <div class="dropdown-column">
                        <h3>Inventory Settings</h3>
                        <a href="#">Inventory Valuation Methods</a>
                        <a href="#">Stock Levels:</a>
                        <a href="#">Reorder Points</a>
                    </div>
            </li>
        </ul>
         <!-- <button type="button" id="darkModeToggle" class="dark-mode-toggle">Dark Mode</button> -->
         <button type="button" id="darkModeToggle" class="dark-mode-toggle" aria-label="Toggle Dark Mode">
            <i class="fas fa-moon"></i> <!-- Example icon for dark mode -->
        </button>

        <!-- USER  -->
        <div class="admin-section">
            <div class="admin-name">
                User - <?php echo htmlspecialchars($username); ?>
                <div class="admin-dropdown-content">
                    <a href="../manage_account.php">Manage Account</a>
                </div>
            </div>
        </div>
        <button type="button" class="logout" id="logout-button">
            <i class="fas fa-sign-out-alt"></i>
        </button>
    </div>

    <div class="dashboard-panel">
        <h2>Add Attendance</h2>
        <form method="POST">
            <label for="employee_id">Employee ID:</label>
            <select name="employee_id" required>
                <option value="">Select Employee</option>
                <?php while ($row = $employees->fetch_assoc()): ?>
                    <option value="<?php echo $row['employee_id']; ?>"><?php echo $row['employee_name']; ?></option>
                <?php endwhile; ?>
            </select>

            <label for="date">Date:</label>
            <input type="date" name="date" required>

            <label for="time_in">Time In:</label>
            <input type="time" name="time_in" required>

            <label for="time_out">Time Out:</label>
            <input type="time" name="time_out" required>

            <label for="source">Source:</label>
            <input type="text" name="source" placeholder="Enter source (e.g., Manual, Mobile)" required>

            <button type="submit" name="add_attendance">Add Attendance</button>
        </form>

        <?php if (isset($success_msg)): ?>
            <p style="color: green;"><?php echo $success_msg; ?></p>
        <?php endif; ?>
        <?php if (isset($error_msg)): ?>
            <p style="color: red;"><?php echo $error_msg; ?></p>
        <?php endif; ?>
        <h2>Attendance Records</h2>
        <form method="POST">
            <label for="selected_date">Select Date:</label>
            <input type="date" name="selected_date" value="<?php echo $selected_date; ?>" required>
            <button type="submit">Show Records</button>
        </form>

        <?php if (!empty($attendance_records)): ?>
    <h2>Attendance Records for <?php echo htmlspecialchars($selected_date); ?></h2>
    <table>
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Employee Name</th>
                <th>Date</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Source</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($attendance_records as $record): ?>
                <tr>
                    <td><?php echo htmlspecialchars($record['employee_id']); ?></td>
                    <td><?php echo htmlspecialchars($record['employee_name']); ?></td>
                    <td><?php echo htmlspecialchars($record['date']); ?></td>
                    <td><?php echo htmlspecialchars($record['time_in']); ?></td>
                    <td><?php echo htmlspecialchars($record['time_out']); ?></td>
                    <td><?php echo htmlspecialchars($record['source']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No attendance records found for the selected date.</p>
<?php endif; ?>

    </div>

    <div class="back-button">
        <a href="../maindashboard.php"><button>Back to Dashboard</button></a>
    </div>
    <div id="dialog-overlay" class="dialog-overlay">
        <div class="dialog-content">
            <h3>Are you sure you want to sign out?</h3>
            <div class="dialog-buttons">
                <button id="confirm-button">Sign Out</button>
                <button class="cancel" id="cancel-button">Cancel</button>
            </div>
        </div>
    </div>
    


    <script src="../js/main-sign-out.js"></script>
    <script src="../jsno-previousbutton.js"></script>
    <script src="../js/toggle-darkmode.js"></script>
    </script>
</body>
</html>
