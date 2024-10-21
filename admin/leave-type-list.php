<?php
include '../config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch leave types from the database
$queryLeaveTypes = "SELECT leave_id, leave_type FROM leave_types"; 
$resultLeaveTypes = $conn->query($queryLeaveTypes);




// Get success message
$successMessage = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
unset($_SESSION['success_message']); // Clear the message after displaying

// Get error message
$errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['error_message']); // Clear the message after displaying

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Leave Types</title>
    <link rel="icon" type="image/webp" href="../img/logo.webp">
    <link rel="stylesheet" href="../css/leave_type_lists.css">
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


<main><br>
    <h1>List of Leave Types</h1><br>

    <!-- Success and Error Messages -->
    <?php if ($successMessage): ?>
        <div class="success-message"><?php echo htmlspecialchars($successMessage); ?></div>
    <?php endif; ?>

    <?php if ($errorMessage): ?>
        <div class="error-message"><?php echo htmlspecialchars($errorMessage); ?></div>
    <?php endif; ?>

    <!-- Search Bar -->
    <center> 
        <input type="text" id="searchInput" placeholder="Search by Leave ID, Leave Type" onkeyup="filterTable()">
        <!-- Button Wrapper for Alignment -->
<div class="button-wrapper">
    <button class="create-leave-type-button" onclick="openCreateLeaveTypeModal()">Create New Leave Type</button>
</div>

<!-- Leave Type Table -->
<table class="leave-type-table" id="leaveTypeTable">
    <thead>
        <tr>
            <th>Leave ID</th>
            <th>Leave Type</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($resultLeaveTypes && $resultLeaveTypes->num_rows > 0): ?>
            <?php while ($row = $resultLeaveTypes->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['leave_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['leave_type']); ?></td>
                    <td>
                        <button class="edit-button" onclick="openEditModal(<?php echo htmlspecialchars($row['leave_id']); ?>, '<?php echo htmlspecialchars($row['leave_type']); ?>')">Edit</button>
                        <button class="delete-button" onclick="confirmDelete('<?php echo htmlspecialchars($row['leave_type']); ?>', <?php echo htmlspecialchars($row['leave_id']); ?>)">Delete</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">No leave types found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

    </center>

</main>

<!-- Create Leave Type Modal -->
<div id="createLeaveTypeModal" class="modal-overlay">
    <div class="modal-content">
        <h2>Create New Leave Type</h2>
        <form action="create-leave-type.php" method="POST">
            <label for="leave_id">Leave ID:</label>
            <input type="number" id="leave_id" name="leave_id" required>

            <label for="leave_type">Leave Type:</label>
            <input type="text" id="leave_type" name="leave_type" required>

            <button type="submit" class="submit-button">Create Leave Type</button>
            <button type="button" class="cancel-button" onclick="closeModal()">Cancel</button>
        </form>
    </div>
</div>





<!-- Edit Leave Type Modal -->
<div id="editLeaveTypeModal" class="edit-modal-overlay" style="display:none;">
    <div class="edit-modal-content">
        <h2>Edit Leave Type</h2>
        <form action="edit-leave-type.php" method="POST">
            <label for="edit_leave_id">Leave ID:</label>
            <input type="number" id="edit_leave_id" name="leave_id" required readonly>

            <label for="edit_leave_type">Leave Type:</label>
            <input type="text" id="edit_leave_type" name="leave_type" required>
            
            <button type="submit" class="submit-button">Update Leave Type</button>
            <button type="button" class="cancel-button" onclick="closeEditModal()">Cancel</button>
        </form>
    </div>
</div>

<!-- Delete Confirmation Dialog -->
<div id="deleteConfirmationDialog" class="delelete-dialog-overlay1" style="display:none;">
    <div class="delete-dialog-content">
        <h3>Are you sure you want to delete Leave Type: <span id="leave-type-display"></span>?</h3>
        <div class="dialog-buttons">
            <button id="confirm-delete-button">Yes, Delete</button>
            <button class="cancel" id="cancel-delete-button">Cancel</button>
        </div>
    </div>
</div>

<footer>
    <p>2024 Leave Management</p>
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

<script src="../js/sign_out.js"></script>
<script src="../jsno-previousbutton.js"></script>
<script src="../js/crud-leavetype.js"></script>
<script src="../js/toggle-darkmode.js"></script>


<style>





</style>
</body>
</html>
