<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Violations</title>
    <link rel="stylesheet" href="../../css/violations.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<nav class="navbar">
        <div class="logo">Compliance</div>
    </div>
    <ul class="main-menu">
            <li><a href="../dashboard2.php">Dashboard</a></li>
            <li class="dropdown">
            <a href="" class="dropbtn">Employee Information</a>
            <div class="dropdown-content">
            <a href="" class="dropbtn">Employee Information</a>
                <a href="../attendance-summary.php">Employee List</a>
                <a href="../attendance-summary.php">Manage User</a>
                <a href="../attendance-summary.php">Manage Shift</a>
    </div></li>
            <li><a href="../department.php">Department</a></li>
            <li class="dropdown">
            <a href="" class="dropbtn">Compliance and Labor Law Adherence</a>
            <div class="dropdown-content">
                <a href="adherence-monitoring.php">Adherencee Monitoring</a>
                <a href="labor-policies.php">Labor Policies</a>
                <a href="violations.php">Violations</a>
                <a href="compliance-report.php">Compliance Report</a>
    </div></li>
    </ul>
    <div class="admin-section">
        <span class="admin-name">User - <?php echo htmlspecialchars($username); ?></span>
        <a href="" class="sign-out-button" onclick="showDialog(); return false;">Sign Out</a>
    </div>
</nav>
<br>
<div class="form-container">
            <h2>Add New Violation Record</h2>
            <label for="employee-name">Employee Name:</label>
            <input type="text" id="employee-name" placeholder="Enter employee Name">
           

            <label for="violation-type">Violation Type:</label>
            <input type="text" id="violation-type" placeholder="Enter violation type">
        
            <label for="description">Description:</label>
            <textarea id="description" placeholder="Enter violation description"></textarea>

            <label for="date">Date:</label>
            <input type="date" id="violation-date">
            
            <button>Add Record</button>
        </div>

        <div class="table-container">
            <h2>Violation Records</h2>
            <table>
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Violation Type</th>
                        <th>Description</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <!-- example violations -->
                <tbody id="violationsTableBody">
                    <tr>
                        <td>Johan Dale</td>
                        <td>Late arrival</td>
                        <td>Employee X arrived 30 minutes late to their shift.</td>
                        <td>2022-01-01</td>
                    </tr>
                    <!-- Add more rows here -->
                </tbody>
            </table>
        </div>
    </div>
<footer>
    <p>2024 Compliance</p>
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

<script src="../../js/sign-out.js"></script>

</body>

</html>
