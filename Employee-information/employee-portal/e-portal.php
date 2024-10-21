<?php

include '../../config.php';

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../../index.php");
    exit();
}

$username = $_SESSION['username'];



$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Timesheet</title>
    <link rel="stylesheet" href="../../css/e-portal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>


<body>

<!-- Navigation Bar -->
<nav class="navbar">
    <a href="../../maindashboard.php" class="logo">Employees</a>
    <ul class="main-menu">
        <li><a href="../dashboard2.php">Dashboard</a></li>
        <li class="dropdown">
            <a href="" class="dropbtn">Employee Information</a>
            <div class="dropdown-content">
                <a href="../employee-form.php">Employee Form</a>
                <a href="../employee-list.php">Employee List</a>
                <a href="../manage-user.php">Manage User</a>
                <a href="../manage-shift.php">Manage Shift</a>
            </div>
        </li>
        <li><a href="../department.php">Department</a></li>
        <li class="dropdown">
            <a href="" class="dropbtn">Compliance and Labor Law Adherence</a>
            <div class="dropdown-content">
                <a href="compliance/adherence-monitoring.php">Adherence Monitoring</a>
                <a href="compliance/labor-policies.php">Labor Policies</a>
                <a href="compliance/violations.php">Violations</a>
                <a href="compliance/compliance-report.php">Compliance Report</a>
            </div>
        </li>
    </ul>
    <div class="admin-section">
        <span class="admin-name">User - <?php echo htmlspecialchars($username); ?></span>
        <a href="" class="sign-out-button" onclick="showDialog(); return false;">Sign Out</a>
    </div>
</nav>

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




<script src="../../js/sign-out.js"></script>

<script>

</script>




<style>


</style>
</body>
</html>
