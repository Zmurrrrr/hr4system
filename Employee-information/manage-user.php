<?php

require '../config.php'; // Include the database connection
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../../index.php");
    exit();
}

$username = $_SESSION['username'];



// Fetch employee information
$sql = "SELECT employee_id, employee_name, department, position FROM employee_info";
$result = $conn->query($sql);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="../css/manage-user.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Include Font Awesome -->
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="logo">Manage User</div>
        <ul class="main-menu">
            <li><a href="dashboard2.php">Dashboard</a></li>
            <li class="dropdown">
                <a href="" class="dropbtn">Employee Information</a>
                <div class="dropdown-content">
                    <a href="employee-form.php">Employee Form</a>
                    <a href="employee-list.php">Employee List</a>
                    <a href="manage-user.php">Manage User</a>
                    <a href="manage-shift.php">Manage Shift</a>
                </div>
            </li>
            <li><a href="department.php">Department</a></li>
        </ul>
        <div class="admin-section">
            <span class="admin-name">User - <?php echo htmlspecialchars($username); ?></span>
            <a href="#" class="sign-out-button" onclick="showDialog(); return false;">Sign Out</a>
        </div>
    </nav>

    <!-- Manage User Table -->
    <div class="container">
        <h2>Manage Users</h2>
        <table>
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th>Credentials</th>

                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['employee_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['employee_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['department']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['position']) . "</td>";
                        echo "<td><button class='settings-button' onclick='location.href=\"employee-portal/manage-credentials.php?employee_id=" . htmlspecialchars($row['employee_id']) . "\";'><i class='fas fa-cog'></i></button></td>"; // Button with gear icon
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No employees found.</td></tr>"; // Update column span to 5
                }
                ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>2024 Employee Management</p>
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

    <script src="../js/sign-out.js"></script>
</body>
<style>
.settings-button {
    background-color: transparent; /* No background */
    border: none; /* No border */
    cursor: pointer; /* Pointer cursor on hover */
    outline: none; /* No outline */
    padding: 10px; /* Padding around the icon */
    transition: color 0.3s; /* Smooth color transition */
}

.settings-button i {
    color: #555; /* Default icon color */
    font-size: 20px; /* Icon size */
}

.settings-button:hover i {
    color: #007BFF; /* Color change on hover */
}
</style>
</html>
