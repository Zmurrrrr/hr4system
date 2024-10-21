<?php
include '../config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch department data
$query = "SELECT * FROM departments";
$result = $conn->query($query);
$message = "";
if (isset($_GET['update']) && $_GET['update'] == 'success') {
    $message = "<div class='success-message'>Department updated successfully!</div>";
}
if (isset($_GET['delete']) && $_GET['delete'] == 'success') {
    $message = "<div class='success-message'>Department deleted successfully!</div>";
}


// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department</title>
    <link rel="icon" type="image/webp" href="../img/logo.webp">
    <link rel="stylesheet" href="../css/department.css">
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
                <a class="top1" href=>Manage</a>
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
                        <a href="../admin/department.php">Department</a>

                    </div>
                    <div class="dropdown-column">
                        <h3><b>Shift Management</b></h3>
                        <a href="manage-shift.php">Manage Shift</a>

                    </div>
                </div>
            </li>
            <li class = "top">
                <a class="top1" href=>Settings</a>
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

<br>
<div class="departmenttable-panel">
    <h2>Department Data</h2>
     
       

    <div class="add-new-department">
        <a href="add-department.php" class="add-department-btn">Add New Department</a>
    </div>
   <!-- Display the message directly -->
   <?php if ($message): ?>
            <?php echo $message; ?> <!-- Echo the message here -->
        <?php endif; ?>
        <div class="table-controls">
    <div class="search-bar">
        <label for="search">Search: </label>
        <input type="text" id="search" placeholder="Department ID/Name..." onkeyup="searchDepartments()">
    </div>
</div>
    <table id="departmentTable" class="display">
        <thead>
            <tr>
                <th>Department ID</th>
                <th>Department Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if the result has any rows
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['department_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['department_name']) . "</td>";
                    echo "<td>
                            <button class='action-icon edit-icon' onclick='openEditDialog(" . htmlspecialchars($row['department_id']) . ", \"" . htmlspecialchars($row['department_name']) . "\")'>
        <i class='fas fa-edit'></i>
    </button>
    <button class='action-icon delete-icon' onclick='openDeleteDialog(" . htmlspecialchars($row['department_id']) . ")'>
        <i class='fas fa-trash'></i>
    </button>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No departments found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
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

<!-- Edit Department Dialog -->
<center><div id="edit-dialog-overlay" class="edit-dialog-overlay">
    <div class="edit-dialog-content">
        <h3>Edit Department</h3>
        <form id="edit-department-form" method="POST" action="edit-department.php">
            <input type="hidden" name="department_id" id="edit-department-id">
            <label for="edit-department-name">Department Name:</label>
            <input type="text" name="department_name" id="edit-department-name" required>
            <div class="edit-dialog-buttons">
                <button type="submit" id="save-button">Save</button>
                <button type="button" class="cancel" id="close-edit-dialog">Cancel</button>
            </div>
        </form>
    </div>
</div></center>

<!-- Delete Dialog -->
<div id="delete-dialog-overlay" class="delete-dialog-overlay">
    <div class="delete-dialog-content">
        <h3>Are you sure you want to delete this department?</h3>
        <div class="delete-dialog-buttons">
            <button id="confirm-delete-button">Delete</button>
            <button class="cancel" id="cancel-delete-button">Cancel</button>
        </div>
    </div>
</div>





<footer>
    <p>2024 Department</p>
</footer>
</body>

<script src="../js/no-previousbutton.js"></script>
<script src="../js/sign_out.js"></script>

<script>
function openEditDialog(departmentId, departmentName) {
    document.getElementById('edit-department-id').value = departmentId;
    document.getElementById('edit-department-name').value = departmentName;
    document.getElementById('edit-dialog-overlay').style.display = 'block';
}

document.getElementById('close-edit-dialog').onclick = function() {
    document.getElementById('edit-dialog-overlay').style.display = 'none';
};


function openDeleteDialog(departmentId) {
    // Set the department ID in the confirmation button
    document.getElementById('confirm-delete-button').setAttribute('data-id', departmentId);
    document.getElementById('delete-dialog-overlay').style.display = 'flex'; // Show the delete dialog
}

// Handle the delete confirmation button click
document.getElementById('confirm-delete-button').onclick = function() {
    var departmentId = this.getAttribute('data-id');
    
    // Make an AJAX request to delete the department
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "delete-department.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Reload the page or refresh the department table
            location.reload(); // Refresh the page after deletion
        }
    };
    xhr.send("department_id=" + encodeURIComponent(departmentId));

    // Hide the delete dialog after confirming
    document.getElementById('delete-dialog-overlay').style.display = 'none';
};

// Close delete dialog
document.getElementById('cancel-delete-button').onclick = function() {
    document.getElementById('delete-dialog-overlay').style.display = 'none'; // Hide dialog
};


</script>

<script>
function searchDepartments() {
    // Get the search input value
    const searchInput = document.getElementById('search').value.toLowerCase();
    // Get the table rows
    const tableRows = document.querySelectorAll('#departmentTable tbody tr');

    // Loop through the table rows
    tableRows.forEach(row => {
        // Get the text content of each row
        const rowData = row.textContent.toLowerCase();
        // Check if the row contains the search input
        if (rowData.includes(searchInput)) {
            row.style.display = ''; // Show the row
        } else {
            row.style.display = 'none'; // Hide the row
        }
    });
}
</script>


<script src="../js/toggle-darkmode.js"></script>

<style>

</style>

</html>
