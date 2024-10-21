<?php
include '../config.php'; // Include your database connection file
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

// Initialize variables to store form data
$employee_id = $_POST['employee_id'];
$leave_type = $_POST['leave_type'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$total_days = $_POST['total_days'];
$status = $_POST['status'];
$remarks = $_POST['remarks'];

// Prepare an SQL statement to insert the leave request
$sql = "INSERT INTO employee_leave_requests (employee_id, leave_id, start_date, end_date, total_days, status, remarks) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    // Bind parameters
    $stmt->bind_param("iississ", $employee_id, $leave_type, $start_date, $end_date, $total_days, $status, $remarks);

    // Execute the statement
    if ($stmt->execute()) {
        // Success message or redirect to a success page
        echo "<script>alert('Leave request submitted successfully!'); window.location.href='leavemanagement.php';</script>";
    } else {
        // Error handling
        echo "<script>alert('Error submitting leave request. Please try again.'); window.history.back();</script>";
    }

    // Close the statement
    $stmt->close();
} else {
    // Error handling
    echo "<script>alert('Error preparing SQL statement.'); window.history.back();</script>";
}

// Close the database connection
$conn->close();
?>
