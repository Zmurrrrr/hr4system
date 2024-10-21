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
    <title>Manage Shift - Time and Attendance</title>
    <link rel="icon" type="image/webp" href="../img/logo.webp">
    <link rel="stylesheet" href="../css/shift-differential.css">
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
        <div class="shift-panel">
            <h2>Shift Scheduling Management</h2>
            <div class="date-info">
                <p id="date-info"></p>
                <p id="time-info"></p>
            </div>
            <div class="shift-form">
                <h3>Manage Shifts</h3><br>
                <form>
                    <label for="employee-id">Employee ID:</label>
                    <input type="text" id="employee-id" name="employee-id" required>

                    <label for="employee-name">Employee Name:</label>
                    <input type="text" id="employee-name" name="employee-name" required>

                    <label for="department">Department:</label>
                    <div class="select-wrapper">
                        <select id="department" name="department" required>
                            <option value="hotel-front-desk">Hotel - Front Desk</option>
                            <option value="hotel-housekeeping">Hotel - Housekeeping</option>
                            <option value="hotel-fb">Hotel - Food and Beverage</option>
                            <option value="hotel-maintenance">Hotel - Maintenance</option>
                            <option value="hotel-sales-marketing">Hotel - Sales and Marketing</option>
                            <option value="hotel-accounting">Hotel - Accounting</option>
                            <option value="hotel-hr">Hotel - Human Resources</option>
                            <option value="hotel-security">Hotel - Security</option>
                            <option value="hotel-events">Hotel - Events</option>
                            <option value="restaurant-kitchen">Restaurant - Kitchen</option>
                            <option value="restaurant-front">Restaurant - Front of House</option>
                            <option value="restaurant-bar">Restaurant - Bar</option>
                            <option value="restaurant-fb">Restaurant - Food and Beverage Service</option>
                            <option value="restaurant-purchasing">Restaurant - Purchasing</option>
                            <option value="restaurant-marketing">Restaurant - Marketing</option>
                        </select>
                    </div>

                    <label for="position">Position:</label>
                    <input type="text" id="position" name="position" required>

                    <label for="shift-date">Shift Date:</label>
                    <input type="date" id="shift-date" name="shift-date" required>

                    <label for="shift-start">Shift Start Time:</label>
                    <input type="time" id="shift-start" name="shift-start" required>

                    <label for="shift-end">Shift End Time:</label>
                    <input type="time" id="shift-end" name="shift-end" required>

                    <button type="submit" class="submit-btn">Save Shift</button>
                </form>
            </div>

            <div class="shift-roster">
                <h3>Shifts</h3><br>
                <table>
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Employee Name</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th>Last Update</th>
                            <th>Shift Start</th>
                            <th>Shift End</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>001</td>
                            <td>John Doe</td>
                            <td>Hotel - Front Desk</td>
                            <td>Receptionist</td>
                            <td>2024-09-15</td>
                            <td>08:00 AM</td>
                            <td>04:00 PM</td>
                        </tr>
                        <tr>
                            <td>002</td>
                            <td>Jane Smith</td>
                            <td>Restaurant - Bar</td>
                            <td>Bartender</td>
                            <td>2024-09-15</td>
                            <td>04:00 PM</td>
                            <td>12:00 AM</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Shift Differential Management</p>
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

<script src="../js/no-previousbutton.js"></script>
<script src="../js/sign_out.js"></script>
<script src="../js/toggle-darkmode.js"></script>
</body>
</html>
