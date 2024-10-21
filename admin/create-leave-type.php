<?php
include '../config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from POST request
    $leave_id = $_POST['leave_id'];
    $leave_type = $_POST['leave_type'];

    // Check if the combination of leave_id and leave_type already exists
    $stmt = $conn->prepare("SELECT leave_id, leave_type FROM leave_types WHERE leave_id = ? OR leave_type = ?");
    $stmt->bind_param("is", $leave_id, $leave_type);
    $stmt->execute();
    $stmt->store_result();
    
    // Check if there are any duplicates
    if ($stmt->num_rows > 0) {
        // Fetch the duplicate records
        $stmt->bind_result($existing_leave_id, $existing_leave_type);
        $duplicates = [];
        while ($stmt->fetch()) {
            $duplicates[] = "Leave ID: $existing_leave_id, Leave Type: $existing_leave_type";
        }
        // Create a detailed error message
        $_SESSION['error_message'] = "Duplicate values found: " . implode(", ", $duplicates) . ". Please use different values.";
    } else {
        // Prepare an SQL statement for insertion
        $stmt->close(); // Close the previous statement before preparing a new one
        $stmt = $conn->prepare("INSERT INTO leave_types (leave_id, leave_type) VALUES (?, ?)");
        $stmt->bind_param("is", $leave_id, $leave_type);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Leave type created successfully.";
        } else {
            $_SESSION['error_message'] = "Error creating leave type: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();

    // Redirect back to leave type list
    header("Location: leave-type-list.php");
    exit();
}
?>
