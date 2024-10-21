<?php
include '../config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

// Retrieve form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $leave_id = (int)$_POST['leave_id'];
    $leave_type = $_POST['leave_type'];
    $allowable_credits = (int)$_POST['allowable_credits'];

    // Check for duplicate leave_type
    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM leave_types WHERE leave_type = ? AND leave_id != ?");
    $checkStmt->bind_param("si", $leave_type, $leave_id);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count > 0) {
        $_SESSION['error_message'] = "Error: Leave type '$leave_type' already exists.";
        header("Location: leave-type-list.php");
        exit();
    }

    // Prepare SQL statement to update leave type
    $stmt = $conn->prepare("UPDATE leave_types SET leave_type = ?, allowable_credits = ? WHERE leave_id = ?");
    $stmt->bind_param("sii", $leave_type, $allowable_credits, $leave_id);

    if ($stmt->execute()) {
        // Set success message
        $_SESSION['success_message'] = "Leave type updated successfully.";
    } else {
        // Set error message
        $_SESSION['error_message'] = "Error updating leave type: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

    // Redirect back to the leave type list page
    header("Location: leave-type-list.php");
    exit();
}
?>
