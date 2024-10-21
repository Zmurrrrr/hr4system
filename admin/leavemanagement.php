<?php
include '../config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch employee details for the dropdown
$employeeResult = $conn->query("SELECT employee_id, employee_name FROM employee_info");

// Fetch leave types for the leave type dropdown
$leaveTypesResult = $conn->query("SELECT leave_id, leave_type FROM leave_types");

// Fetch leave requests to display in the table
$leaveRequestsResult = $conn->query("SELECT e.employee_id, e.employee_name, d.department_name, e.position, 
                                        lr.leave_id, lt.leave_type, lr.start_date, lr.end_date, 
                                        lr.total_days, lr.remarks, lr.status 
                                     FROM employee_leave_requests lr
                                     JOIN employee_info e ON lr.employee_id = e.employee_id
                                     JOIN departments d ON e.department_id = d.department_id
                                     JOIN leave_types lt ON lr.leave_id = lt.leave_id");

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request</title>
    <link rel="icon" type="image/webp" href="../img/logo.webp">
    <link rel="stylesheet" href="../css/leavemanagement.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="light-mode">
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
        <button type="button" id="darkModeToggle" class="dark-mode-toggle" aria-label="Toggle Dark Mode">
            <i class="fas fa-moon"></i>
        </button>

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

    
    <div class="leave-request-form">
        <h3>Leave Request Form</h3>
        <form method="POST" action="submit-leave-request.php" id="leaveForm">
            <label for="employee_id">Employee:</label>
            <select id="employee_id" name="employee_id" onchange="fetchEmployeeDetails()" required>
                <option value="">Select Employee</option>
                <?php
                if ($employeeResult->num_rows > 0) {
                    while ($row = $employeeResult->fetch_assoc()) {
                        echo '<option value="' . $row['employee_id'] . '">' . $row['employee_id'] . ' - ' . htmlspecialchars($row['employee_name']) . '</option>';
                    }
                }
                ?>
            </select>
            <br>

            <label for="employee_name">Employee Name:</label>
            <input type="text" id="employee_name" name="employee_name" readonly>

            <label for="department">Department:</label>
            <input type="text" id="department" name="department" readonly>

            <label for="position">Position:</label>
            <input type="text" id="position" name="position" readonly>

            <label for="leave_type">Leave Type:</label>
            <select id="leave_type" name="leave_type" required>
                <option value="">Select Leave Type</option>
                <?php
                if ($leaveTypesResult->num_rows > 0) {
                    while ($row = $leaveTypesResult->fetch_assoc()) {
                        echo '<option value="' . $row['leave_id'] . '">' . htmlspecialchars($row['leave_type']) . '</option>';
                    }
                }
                ?>
            </select>

            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required>

            <label for="total_days">Total Day/s:</label>
            <input type="number" id="total_days" name="total_days" readonly>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="Pending">Pending</option>
                <option value="Approved">Approved</option>
                <option value="Rejected">Rejected</option>
            </select>

            <label for="remarks">Remarks:</label>
            <textarea id="remarks" name="remarks" rows="4" placeholder="Reason for leave..." required></textarea>

            <button type="submit">Submit Leave Request</button>
        </form>
    </div>

    <br>
    <div class="panel">
        <h2>Leave Data Status</h2>
        <table>
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Total Days</th>
                    <th>Remarks</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
    <?php
    if ($leaveRequestsResult->num_rows > 0) {
        while ($row = $leaveRequestsResult->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['employee_id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['employee_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['department_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['position']) . '</td>';
            echo '<td>' . htmlspecialchars($row['leave_type']) . '</td>';
            echo '<td>' . htmlspecialchars($row['start_date']) . '</td>';
            echo '<td>' . htmlspecialchars($row['end_date']) . '</td>';
            echo '<td>' . htmlspecialchars($row['total_days']) . '</td>';
            echo '<td>' . htmlspecialchars($row['remarks']) . '</td>';
            echo '<td>' . htmlspecialchars($row['status']) . '</td>';
            // Add an Edit button
            echo '<td><button class="edit-button" 
    data-leave-id="' . htmlspecialchars($row['leave_id']) . '" 
    data-employee-name="' . htmlspecialchars($row['employee_name']) . '" 
    data-department="' . htmlspecialchars($row['department_name']) . '" 
    data-position="' . htmlspecialchars($row['position']) . '" 
    data-leave-type="' . htmlspecialchars($row['leave_type']) . '" 
    data-start-date="' . htmlspecialchars($row['start_date']) . '" 
    data-end-date="' . htmlspecialchars($row['end_date']) . '" 
    data-remarks="' . htmlspecialchars($row['remarks']) . '" 
    data-status="' . htmlspecialchars($row['status']) . '">
    Edit
</button></td>';

            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="11">No leave requests found.</td></tr>';
    }
    ?>
</tbody>

        </table>
    </div>

    <!--EDIT MODAL OVERLAY-->
<!-- Edit Leave Modal -->
<div id="editLeaveModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Edit Leave Request</h3>
        <form id="editLeaveForm" method="POST" action="update-leave-request.php">
            <input type="hidden" id="edit_leave_id" name="leave_id">
            
            <!-- Employee name, department, and position are readonly -->
            <label for="edit_employee_name">Employee Name:</label>
            <input type="text" id="edit_employee_name" name="employee_name" readonly>
            
            <label for="edit_department">Department:</label>
            <input type="text" id="edit_department" name="department" readonly>

            <label for="edit_position">Position:</label>
            <input type="text" id="edit_position" name="position" readonly>

            <!-- Editable fields -->
            <label for="edit_leave_type">Leave Type:</label>
            <select id="edit_leave_type" name="leave_type">
                <!-- Dynamically populate options here -->
            </select>

            <label for="edit_start_date">Start Date:</label>
            <input type="date" id="edit_start_date" name="start_date" required>

            <label for="edit_end_date">End Date:</label>
            <input type="date" id="edit_end_date" name="end_date" required>

            <label for="edit_remarks">Remarks:</label>
            <textarea id="edit_remarks" name="remarks" rows="4"></textarea>

            <label for="edit_status">Status:</label>
            <select id="edit_status" name="status" required>
                <option value="Pending">Pending</option>
                <option value="Approved">Approved</option>
                <option value="Rejected">Rejected</option>
            </select>

            <button type="submit">Update Leave Request</button>
        </form>
    </div>
</div>




    <script src="../js/fetch&calculate_leave.js"></script>
    <script src="../js/no-previousbutton.js"></script>
    <script src="../js/sign_out.js"></script>
<script src="../js/toggle-darkmode.js"></script>
</body>
<script>// Get modal element

</script>
<style>
/* Modal container */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 999; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto; /* Enable scrolling if needed */
    background-color: rgba(0, 0, 0, 0.7); /* Black background with opacity */
}

/* Modal content box */
.modal-content {
    background-color: #fefefe;
    margin: 10% auto; /* 10% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 40%; /* Can adjust as needed */
    border-radius: 8px;
    position: relative;
}

/* Close button */
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* Form inputs inside modal */
.modal-content input,
.modal-content select,
.modal-content textarea {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

/* Submit button inside modal */
.modal-content button {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
}

.modal-content button:hover {
    background-color: #45a049;
}

</style>

</html>