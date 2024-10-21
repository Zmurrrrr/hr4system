<?php
include 'config.php'; // Include the database connection
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch admin details from the database
$sql = "SELECT * FROM admin_users WHERE admin_username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

$message = ""; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'];
    $new_username = $_POST['admin_username'];
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password']; // New confirmation field

    // Verify the current password with the hashed password in the database
    if (password_verify($current_password, $admin['password'])) {
        // Check if the new password and confirm password match
        if ($new_password === $confirm_password) {
            // Hash the new password
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the admin details in the database
            $update_sql = "UPDATE admin_users SET admin_username = ?, password = ? WHERE admin_username = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("sss", $new_username, $hashed_new_password, $username);

            if ($update_stmt->execute()) {
                // Update session with the new username
                $_SESSION['username'] = $new_username;
                $message = "<span style='color: green;'>Account updated successfully.</span>"; // Success message
            } else {
                $message = "<span style='color: red;'>Error updating account.</span>"; // Error message
            }
        } else {
            $message = "<span style='color: red;'>New password and confirmation do not match.</span>"; // Password mismatch message
        }
    } else {
        // If the current password does not match
        $message = "<span style='color: red;'>Current password is incorrect.</span>"; // Incorrect password message
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/webp" href="img/logo.webp">
    <title>Manage Account</title>
    <link rel="stylesheet" href="css/manage_account.css">
</head>
<body>

<div class="container">
    <h2>Manage Account</h2>

    <form method="POST" action="">
        <label for="admin_username">Admin Username</label>
        <input type="text" id="admin_username" name="admin_username" value="<?php echo htmlspecialchars($admin['admin_username']); ?>" required>
        
        <label for="current_password">Current Password</label>
        <div class="checkbox-container">
            <input type="password" id="current_password" name="current_password" placeholder="Enter current password" required>
            <input type="checkbox" class="show-password" onclick="togglePasswordVisibility('current_password', this)">
        </div>

        <label for="password">New Password</label>
        <div class="checkbox-container">
            <input type="password" id="password" name="password" placeholder="Enter new password" required>
            <input type="checkbox" class="show-password" onclick="togglePasswordVisibility('password', this)">
        </div>

        <label for="confirm_password">Confirm New Password</label>
        <div class="checkbox-container">
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
            <input type="checkbox" class="show-password" onclick="togglePasswordVisibility('confirm_password', this)">
        </div>

        <!-- Display message here -->
        <div class="message"><?php echo $message; ?></div>
        <button type="submit" class="update-btn">Update Account</button>
    </form>

    <!-- New button for adding a new user -->
    <a href="add-user.php" class="add-user-btn">Add New User</a>

    <a href="maindashboard.php" class="back-btn">Back to Dashboard</a>
</div>

<script>
    function togglePasswordVisibility(inputId, checkbox) {
        const inputField = document.getElementById(inputId);
        inputField.type = checkbox.checked ? 'text' : 'password';
    }
</script>

<script src="js/toggle-darkmode.js"></script>
</body>
<style>
  
body.dark-mode {
    background-color:#121212;
    color: rgb(255, 255, 255);
  }



body.dark-mode .container {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background-color: #333;
    color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}</style>
</html>
