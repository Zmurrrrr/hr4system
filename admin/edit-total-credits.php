<?php
include '../config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get total credits from the form
    $totalCredits = $_POST['total_credits'];

    // Update total leave credits in the database
    $updateQuery = "UPDATE leave_types SET totalleave_credits = ?"; // Adjust according to your table structure
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $totalCredits);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Total leave credits updated successfully.";
    } else {
        $_SESSION['error_message'] = "Error updating total leave credits: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    // Redirect back to the leave type list page
    header("Location: leave-type-list.php");
    exit();
}
