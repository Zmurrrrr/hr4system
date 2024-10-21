<?php
include '../config.php'; // Ensure the path is correct
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../log-in.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch the employee info to be edited based on the ID passed via GET
if (isset($_GET['id'])) {
    $employee_id = intval($_GET['id']);
    
    $sql = "SELECT * FROM employee_info WHERE employee_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $employee = $result->fetch_assoc();
    
    if (!$employee) {
        echo "<script>alert('Employee not found!');</script>";
        header("Location: employee-list.php");
        exit();
    }

    $stmt->close();
} else {
    header("Location: employee-list.php");
    exit();
}

// Handle form submission for updates
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = intval($_POST['employee-id']);
    $first_name = htmlspecialchars($_POST['first-name']);
    $middle_name = htmlspecialchars($_POST['middle-name']);
    $last_name = htmlspecialchars($_POST['last-name']);
    $employee_name = trim("$first_name $middle_name $last_name");
    $department = htmlspecialchars($_POST['department']);
    $job_title = htmlspecialchars($_POST['job-title']);
    $dob = $_POST['dob'];
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $address = htmlspecialchars($_POST['address']);
    $date_hire = $_POST['date-hire'];
    $employment_status = htmlspecialchars($_POST['employment-status']);

    // Update employee information
    $sql = "UPDATE employee_info SET employee_name = ?, department = ?, position = ?, date_of_birth = ?, contact_no = ?, email_address = ?, address = ?, date_hired = ?, status = ? WHERE employee_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssi", $employee_name, $department, $job_title, $dob, $phone, $email, $address, $date_hire, $employment_status, $employee_id);

    if ($stmt->execute()) {
        echo "<script>alert('Employee information updated successfully!');</script>";
        header("Location: employee-list.php");
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
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
    <title>Edit Employee</title>
    <link rel="stylesheet" href="../css/employee-form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .content {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: #d4d4d4;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        label {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            width: 25%;
            padding-right: 10px;
        }

        input, select, textarea {
            width: 70%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            color: #333;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #555;
            outline: none;
            box-shadow: 0 0 5px rgba(85, 85, 85, 0.5);
        }

        button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="logo">Edit Employee</div>
        <ul class="main-menu">
            <li><a href="dashboard2.php">Dashboard</a></li>
            <li class="dropdown">
                <a href="" class="dropbtn">Employee Information</a>
                <div class="dropdown-content">
                    <a href="employee-form.php">Employee Form</a>
                    <a href="employee-list.php">Employee List</a>
                    <a href="manage-user.php">Manage User</a>
                    <a href="manage-shift.php">Manage Shift</a>
                </div>
            </li>
            <li><a href="department.php">Department</a></li>
        </ul>
        <div class="admin-section">
            <span class="admin-name">User - <?php echo htmlspecialchars($username); ?></span>
            <a href="#" class="sign-out-button" onclick="showDialog(); return false;">Sign Out</a>
        </div>
    </nav>

    <div class="content">
        <h2>Edit Employee Information</h2>
        <form id="edit-employee-form" method="post">
            <div class="form-group">
                <label for="employee-id">Employee ID:</label>
                <input type="number" id="employee-id" name="employee-id" value="<?php echo $employee['employee_id']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="first-name">First Name:</label>
                <input type="text" id="first-name" name="first-name" value="<?php echo htmlspecialchars($employee['first_name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="middle-name">Middle Name:</label>
                <input type="text" id="middle-name" name="middle-name" value="<?php echo htmlspecialchars($employee['middle_name']); ?>">
            </div>

            <div class="form-group">
                <label for="last-name">Last Name:</label>
                <input type="text" id="last-name" name="last-name" value="<?php echo htmlspecialchars($employee['last_name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="department">Department:</label>
                <input type="text" id="department" name="department" value="<?php echo htmlspecialchars($employee['department']); ?>" required>
            </div>

            <div class="form-group">
                <label for="job-title">Job Title/Position:</label>
                <input type="text" id="job-title" name="job-title" value="<?php echo htmlspecialchars($employee['position']); ?>" required>
            </div>

            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" value="<?php echo $employee['date_of_birth']; ?>" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($employee['contact_no']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($employee['email_address']); ?>" required>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <textarea id="address" name="address" rows="2" required><?php echo htmlspecialchars($employee['address']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="date-hire">Date of Hire:</label>
                <input type="date" id="date-hire" name="date-hire" value="<?php echo $employee['date_hired']; ?>" required>
            </div>

            <div class="form-group">
                <label for="employment-status">Employment Status:</label>
                <select id="employment-status" name="employment-status" required>
                    <option value="" disabled>Select Employment Status</option>
                    <option value="Full-time" <?php if ($employee['status'] == 'Full-time') echo 'selected'; ?>>Full-time</option>
                    <option value="Part-time" <?php if ($employee['status'] == 'Part-time') echo 'selected'; ?>>Part-time</option>
                    <option value="Contractual" <?php if ($employee['status'] == 'Contractual') echo 'selected'; ?>>Contractual</option>
                </select>
            </div>

            <button type="submit">Update Employee Information</button>
        </form>
    </div>
</body>
</html>
