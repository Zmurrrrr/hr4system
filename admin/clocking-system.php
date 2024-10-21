<?php
include '../config.php';
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
    <title>Employee Time Clocking</title>
    <link rel="icon" type="image/webp" href="../img/logo.webp">
    <link rel="stylesheet" href="../css/clocking_system.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    
    <!-- Panel with Employee Information -->
    <div class="container">
        <div id="header">
            <button class="back-button" onclick="window.location.href='time-and-attendance-home.php'">
                <i class="fas fa-arrow-left"></i>
            </button>
        </div>
        <div class="info-panel">
            <h2>Scan QR CODE</h2>
            <hr class="hr"></hr>
            <h4>Stamp the attendance and ensure your working hours are accurately recorded.</h4><br>
            <p><strong>Employee ID:</strong> <span id="employee-id">1001</span></p>
            <p><strong>Employee Name:</strong> <span id="employee-name">Rheniel</span></p>
            <p><strong>Position:</strong> <span id="employee-position">Front Desk</span></p>
            <p><strong>Department:</strong> <span id="employee-department">Hotel</span></p>
        </div>

        <!-- Time Clocking Buttons -->
        <div class="button-panel">
            <button class="time-button" id="time-in">Time In</button>
            <button class="time-button" id="time-out">Time Out</button>
            <button class="time-button" id="overtime-in">Overtime In</button>
            <button class="time-button" id="overtime-out">Overtime Out</button>
        </div>

        <!-- Custom Confirmation Dialog -->
        <div id="dialog-overlay" class="dialog-overlay">
            <div class="dialog-content">
                <h3>Are you sure you want to Log out?</h3>
                <div class="dialog-buttons">
                    <button id="confirm-button">Log Out</button>
                    <button class="cancel" id="dialog-cancel-button">Cancel</button>
                </div>
            </div>
        </div>

        <script src="../js/clocking-system.js"></script>
        <script src="../js/toggle-darkmode.js"></script>
        
        <!-- Footer -->
        
    </div>
    <footer>
            <p>2024 Employee Clocking System</p>
        </footer>
</body>
</html>
