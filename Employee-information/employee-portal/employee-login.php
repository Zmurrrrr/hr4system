<?php

require '../../config.php'; // Include the database connection

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employeeid'];
    $password = $_POST['password'];

    // Query to check if employee_id exists
    $sql = "SELECT * FROM employee_users WHERE employee_id = '$employee_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $row['password'])) {
            // Store employee ID in session
            $_SESSION['employee_id'] = $employee_id;
            header("Location: clocking-system.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Employee ID not found.";
    }
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/employee-login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <h2>Employee Login</h2>
        <form method="POST">
            <input type="text" name="employeeid" placeholder="Employee ID" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
        <?php if ($error): ?>
            <p class="message <?php echo $error_class; ?>"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <p><a href="employee-register.php">Don't have an account? Register</a></p>
    </div>

    

    <script src="js/log-in.js"></script>
</body>
<style>
.message.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}</style>
</html>
