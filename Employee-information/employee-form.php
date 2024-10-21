<?php
include '../config.php'; // Ensure the path is correct
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch existing departments from the database
$departments = [];
$sql = "SELECT department_id, department_name FROM departments";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $departments[] = $row;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and retrieve form inputs
    $employee_id = intval($_POST['employee-id']); // Ensure this is an integer
    $first_name = htmlspecialchars($_POST['first-name']);
    $middle_name = htmlspecialchars($_POST['middle-name']);
    $last_name = htmlspecialchars($_POST['last-name']);
    $employee_name = trim("$first_name $middle_name $last_name"); // Combine names
    $department_id = htmlspecialchars($_POST['department_id']); // Get department_id as a string
    $job_title = htmlspecialchars($_POST['job-title']);
    $dob = $_POST['dob'];
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $address = htmlspecialchars($_POST['address']);
    $date_hire = $_POST['date-hire'];
    $employment_status = htmlspecialchars($_POST['employment-status']);

    // Insert into the employee_info table
    $sql = "INSERT INTO employee_info (employee_id, employee_name, department_id, position, date_of_birth, contact_no, email_address, address, date_hired, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssssss", $employee_id, $employee_name, $department_id, $job_title, $dob, $phone, $email, $address, $date_hire, $employment_status);

    if ($stmt->execute()) {
        echo "<script>alert('Employee information submitted successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . htmlspecialchars($stmt->error) . "');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Employee Form</title>
    <link rel="stylesheet" href="../css/employee_form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<style>

</style>
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
                        <a href="payroll-processing.php">Payroll Processing</a>
                    </div>           
                    <div class="dropdown-column">
                        <h3>Payroll Settings</h3>
                        <a href="tax-tables.php">Tax Tables</a>
                        <a href="overtime-rules.php">Overtime Rules</a>
                        <a href="payroll-deduction.php">Payroll Deductions</a>
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
                        <a href="../admin/clocking-system.php">Clocking System</a>
                        <a href="../admin/timesheet.php">Daily Record</a>
                        <a href="../admin/attendance-summary.php">Attendance Summary</a>
                    </div>
                    <div class="dropdown-column">
                        <h3><b>Leave Management</b></h3>
                        <a href="../admin/leavemanagement.php">Leave Requests</a>
                        <a href="../admin/leave-record.php">Employee Leave Records</a>
                        <a href="../admin/leave-type-list.php">List of Leave Types</a>
                    </div>
                    <div class="dropdown-column">
                        <h3><b>Manage Department</b></h3>
                        <a href="department.php">Department</a>

                    </div>
                    <div class="dropdown-column">
                        <h3><b>Shift Management</b></h3>
                        <a href="../admin/manage-shift.php">Manage Shift</a>

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
                        <a href="#">User Accounts</a>
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
    
</div><button type="button" class="logout" id="logout-button">
    <i class="fas fa-sign-out-alt"></i>
    </button>
<!-- END NG TOP NAVIGATIONAL BAR -->
    </div>
    <br>
    <div class="content">
        <h2>Employee Information Form</h2>
        <form id="employee-info-form" method="post">
            <label for="employee-id">Employee ID:</label>
            <input type="number" id="employee-id" name="employee-id" required><br><br>

            <label for="first-name">First Name:</label>
            <input type="text" id="first-name" name="first-name" required><br><br>

            <label for="middle-name">Middle Name:</label>
            <input type="text" id="middle-name" name="middle-name"><br><br>

            <label for="last-name">Last Name:</label>
            <input type="text" id="last-name" name="last-name" required><br><br>

            <label for="department">Department:</label>
            <select id="department" name="department_id" required>
                <option value="" disabled selected>Select Department</option>
                <?php foreach ($departments as $department): ?>
                    <option value="<?php echo htmlspecialchars($department['department_id']); ?>">
                        <?php echo htmlspecialchars($department['department_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="job-title">Job Title/Position:</label>
            <input type="text" id="job-title" name="job-title" required><br><br>

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required><br><br>

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required><br><br>

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="address">Address:</label>
            <textarea id="address" name="address" rows="4" required></textarea><br><br>

            <label for="date-hire">Date of Hire:</label>
            <input type="date" id="date-hire" name="date-hire" required><br><br>

            <label for="employment-status">Employment Status:</label>
            <select id="employment-status" name="employment-status" required>
                <option value="" disabled selected>Select Employment Status</option>
                <option value="Full-time">Full-time</option>
                <option value="Part-time">Part-time</option>
                <option value="Contractual">Contractual</option>
            </select><br><br>

            <button type="submit">Submit Employee Information</button>
        </form>
    </div>

    <footer>
        <p>2024 Employee Information</p>
    </footer>

    <!-- Custom Confirmation Dialog -->
    <div id="dialog-overlay" class="dialog-overlay">
        <div class="dialog-content">
            <h3>Are you sure you want to sign out?</h3>
            <div class="dialog-buttons">
                <button id="confirm-button">Sign Out</button>
                <button class="cancel" id="cancel-button">Cancel</button>
            </div>
        </div>
    </div>
    
</body>
<script src="../js/main-sign-out.js"></script>
<script src="../jsno-previousbutton.js"></script>
<script src="../js/toggle-darkmode.js"></script>
</html>
