<?php
require 'config.php'; // Include the database connection

session_start();

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_username = $_POST['username']; // Match the username input field
    $password = $_POST['password']; // Get the password from the form

    // Updated SQL query to match the admin_users table
    $sql = "SELECT * FROM admin_users WHERE admin_username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $admin_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password using password_verify function
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $admin_username; // Store username in session
            $_SESSION['user_id'] = $row['id']; // Store user ID in session
            header("Location: maindashboard.php"); // Redirect to the dashboard
            exit();
        } else {
            $error = 'Invalid username or password'; // Incorrect password
        }
    } else {
        $error = 'Invalid username or password'; // No user found
    }

    $stmt->close();
}

$conn->close();
?>



  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/webp" href="img/logo.webp">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Login</title>
</head>

<body class="light-mode"> <!-- Initially setting light mode -->
    <div class="container">
    <div class="logo-container">
            <img src="img/logo.webp" class="plogo" alt="Paradise Hotel Logo">
        </div>
        <h2>Login</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <div class="password-container">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <label>
                    <input type="checkbox" id="showPassword"></label>
            </div>
            <input type="submit" value="Login">
        </form>
    </div>


    <!-- Popup for Error Message -->
    <?php if ($error): ?>
    <div id="popup" class="popup show">
        <div class="popup-content">
            <p><?php echo $error; ?></p>
            <center><button class="close" id="closePopupButton">Close</button></center>
        </div>
    </div>
    <?php endif; ?>

    <script src="js/log-in.js"></script>
    <script>
        // JavaScript to toggle password visibility
        document.getElementById('showPassword').addEventListener('change', function() {
            const passwordField = document.getElementById('password');
            passwordField.type = this.checked ? 'text' : 'password';
        });
    </script>
    <script src="js/toggle-darkmode.js"></script>

</body>

</html>

