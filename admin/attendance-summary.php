<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
?>
<style>
/* Add styles for the action buttons */
.edit-button, .delete-button {
    padding: 5px 10px;
    margin: 2px;
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.edit-button:hover {
    background-color: #d3f3d3;
}

.delete-button:hover {
    background-color: #f3d3d3;
}

/* Dropdown Menu */
.dropdown {
    position: relative;
    display: inline-block;
}

.dropbtn {
    cursor: pointer;
}

.dropdown-content {
    display: none;
    margin-top: 1.5px;
    font-size: 15px;
    position: absolute;
    background-color: white;
    min-width: 90px;
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
    z-index: 1;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: white;
}

.dropdown:hover .dropdown-content {
    display: block;
}

/* Employee Panel Styling */
.employee-panel {
    background-color: #fff;
    border: 1px solid #f0f0f0;
    padding: 20px;
    margin-bottom: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

/* Employee Panel Styling */
body.dark-mode .employee-panel {
    background-color: #111;
    border: 1px solid #222;
    padding: 20px;
    margin-bottom: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}



/* Employee Name Styling */
body.dark-mode .employee-name {
    font-size: 1.5rem;
    font-weight: bold;
    color: #35B535;
    margin-bottom: 10px;
    background-color: #222;
    padding: 10px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: center;
}

/* Employee Name Styling */
.employee-name {
    font-size: 1.5rem;
    font-weight: bold;
    color: #35B535;
    margin-bottom: 10px;
    background-color: #f7f7f7;
    padding: 10px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: center;
}

/* Edit and Delete Button Styling */
.edit-button, .delete-button {
    padding: 5px 10px;
    margin: 2px;
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.edit-button:hover {
    background-color: #d3f3d3;
}

.delete-button:hover {
    background-color: #f3d3d3;
}
.logo {
    font-size: 1.5rem;
    color: black;
    text-decoration: none;
    display: inline-block;
    cursor: pointer;
}
</style>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timesheet - Attendance Summary</title>
    <link rel="icon" type="image/webp" href="../img/logo.webp">
    <link rel="stylesheet" href="../css/timesheet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
    
</div><button type="button" class="logout" id="logout-button">
    <i class="fas fa-sign-out-alt"></i>
    </button>
<!-- END NG TOP NAVIGATIONAL BAR -->
    </div>




    <div class="container">
        <!-- Timesheet Panel -->
        <div class="timesheet-panel1">
            <div id="date-info"></div> <!-- Placeholder for date and day -->
        </div>

        <!-- Individual Employee Tables -->
        <div class="employee-tables">
            <h2 style="margin-left: 10px;">Weekly Attendance Breakdown</h2><br>

            <!-- Table for John Doe -->
<div class="employee-panel">
    <h3 class="employee-name">Employee ID: 101 - John Doe  - Kitchen, Cook</h3>
    <table>
        <thead>
            <tr>
                <th>Week</th>
                <th>Monday</th>
                <th>Tuesday</th>
                <th>Wednesday</th>
                <th>Thursday</th>
                <th>Friday</th>
                <th>Saturday</th>
                <th>Sunday</th>
                <th>Total Hours (Week)</th>
                <th>Overtime Hours</th>
                
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Week 1</td>
                <td>8 hrs</td>
                <td>8 hrs</td>
                <td>8 hrs</td>
                <td>8 hrs</td>
                <td>8 hrs</td>
                <td>4 hrs</td>
                <td>0 hrs</td>
                <td>40 hrs</td>
                <td>2 hrs</td> <!-- Overtime -->
                
            </tr>
            <tr>
                <td>Week 2</td>
                <td>8 hrs</td>
                <td>8 hrs</td>
                <td>8 hrs</td>
                <td>8 hrs</td>
                <td>8 hrs</td>
                <td>4 hrs</td>
                <td>0 hrs</td>
                <td>40 hrs</td>
                <td>3 hrs</td> <!-- Overtime -->
                
            </tr>
            <tr>
                <td>Week 3</td>
                <td>7 hrs</td>
                <td>8 hrs</td>
                <td>8 hrs</td>
                <td>8 hrs</td>
                <td>7 hrs</td>
                <td>4 hrs</td>
                <td>0 hrs</td>
                <td>38 hrs</td>
                <td>2 hrs</td> <!-- Overtime -->
                
            </tr>
            <tr>
                <td>Week 4</td>
                <td>8 hrs</td>
                <td>8 hrs</td>
                <td>8 hrs</td>
                <td>8 hrs</td>
                <td>8 hrs</td>
                <td>4 hrs</td>
                <td>0 hrs</td>
                <td>42 hrs</td>
                <td>4 hrs</td> <!-- Overtime -->
                
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="8">Total Hours (Month)</th>
                <th>160 hrs</th>
                <th>11 hrs</th> <!-- Updated total overtime -->
            </tr>
        </tfoot>
    </table>
</div><br>

<!-- Table for Rheniel Marzan -->
<div class="employee-panel">
    <h3 class="employee-name">Employee ID: 102 - Rheniel Marzan  - Front Desk, Receptionist</h3>
    <table>
        <thead>
            <tr>
                <th>Week</th>
                <th>Monday</th>
                <th>Tuesday</th>
                <th>Wednesday</th>
                <th>Thursday</th>
                <th>Friday</th>
                <th>Saturday</th>
                <th>Sunday</th>
                <th>Total Hours (Week)</th>
                <th>Overtime Hours</th>
                
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Week 1</td>
                <td>9 hrs</td>
                <td>8 hrs</td>
                <td>7 hrs</td>
                <td>8 hrs</td>
                <td>8 hrs</td>
                <td>5 hrs</td>
                <td>0 hrs</td>
                <td>40 hrs</td>
                <td>5 hrs</td> <!-- Overtime -->
                
            </tr>
            <tr>
                <td>Week 2</td>
                <td>9 hrs</td>
                <td>8 hrs</td>
                <td>7 hrs</td>
                <td>8 hrs</td>
                <td>8 hrs</td>
                <td>5 hrs</td>
                <td>0 hrs</td>
                <td>40 hrs</td>
                <td>4 hrs</td> <!-- Overtime -->
                
            </tr>
            <tr>
                <td>Week 3</td>
                <td>8 hrs</td>
                <td>7 hrs</td>
                <td>7 hrs</td>
                <td>8 hrs</td>
                <td>8 hrs</td>
                <td>5 hrs</td>
                <td>0 hrs</td>
                <td>38 hrs</td>
                <td>3 hrs</td> <!-- Overtime -->
                
            </tr>
            <tr>
                <td>Week 4</td>
                <td>9 hrs</td>
                <td>8 hrs</td>
                <td>7 hrs</td>
                <td>8 hrs</td>
                <td>8 hrs</td>
                <td>5 hrs</td>
                <td>0 hrs</td>
                <td>40 hrs</td>
                <td>6 hrs</td> <!-- Overtime -->
                
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="8">Total Hours (Month)</th>
                <th>158 hrs</th>
                <th>18 hrs</th> <!-- Updated total overtime -->
            </tr>
        </tfoot>
    </table>
</div>

        </div>
    </div>

    <footer>
        <p>2024 Timesheet Tracker</p>
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

    <script src="../js/time.js"></script>
    <script src="../js/sign_out.js"></script>
<script src="../jsno-previousbutton.js"></script>
<script src="../js/toggle-darkmode.js"></script>
</body>
</html>
