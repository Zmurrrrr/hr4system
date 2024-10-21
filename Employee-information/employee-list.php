<?php

include '../config.php';

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch employee data
// Fetch employee data along with department names
$sql = "SELECT employee_info.*, departments.department_name 
        FROM employee_info 
        JOIN departments ON employee_info.department_id = departments.department_id";
$result = $conn->query($sql);

// Fetch departments from the database
$departments = [];
$department_sql = "SELECT department_name FROM departments"; // Adjust this query based on your actual table structure
$department_result = $conn->query($department_sql);

if ($department_result->num_rows > 0) {
    while ($row = $department_result->fetch_assoc()) {
        $departments[] = $row['department_name'];
    }
}


// Handle edit request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['employee_id'])) {
    $employee_id = intval($_POST['employee_id']); // Ensure this is an integer
    $employee_name = $_POST['employee_name'];
    $department = $_POST['department'];
    $position = $_POST['position'];
    $date_of_birth = $_POST['date_of_birth'];
    $contact_no = $_POST['contact_no'];
    $email_address = $_POST['email_address'];
    $address = $_POST['address'];
    $date_hired = $_POST['date_hired'];
    $status = $_POST['status'];

    // Update employee_info table
    $update_sql = "UPDATE employee_info 
    SET employee_name = ?, 
        department_id = (SELECT department_id FROM departments WHERE department_name = ?), 
        position = ?, 
        date_of_birth = ?, 
        contact_no = ?, 
        email_address = ?, 
        address = ?, 
        date_hired = ?, 
        status = ? 
    WHERE employee_id = ?";
$stmt = $conn->prepare($update_sql);

// Corrected type definition to "sssssssssi" (9 s + 1 i)
$stmt->bind_param("sssssssssi", $employee_name, $department, $position, $date_of_birth, $contact_no, $email_address, $address, $date_hired, $status, $employee_id);


    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Employee updated successfully!";
    } else {
        $_SESSION['success_message'] = "Error: " . $stmt->error;
    }

    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit(); // Ensure no further code is executed after the redirect
}


// Handle delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $employee_id = intval($_POST['delete_id']); // Ensure this is an integer

    // Delete from employee_info table
    $delete_sql = "DELETE FROM employee_info WHERE employee_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $employee_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Employee deleted successfully!";
    } else {
        $_SESSION['success_message'] = "Error: " . $stmt->error;
    }

    $stmt->close();
    
    // Redirect to the same page to refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit(); // Ensure no further code is executed after the redirect
}


$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Timesheet</title>
    <link rel="stylesheet" href="../css/employee_list.css">
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

<!-- Employee List Table -->
<div class="employee-list-container"><br>
    <h2>Employee List</h2>
    <div class="search-sort-container">
    <div class="sort-by">
        <label for="sort">Sort by:</label>
        <select id="sort" onchange="sortTable()">
            <option value="id">Employee ID</option>
            <option value="name_asc">Employee Name A-Z</option>
            <option value="name_desc">Employee Name Z-A</option>
        </select>
    </div>
    <div class="search-bar">
        <input type="text" id="search" placeholder="Search..." onkeyup="searchTable()">
    </div>
