<?php   
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

include('../config.php'); // Include the database connection
$username = $_SESSION['username'];

// Fetch employee information
$employeeQuery = "SELECT employee_id, employee_name, position, department_id FROM employee_info";
$employeeResult = mysqli_query($conn, $employeeQuery);

$employees = [];
if ($employeeResult) {
    while ($row = mysqli_fetch_assoc($employeeResult)) {
        $employees[$row['employee_id']] = [
            'employee_name' => $row['employee_name'],
            'position' => $row['position'],
            'department_id' => $row['department_id'],
        ];
    }
} else {
    die("Query failed: " . mysqli_error($conn)); // Handle query failure
}

// Define hourly rates based on positions
$hourly_rates = [
    'HR' => 250,
    'SM' => 250,
    'AF' => 250,
    'FD' => 70,
    'HS' => 64.5,
    'FB' => 64.5,
    'MS' => 64.5,
    'SE' => 64.5,
    'KI' => 64.5,
    'PI' => 64.5,
    'B' => 64.5,
    'ECS' => 64.5,
];

// Deductions
function calculateDeductions($totalPay) {
    $sss = $totalPay * 0.11; // Assuming 11% for SSS
    $philHealth = $totalPay * 0.03; // Assuming 3% for PhilHealth
    $pagIbig = 100; // Fixed amount for Pag-IBIG
    return [
        'sss' => $sss,
        'philhealth' => $philHealth,
        'pagibig' => $pagIbig,
        'total_deductions' => $sss + $philHealth + $pagIbig
    ];
}

