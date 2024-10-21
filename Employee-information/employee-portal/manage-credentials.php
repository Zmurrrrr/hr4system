<?php
require '../../config.php'; // Include the database connection
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../../index.php");
    exit();
}

$username = $_SESSION['username'];

// Get the employee ID from the URL
if (isset($_GET['employee_id'])) {
    $employee_id = htmlspecialchars($_GET['employee_id']);
} else {
    header("Location: manage-user.php");
    exit();
}

// Fetch employee credentials (including employee name, department, and position)
$employee_credentials = null;
$fetch_sql = "
    SELECT 
        e.employee_id, 
        e.employee_name, 
        e.department, 
        e.position 
    FROM employee_info e 
    WHERE e.employee_id = ?
";
$fetch_stmt = $conn->prepare($fetch_sql);
$fetch_stmt->bind_param("s", $employee_id);
$fetch_stmt->execute();
$fetch_result = $fetch_stmt->get_result();

if ($fetch_result->num_rows > 0) {
    $employee_credentials = $fetch_result->fetch_assoc();
}

// Initialize success and error messages
$success_message = '';
$error_message = '';

// Handle form submission for generating a new password
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = htmlspecialchars($_POST['employee_id']);
    
    // Check if user already exists
    $check_sql = "SELECT * FROM employee_users WHERE employee_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $employee_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Generate a random password
        $generated_password = bin2hex(random_bytes(8)); // Generates a random password of 16 characters
        
        // Hash the generated password
        $hashed_password = password_hash($generated_password, PASSWORD_DEFAULT);

        // Update the password in employee_users table
        $sql = "UPDATE employee_users SET password = ? WHERE employee_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $hashed_password, $employee_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Store the generated password in a session variable
            $_SESSION['generated_password'] = $generated_password;
            $success_message = "New password generated successfully.";

            // Refresh employee credentials after update
            $employee_credentials = [
                'employee_id' => $employee_id, 
                'employee_name' => $employee_credentials['employee_name'], 
                'department' => $employee_credentials['department'], 
                'position' => $employee_credentials['position']
            ]; // Update the displayed credentials
        } else {
            $error_message = "Error updating password: " . $conn->error;
        }

        $stmt->close();
    } else {
        $error_message = "User with Employee ID: $employee_id does not exist.";
    }

    $check_stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credentials of Employee: <?php echo htmlspecialchars($employee_credentials['employee_name'] ?? ''); ?></title>
    <link rel="stylesheet" href="../../css/manage-user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .container {
            max-width: 600px;
            margin-top: 100px;
            background-color: #d4d4d4;
            border-radius: 10px;
            padding: 20px;
        }
        .credentials-panel {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .credentials-panel h3 {
            color: #333;
            margin: 0 0 10px 0;
        }
        .credentials-grid {
            display: flex;
            justify-content: space-between;
        }
        .credentials-panel .left-side, .credentials-panel .right-side {
            width: 48%;
        }
        .credentials-panel p {
            color: #222;
            margin: 5px 0;
        }
        .container form {
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-top: 20px;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
        }
        .container form button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            margin-right: 10px;
        }
        .container form button:hover {
            background-color: #0056b3;
        }
        .success-message,
        .error-message {
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .header-container h2 {
            flex-grow: 1;
            text-align: center;
            margin: 0;
        }
        .back-button {
            display: inline-flex;
            align-items: center;
            margin-right: 15px;
            background-color: transparent;
            color: #555;
            margin-left: 5px;
            text-decoration: none;
            font-size: 20px;
            cursor: pointer;
            transition: color 0.3s;
        }
        .back-button i {
            margin-right: 5px;
        }
        .back-button:hover {
            color: #555;
        }
        footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
        <div class="header-container">
            <a href="../manage-user.php" class="back-button" title="Go Back">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2>Employee: <?php echo htmlspecialchars($employee_credentials['employee_name'] ?? ''); ?></h2>
        </div>

        <?php if (!empty($success_message)): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if ($employee_credentials): ?>
            <div class="credentials-panel">
                <h3>Employee Credentials</h3><hr><br>
                <div class="credentials-grid">
                    <div class="left-side">
                        <p><strong>Employee ID:</strong> <?php echo htmlspecialchars($employee_credentials['employee_id']); ?></p>
                        <p><strong>Password:</strong> <?php echo isset($_SESSION['generated_password']) ? htmlspecialchars($_SESSION['generated_password']) : 'N/A'; ?></p>
                    </div>
                    <div class="right-side">
                        <p><strong>Department:</strong> <?php echo htmlspecialchars($employee_credentials['department']); ?></p>
                        <p><strong>Position:</strong> <?php echo htmlspecialchars($employee_credentials['position']); ?></p>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="credentials-panel">
                <h3>No Credentials Found</h3>
                <p>No user exists for this Employee ID.</p>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <input type="hidden" name="employee_id" value="<?php echo htmlspecialchars($employee_id); ?>">
            <div class="button-container">
                <button type="submit">Generate New Password</button>
            </div>
        </form>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Your Company Name</p>
    </footer>

</body>
</html>
