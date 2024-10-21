<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

$username = $_SESSION['username'];
include '../config.php';

// Constants for mandatory deduction rates
define('SSS_RATE', 0.045);
define('PHILHEALTH_RATE', 0.035);
define('PAGIBIG_RATE', 0.02);

// Check if payroll table exists; if not, create it
$table_check_query = "SHOW TABLES LIKE 'payroll'";
$table_check_result = mysqli_query($conn, $table_check_query);

if (mysqli_num_rows($table_check_result) == 0) {
    $create_table_query = "
    CREATE TABLE payroll (
        payroll_id INT AUTO_INCREMENT PRIMARY KEY,
        employee_id INT NOT NULL,
        payroll_date DATE NOT NULL,
        gross_salary DECIMAL(10, 2) NOT NULL,
        sss_deduction DECIMAL(10, 2) DEFAULT 0,
        philhealth_deduction DECIMAL(10, 2) DEFAULT 0,
        pagibig_deduction DECIMAL(10, 2) DEFAULT 0,
        loan_deduction DECIMAL(10, 2) DEFAULT 0,
        total_deductions DECIMAL(10, 2) DEFAULT 0,
        net_salary DECIMAL(10, 2) DEFAULT 0,
        FOREIGN KEY (employee_id) REFERENCES employee_info(employee_id) ON DELETE CASCADE
    ) ENGINE=InnoDB;";
    
    if (!mysqli_query($conn, $create_table_query)) {
        die("Table creation failed: " . mysqli_error($conn));
    }
}

// Fetch employee data and payroll information
function getEmployeeData($conn) {
    $query = "SELECT employee_info.employee_name, payroll.* 
              FROM payroll 
              JOIN employee_info ON payroll.employee_id = employee_info.employee_id 
              ORDER BY payroll.payroll_date DESC";
    $result = mysqli_query($conn, $query);

    // Check for query errors
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    return $result;
}

$payroll_result = getEmployeeData($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Deductions - Paradise Hotel</title>
    <link rel="stylesheet" href="../css/employee-dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Payroll Table Styling */
        .payroll-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .payroll-table thead {
            background-color: #4CAF50;
            color: white;
        }

        .payroll-table th, .payroll-table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
        }

        .payroll-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .payroll-table tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        .payroll-table td {
            font-size: 15px;
            color: #333;
        }

        /* Header and Dashboard panel styling */
        .dashboard-panel {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .dashboard-panel h2 {
            font-size: 22px;
            color: #333;
            margin-bottom: 15px;
        }

        /* Footer styling */
        footer {
            text-align: center;
            margin: 20px 0;
            font-size: 14px;
            color: #666;
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

        <!-- Dark mode toggle -->
        <button type="button" id="darkModeToggle" class="dark-mode-toggle" aria-label="Toggle Dark Mode">
            <i class="fas fa-moon"></i>
        </button>

        <!-- USER INFO -->
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

    <!-- Payroll Deductions Table -->
    <div class="container">
        <div class="dashboard-panel">
            <h2>Payroll Deductions</h2>
            <table class="payroll-table">
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>SSS Deduction</th>
                        <th>PhilHealth Deduction</th>
                        <th>Pag-IBIG Deduction</th>
                        <th>Total Deductions</th>
                    </tr>
                </thead>
                <tbody>
                <tbody>
                <tbody>
    <?php 
    // Fetch employee data and calculate deductions
    $employee_query = "SELECT employee_name FROM employee_info";
    $employee_result = mysqli_query($conn, $employee_query);

    // Check for query errors
    if (!$employee_result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Loop through each employee
    while ($employee_row = mysqli_fetch_assoc($employee_result)) {
        $employee_name = $employee_row['employee_name'];

        // Calculate deductions based on constants
        $sss_deduction = 2500 * SSS_RATE; // Example salary value used for calculation
        $philhealth_deduction = 2500 * PHILHEALTH_RATE;
        $pagibig_deduction = 2500 * PAGIBIG_RATE;

        // Calculate total deductions
        $total_deductions = $sss_deduction + $philhealth_deduction + $pagibig_deduction;
    ?>
        <tr>
            <td><?php echo htmlspecialchars($employee_name); ?></td> <!-- Display Employee Name -->
            <td><?php echo htmlspecialchars(number_format($sss_deduction, 2)); ?></td> <!-- SSS Deduction -->
            <td><?php echo htmlspecialchars(number_format($philhealth_deduction, 2)); ?></td> <!-- PhilHealth Deduction -->
            <td><?php echo htmlspecialchars(number_format($pagibig_deduction, 2)); ?></td> <!-- Pag-IBIG Deduction -->
            <td><?php echo htmlspecialchars(number_format($total_deductions, 2)); ?></td> <!-- Total Deductions -->
        </tr>
    <?php } ?>
</tbody>

            </table>
        </div>
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