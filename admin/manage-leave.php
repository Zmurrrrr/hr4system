<?php
include '../config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

$username = $_SESSION['username'];

// Check if employee_id is set
if (isset($_GET['employee_id'])) {
    $employee_id = $_GET['employee_id'];

    // Fetch specific employee info along with department name using JOIN
    $query = "
        SELECT ei.*, d.department_name 
        FROM employee_info ei
        JOIN departments d ON ei.department_id = d.department_id
        WHERE ei.employee_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch data if available
    $employee_info = $result->fetch_assoc();
    $stmt->close();

    // Fetch allowed and available credits for the employee
    $credits_query = "
        SELECT allowed_credits, available_credits 
        FROM employee_leave 
        WHERE employee_id = ?";
    $credits_stmt = $conn->prepare($credits_query);
    $credits_stmt->bind_param("i", $employee_id);
    $credits_stmt->execute();
    $credits_result = $credits_stmt->get_result();

    // Fetch leave credits if available
    $leave_credits = $credits_result->fetch_assoc();
    $credits_stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Leave - <?php echo htmlspecialchars($employee_info['employee_name'] ?? 'Employee'); ?></title> 
    <link rel="icon" type="image/webp" href="../img/logo.webp">
    <link rel="stylesheet" href="../css/manage_leave.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<main>
    <?php if (isset($employee_info)): ?>
        <div class="employee-info-panel">
            <a href="leave-record.php" class="back-button"><i class="fas fa-arrow-left"></i></a>
            <center><h2>Employee Information</h2><br></center>
            <form class="employee-info-form">
                <div class="form-group">
                    <div class="form-column">
                        <label for="employee_id">Employee ID</label>
                        <input type="text" id="employee_id" value="<?php echo htmlspecialchars($employee_info['employee_id']); ?>" readonly>

                        <label for="employee_name">Employee Name</label>
                        <input type="text" id="employee_name" value="<?php echo htmlspecialchars($employee_info['employee_name']); ?>" readonly>

                        <label for="date_of_birth">Date of Birth</label>
                        <input type="text" id="date_of_birth" value="<?php echo htmlspecialchars($employee_info['date_of_birth']); ?>" readonly>

                        <label for="email_address">Email Address</label>
                        <input type="email" id="email_address" value="<?php echo htmlspecialchars($employee_info['email_address']); ?>" readonly>
                    </div>

                    <div class="form-column">
                        <label for="department">Department</label>
                        <input type="text" id="department" value="<?php echo htmlspecialchars($employee_info['department_name']); ?>" readonly>

                        <label for="position">Position</label>
                        <input type="text" id="position" value="<?php echo htmlspecialchars($employee_info['position']); ?>" readonly>

                        <label for="contact_no">Contact No</label>
                        <input type="text" id="contact_no" value="<?php echo htmlspecialchars($employee_info['contact_no']); ?>" readonly>

                        <label for="address">Address</label>
                        <textarea id="address" readonly><?php echo htmlspecialchars($employee_info['address']); ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="date_hired">Date Hired</label>
                    <input type="text" id="date_hired" value="<?php echo htmlspecialchars($employee_info['date_hired']); ?>" readonly>

                    <label for="status">Status</label>
                    <input type="text" id="status" value="<?php echo htmlspecialchars($employee_info['status']); ?>" readonly>
                </div>
            </form>
        </div>

        <!-- Main Container for Panels -->
        <div class="panels-container">
            <!-- Leave Credits Panel -->
            <div class="leave-credits-panel">
            <h3>Leave Credits</h3>
    <p>Employee ID: <?php echo htmlspecialchars($employee_info['employee_id']); ?></p> <!-- Display Employee ID -->
    <p>Allowed Credits: <?php echo htmlspecialchars($leave_credits['allowed_credits'] ?? 0); ?></p>
    <p>Available Credits: <?php echo htmlspecialchars($leave_credits['available_credits'] ?? 0); ?></p>
            </div>

            <!-- Records Panel (Placeholder) -->
            <div class="records-panel">
                <h3>Records</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Leave Type</th>
                            <th>Date</th>
                            <th>Days</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Sick Leave</td>
                            <td>2024-01-01</td>
                            <td>2</td>
                            <td>Fever</td>
                        </tr>
                        <tr>
                            <td>Vacation Leave</td>
                            <td>2024-01-15</td>
                            <td>5</td>
                            <td>Family Trip</td>
                        </tr>
                        <!-- Add more records as needed -->
                    </tbody>
                </table>
            </div>
        </div>

    <?php else: ?>
        <p>No employee information found.</p>
    <?php endif; ?>
</main>

<footer>
    <p>2024 Leave Management</p>
</footer>
<script src="../js/sign_out.js"></script>

<script src="../js/toggle-darkmode.js"></script>

</body>
</html>
