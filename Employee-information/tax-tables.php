<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tax Tables - Payroll Settings</title>
    <link rel="stylesheet" href="../css/employee-dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
        .tax-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 18px;
            text-align: left;
        }
        .tax-table th, .tax-table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
        }
        .tax-table th {
            background-color: #f2f2f2;
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
                        <a href="employee-form.php">Employee Form</a>
                        <a href="employee-list.php">Employee List</a>

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
        <button type="button" id="darkModeToggle" class="dark-mode-toggle" aria-label="Toggle Dark Mode">
            <i class="fas fa-moon"></i> <!-- Example icon for dark mode -->
        </button>
        <!-- User -->
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

    <div class="container">
    <div class="dashboard-panel">
        <h2>Tax Tables</h2><br>

        <!-- Tax Table Section -->
        <div class="tax-table-section">
            <table class="tax-table">
                <thead>
                    <tr>
                        <th>Income Bracket (PHP)</th>
                        <th>Tax Rate</th>
                        <th>Base Tax</th>
                        <th>Excess over (PHP)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>₱0 - ₱250,000</td>
                        <td>0%</td>
                        <td>₱0</td>
                        <td>₱0</td>
                    </tr>
                    <tr>
                        <td>₱250,001 - ₱400,000</td>
                        <td>20%</td>
                        <td>₱0</td>
                        <td>₱250,000</td>
                    </tr>
                    <tr>
                        <td>₱400,001 - ₱800,000</td>
                        <td>25%</td>
                        <td>₱30,000</td>
                        <td>₱400,000</td>
                    </tr>
                    <tr>
                        <td>₱800,001 - ₱2,000,000</td>
                        <td>30%</td>
                        <td>₱130,000</td>
                        <td>₱800,000</td>
                    </tr>
                    <tr>
                        <td>₱2,000,001 - ₱8,000,000</td>
                        <td>32%</td>
                        <td>₱490,000</td>
                        <td>₱2,000,000</td>
                    </tr>
                    <tr>
                        <td>₱8,000,001 and above</td>
                        <td>35%</td>
                        <td>₱2,410,000</td>
                        <td>₱8,000,000</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>


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

<script src="../js/main-sign-out.js"></script>
<script src="../js/toggle-darkmode.js"></script>
</body>

<style>
    .tax-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 18px;
        text-align: left;
    }
    .tax-table th, .tax-table td {
        padding: 12px 15px;
        border: 1px solid #ddd;
    }
    .tax-table th {
        background-color: #f2f2f2;
    }
</style>

</html>
