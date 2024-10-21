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
    <title>Adherence Monitoring</title>
    <link rel="stylesheet" href="../../css/adherence-monitoring.css">
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

<div class="content">
        <h2>Adherence Monitoring</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Policy Name</th>
                        <th>Adherence Status</th>
                        <th>Last Updated</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Add rows here as needed -->
                </tbody>
            </table>
            <button class="add-report-btn">Add Report</button>
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