$total_hours = 0;
$total_pay = 0;
$attendance_summary = []; // Initialize attendance summary array

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['employee_id'], $_POST['start_date'], $_POST['end_date'])) {
    $employee_id = $_POST['employee_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Fetch attendance data for the selected employee and date range
    $query = "SELECT time_in, time_out, date FROM attendance_log WHERE employee_id = '$employee_id' AND date BETWEEN '$start_date' AND '$end_date'";
    $attendance_result = mysqli_query($conn, $query);

    // Calculate total hours worked and build the attendance summary
    if ($attendance_result) {
        while ($attendance = mysqli_fetch_assoc($attendance_result)) {
            $time_in = strtotime($attendance['time_in']);
            $time_out = strtotime($attendance['time_out']);
            $hours_worked = ($time_out - $time_in) / 3600; // Calculate hours worked

            // Store attendance record
            $attendance_summary[] = [
                'date' => $attendance['date'],
                'time_in' => date('H:i', $time_in),
                'time_out' => date('H:i', $time_out),
                'hours_worked' => number_format($hours_worked, 2)
            ];

            $total_hours += $hours_worked;
        }
    }

    // Calculate total pay based on hours worked and employee's department
    $department_id = $employees[$employee_id]['department_id'];
    if (isset($hourly_rates[$department_id])) {
        $total_pay = $total_hours * $hourly_rates[$department_id];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Employee Form</title>
    <link rel="stylesheet" href="../css/employee_form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>

        .attendance-summary-container {
            background-color: #1e1e1e;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #333;
        }

        th {
            background-color: #2c2c2c;
            color: #00c300;
        }

        tr:hover {
            background-color: #3a3a3a;
        }

        .button {
            background-color: #00c300;
            color: #000;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #00c300;
        }
    </style>
</head>

<body class="light-mode"> <!-- Initially setting light mode -->
    <div class="top-nav">
        <ul>
        <h1 class="logopos">Paradise <br> Hotel</h1><br>
            <li class="top">
                <a class="top1" href="../maindashboard.php">Employee Dashboard</a>
                <div class="top1dropdown">
                    <div class="dropdown-column">
                        <h3>Payroll</h3>
                        <a href="../admin/time-and-attendance-home.php">Time and Attendance</a>
                        <a href="../Employee-information/dashboard2.php">Employee Information</a>
                        <a href="../Employee-information/payroll-processing.php">Payroll Processing</a>
                    </div>           
                    <div class="dropdown-column">
                        <h3>Payroll Settings</h3>
                        <a href="../Employee-information/tax-tables.php">Tax Tables</a>
                        <a href="../Employee-information/overtime-rules.php">Overtime Rules</a>
                        <a href="../Employee-information/payroll-deduction.php">Payroll Deductions</a>
                    </div>          
                    <div class="dropdown-column">
                        <h3>Charts and Graphs</h3>
                        <a href="#">Revenue Trend</a>
                        <a href="#">Profit Margin Trend</a>
                        <a href="#">Cash Flow Chart</a>
                        <a href="#">Financial Ratios Chart</a>
                    </div>

                    <div class="dropdown-column">
                        <h3>Quick Access Links</h3>
                        <a href="#">Frequently Used Reports</a>
                        <a href="#">Recent Transactions</a>
                        <a href="#">Quick Actions</a>
                    </div>            
                </div>
            </li>
            <li class="top">
                <a class="top1" href="#">Employee information</a>
                <div class="top1dropdown">
                    <div class="dropdown-column">
                        <h3><b>Manage Employee</b></h3>
                        <a href="../Employee-information/employee-form.php">Employee Form</a>
                        <a href="../Employee-information/employee-list.php">Employee List</a>
                    </div>
                </div>
            </li>
            <li class="top">
                <a class="top1" href="homeversion2.html">Manage</a>
                <div class="top1dropdown">
                    <div class="dropdown-column">
                        <h3><b>Attendance Tracking</b></h3>
                        <a href="clocking-system.php">Clocking System</a>
                        <a href="timesheet.php">Daily Record</a>
                        <a href="attendance-summary.php">Attendance Summary</a>
                    </div>
                    <div class="dropdown-column">
                        <h3><b>Leave Management</b></h3>
                        <a href="leavemanagement.php">Leave Requests</a>
                        <a href="leave-record.php">Employee Leave Records</a>
                        <a href="leave-type-list.php">List of Leave Types</a>
                    </div>
                    <div class="dropdown-column">
                        <h3><b>Manage Department</b></h3>
                        <a href="department.php">Department</a>

                    </div>
                    <div class="dropdown-column">
                        <h3><b>Shift Management</b></h3>
                        <a href="manage-shift.php">Manage Shift</a>

                    </div>
                    
                </div>
            </li>
            <li class = "top">
                <a class="top1" href="#settings">Settings</a>
                <div class="top1dropdown">
                    <div class="dropdown-column">
                        <h3>General Settings</h3>
                        <a href="#">Company Information</a>
                        <a href="#">Currency Settings</a>
                        <a href="#">Time Zone Settings</a>
                    </div>
                    <div class="dropdown-column">
                        <h3>User Management</h3>
                        <a href="#">User Roles</a>
                        <a href="admin-user-accounts.php">User Accounts</a>
                        <a href="#">Password Management</a>
                        <a href="#">User Permissions</a>
                    </div>
                    <div class="dropdown-column">
                        <h3>Chart of Accounts Settings</h3>
                        <a href="#">Account Structure</a>
                        <a href="#">Account Types</a>
                        <a href="#">Account Templates</a>
                    </div>
                    <div class="dropdown-column">
                        <h3>Inventory Settings</h3>
                        <a href="#">Inventory Valuation Methods</a>
                        <a href="#">Stock Levels:</a>
                        <a href="#">Reorder Points</a>
                    </div>
            </li>
        </ul>

        <!-- Dark mode toggle -->
        <button type="button" id="darkModeToggle" class="dark-mode-toggle" aria-label="Toggle Dark Mode">
            <i class="fas fa-moon"></i>
        </button>

        <!-- USER INFO -->
        <div class="admin-section">
            <div class="admin-name">
                User - <?php echo htmlspecialchars($username); ?>
                <div class="admin-dropdown-content">
                    <a href="../manage_account.php">Manage Account</a>
                </div>
            </div>
        </div>
        <button type="button" class="logout" id="logout-button">
            <i class="fas fa-sign-out-alt"></i>
        </button>
    </div>

    <div class="attendance-summary-container">
        <h2>Attendance Summary</h2>
        <form method="POST">
            <label for="employee_id">Select Employee:</label>
            <select name="employee_id" required>
                <option value="">--Select Employee--</option>
                <?php foreach ($employees as $id => $employee) : ?>
                    <option value="<?= $id ?>"><?= htmlspecialchars($employee['employee_name']) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" required>

            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" required>

            <button type="submit" class="button">Generate Attendance Summary</button>
        </form>

        <form method="POST" action="generate_all_payslips.php">
            <button type="submit" class="button">Generate All Payslips</button>
        </form>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($attendance_summary)) : ?>
            <h3>Attendance Record for <?= htmlspecialchars($employees[$employee_id]['employee_name']) ?></h3>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Hours Worked</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($attendance_summary as $record) : ?>
                        <tr>
                            <td><?= htmlspecialchars($record['date']) ?></td>
                            <td><?= htmlspecialchars($record['time_in']) ?></td>
                            <td><?= htmlspecialchars($record['time_out']) ?></td>
                            <td><?= htmlspecialchars($record['hours_worked']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <h3>Payroll Summary</h3>
            <p>Total Hours Worked: <?php echo number_format($total_hours, 2); ?> hours</p>
            <p>Total Pay: ₱<?php echo number_format($total_pay, 2); ?></p>

            <?php $deductions = calculateDeductions($total_pay); ?>
            <h3>Deductions</h3>
            <p>SSS: ₱<?php echo number_format($deductions['sss'], 2); ?></p>
            <p>PhilHealth: ₱<?php echo number_format($deductions['philhealth'], 2); ?></p>
            <p>Pag-IBIG: ₱<?php echo number_format($deductions['pagibig'], 2); ?></p>
            <p>Total Deductions: ₱<?php echo number_format($deductions['total_deductions'], 2); ?></p>

            <h3>Net Pay</h3>
            <p>₱<?php echo number_format($total_pay - $deductions['total_deductions'], 2); ?></p>

        <?php endif; ?>
    </div>

    <!-- Custom Confirmation Dialog -->
    <div id="dialog-overlay" class="dialog-overlay">
        <div class="dialog-content">
            <h3>Are you sure you want to sign out?</h3>
            <div class="dialog-buttons">
                <button id="confirm-button">Sign Out</button>
                <button class="cancel" id="cancel-button">Cancel</button>
            </div>
        </div>
    </div>
    
</body>
<script src="../js/main-sign-out.js"></script>
<script src="../jsno-previousbutton.js"></script>
<script src="../js/toggle-darkmode.js"></script>
</html>