</div>


    <table class="employee-table" id="employeeTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Employee Name</th>
                <th>Department</th>
                <th>Position</th>
                <th>Date of Birth</th>
                <th>Contact No.</th>
                <th>Email Address</th>
                <th>Address</th>
                <th>Date Hired</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
    <?php
    // Check if there are results and display them
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['employee_id']) . "</td>
                    <td>" . htmlspecialchars($row['employee_name']) . "</td>
                    <td>" . htmlspecialchars($row['department_name']) . "</td> <!-- Displaying department_name instead of department -->
                    <td>" . htmlspecialchars($row['position']) . "</td>
                    <td>" . htmlspecialchars($row['date_of_birth']) . "</td>
                    <td>" . htmlspecialchars($row['contact_no']) . "</td>
                    <td>" . htmlspecialchars($row['email_address']) . "</td>
                    <td>" . htmlspecialchars($row['address']) . "</td>
                    <td>" . htmlspecialchars($row['date_hired']) . "</td>
                    <td>" . htmlspecialchars($row['status']) . "</td>
                    <td>
                        <button class='action-icon edit-icon' onclick='openEditOverlay(" . htmlspecialchars($row['employee_id']) . ", \"" . htmlspecialchars($row['employee_name']) . "\", \"" . htmlspecialchars($row['department_name']) . "\", \"" . htmlspecialchars($row['position']) . "\", \"" . htmlspecialchars($row['date_of_birth']) . "\", \"" . htmlspecialchars($row['contact_no']) . "\", \"" . htmlspecialchars($row['email_address']) . "\", \"" . htmlspecialchars($row['address']) . "\", \"" . htmlspecialchars($row['date_hired']) . "\", \"" . htmlspecialchars($row['status']) . "\")'><i class='fas fa-edit'></i></button>
                        <button class='action-icon delete-icon' onclick='openDeleteConfirmation(" . htmlspecialchars($row['employee_id']) . ", \"" . htmlspecialchars($row['employee_name']) . "\")'><i class='fas fa-trash'></i></button>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='11'>No employees found.</td></tr>";
    }
    ?>
</tbody>

    </table>

    <?php
    // Display the message below the table
    if (isset($_SESSION['success_message'])) {
        echo "<div class='message'>" . htmlspecialchars($_SESSION['success_message']) . "</div>";
        unset($_SESSION['success_message']); // Clear the message after displaying
    }
    ?>

</div>

<!-- Edit Employee Overlay -->
<div id="edit-overlay" class="dialog-overlay">
    <div class="edialog-content">
        <h3>Edit Employee</h3>
        <form id="edit-form" method="POST" action="">
            <input type="hidden" name="employee_id" id="employee_id" value="">
            
            <div class="form-group">
                <label for="employee_name">Employee Name:</label>
                <input type="text" name="employee_name" id="employee_name" required class="form-input">
            </div>
            
            <div class="form-group">
                <label for="department">Department:</label>
                <select name="department" id="department" required class="form-input">
                    <option value="" disabled>Select Department</option>
                    <?php foreach ($departments as $dept): ?>
                        <option value="<?php echo htmlspecialchars($dept); ?>"><?php echo htmlspecialchars($dept); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="position">Position:</label>
                <input type="text" name="position" id="position" required class="form-input">
            </div>

            <div class="form-group">
                <label for="date_of_birth">Date of Birth:</label>
                <input type="date" name="date_of_birth" id="date_of_birth" required class="form-input">
            </div>

            <div class="form-group">
                <label for="contact_no">Contact No:</label>
                <input type="text" name="contact_no" id="contact_no" required class="form-input">
            </div>

            <div class="form-group">
                <label for="email_address">Email Address:</label>
                <input type="email" name="email_address" id="email_address" required class="form-input">
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" name="address" id="address" required class="form-input">
            </div>

            <div class="form-group">
                <label for="date_hired">Date Hired:</label>
                <input type="date" name="date_hired" id="date_hired" required class="form-input">
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <input type="text" name="status" id="status" required class="form-input">
            </div>

            <div class="button-container">
                <button type="submit" class="submit-btn">Save Changes</button>
                <button type="button" class="cancel" onclick="closeEditOverlay()">Cancel</button>
            </div>
        </form>
    </div>
</div>





<script src="../js/sign-out.js"></script>

<script>

function openEditOverlay(employee_id, name, department, position, dob, contact, email, address, dateHired, status) {
    document.getElementById('employee_id').value = employee_id;
    document.getElementById('employee_name').value = name;
    document.getElementById('department').value = department; // Set the selected department
    document.getElementById('position').value = position;
    document.getElementById('date_of_birth').value = dob;
    document.getElementById('contact_no').value = contact;
    document.getElementById('email_address').value = email;
    document.getElementById('address').value = address;
    document.getElementById('date_hired').value = dateHired;
    document.getElementById('status').value = status;

    document.getElementById('edit-overlay').style.display = 'block';
}

