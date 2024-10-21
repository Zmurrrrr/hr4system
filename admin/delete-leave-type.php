<?php
include '../config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['leave_id'])) {
    $leaveId = intval($_GET['leave_id']);

    // Delete the leave type from the database
    $queryDelete = "DELETE FROM leave_types WHERE leave_id = ?";
    $stmt = $conn->prepare($queryDelete);
    $stmt->bind_param("i", $leaveId);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Leave type deleted successfully.";
    } else {
        $_SESSION['error_message'] = "Error deleting leave type: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
header("Location: leave-type-list.php"); // Redirect back to the list
exit();
?>