function closeEditOverlay() {
    document.getElementById('edit-overlay').style.display = 'none';
}

</script>

<script>
function openDeleteConfirmation(employee_id, name) {
    const confirmationDialog = document.getElementById('delete-confirmation-dialog');
    const deleteIdInput = document.getElementById('delete-id');
    const employeeNameSpan = document.getElementById('employee-name-to-delete');
    
    deleteIdInput.value = employee_id;
    employeeNameSpan.textContent = name;

    confirmationDialog.style.display = 'block';
}

function closeDeleteConfirmation() {
    document.getElementById('delete-confirmation-dialog').style.display = 'none';
}

function searchTable() {
    const input = document.getElementById("search");
    const filter = input.value.toLowerCase();
    const table = document.getElementById("employeeTable");
    const rows = table.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) { // Start from 1 to skip the header row
        const cells = rows[i].getElementsByTagName("td");
        let match = false;

        // Check all columns for a match
        for (let j = 0; j < cells.length; j++) { // Check all columns
            if (cells[j].textContent.toLowerCase().includes(filter)) {
                match = true;
                break;
            }
        }
        rows[i].style.display = match ? "" : "none"; // Show or hide the row
    }
}


function sortTable() {
    const table = document.getElementById("employeeTable");
    const rows = Array.from(table.rows).slice(1); // Get all rows except the header
    const sortCriteria = document.getElementById("sort").value;

    rows.sort((a, b) => {
        let aValue, bValue;

        switch (sortCriteria) {
            case 'id':
                aValue = parseInt(a.cells[0].textContent); // Employee ID
                bValue = parseInt(b.cells[0].textContent);
                return aValue - bValue; // Sort numerically
            case 'name_asc':
                aValue = a.cells[1].textContent.toLowerCase(); // Employee Name
                bValue = b.cells[1].textContent.toLowerCase();
                return aValue.localeCompare(bValue); // Sort alphabetically A-Z
            case 'name_desc':
                aValue = a.cells[1].textContent.toLowerCase(); // Employee Name
                bValue = b.cells[1].textContent.toLowerCase();
                return bValue.localeCompare(aValue); // Sort alphabetically Z-A
            default:
                return 0; // No sorting
        }
    });

    // Append the sorted rows back to the table body
    const tbody = table.querySelector('tbody');
    tbody.innerHTML = ''; // Clear existing rows
    rows.forEach(row => tbody.appendChild(row)); // Append sorted rows
}


</script>

<footer>
    <p>2024 Employee Information</p>

</footer>

<!-- Custom Confirmation Dialog -->
<div id="dialog-overlay" class="sdialog-overlay">
        <div class="sdialog-content">
            <h3>Are you sure you want to sign out?</h3>
            <div class="dialog-buttons">
                <button id="confirm-button">Sign Out</button>
                <button class="cancel" id="cancel-button">Cancel</button>
            </div>
        </div>
    </div>   
<!-- Delete Confirmation Dialog -->
<div id="delete-confirmation-dialog" class="dialog-overlay1">
    <div class="dialog-content1">
        <h3>Are you sure you want to permanently delete<br> <span id="employee-name-to-delete"></span> information?</h3>
        <form id="delete-form" method="POST" action="">
            <input type="hidden" name="delete_id" id="delete-id" value="">
            <div class="button-container">
    <button type="submit" class="submit-btn">Yes</button>
    <button type="button" class="cancel" onclick="closeDeleteConfirmation()">No</button>
</div>

        </form>
    </div>
</div>

<script src="../js/main-sign-out.js"></script>
<script src="../jsno-previousbutton.js"></script>
<script src="../js/toggle-darkmode.js"></script>
</body>
</html>
