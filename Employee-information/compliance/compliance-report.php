<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compliance Report</title>
    <link rel="stylesheet" href="../../css/compliance-report.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>/* General button styling */
.action-icon {
    background-color: transparent;
    border: none;
    cursor: pointer;
    font-size: 18px; /* Adjust icon size */
    padding: 5px; /* Add some padding */
}

/* Edit button styling */
.edit-icon {
    color: #007bff; /* Blue palette for edit */
}

.edit-icon:hover {
    color: #0056b3; /* Darker blue on hover */
}

/* Delete button styling */
.delete-icon {
    color: #dc3545; /* Red palette for delete */
}

.delete-icon:hover {
    color: #c82333; /* Darker red on hover */
}

/* Optional: Add a slight scale effect on hover for both buttons */
.action-icon:hover {
    transform: scale(1.1); /* Slight zoom effect */
    transition: transform 0.2s ease-in-out; /* Smooth transition */
}


</style>
<body>

<nav class="navbar">
        <div class="logo">Compliance</div>
    </div>
    <ul class="main-menu">
            <li><a href="../dashboard2.php">Dashboard</a></li>
            <li class="dropdown">
            <a href="" class="dropbtn">Employee Information</a>
            <div class="dropdown-content">
            <a href="" class="dropbtn">Employee Information</a>
                <a href="../attendance-summary.php">Employee List</a>
                <a href="../attendance-summary.php">Manage User</a>
                <a href="../attendance-summary.php">Manage Shift</a>
    </div></li>
            <li><a href="../department.php">Department</a></li>
            <li class="dropdown">
            <a href="" class="dropbtn">Compliance and Labor Law Adherence</a>
            <div class="dropdown-content">
                <a href="adherence-monitoring.php">Adherencee Monitoring</a>
                <a href="labor-policies.php">Labor Policies</a>
                <a href="violations.php">Violations</a>
                <a href="compliance-report.php">Compliance Report</a>
    </div></li>
    </ul>
    <div class="admin-section">
        <span class="admin-name">User - <?php echo htmlspecialchars($username); ?></span>
        <a href="" class="sign-out-button" onclick="showDialog(); return false;">Sign Out</a>
    </div>
</nav>

<div class="form container" id="complianceReportSection">
        <div class="table-container">
            <h2>Compliance Report status</h2>
            <table id="reportTable">
                <thead>
                    <tr>
                        <th>Report</th>
                        <th>Time and Date</th>
                        <th>Deadline</th>
                        <th>Submit to</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td contenteditable="true">Monthly Cumulative Report on Road Clearing Operations pursuant to DILG MC No. 2020-121 dtd 29 July 2019 and MC 2019-167 dtd 4 October 2019</td>
                        <td contenteditable="true">7:45 am ,  29 July 2019</td>
                        <td contenteditable="true">Last week of every Month</td>
                        <td contenteditable="true">City Transport and Traffic Management Office (CTTMO)</td>
                        <td>
                    <button class="action-icon edit-icon">
                    <i class="fas fa-edit"></i>
                    </button>
                    <button class="action-icon delete-icon">
                    <i class="fas fa-trash"></i>
                 </button></td>
                    </tr>
                    <tr>
                        <td contenteditable="true">Monthly Report on Beneficiaries/Availees of Financial Assistance (1T1JA) pursuant to DILG MC No. 2020-122 dtd 26 September 2019</td>
                        <td contenteditable="true">2:30 pm, 26 September 2019</td>
                        <td contenteditable="true">Last week of every Month</td>
                        <td contenteditable="true">DILG District Coordinating Offices and City PESO Office</td>
                        <td>
                    <button class="action-icon edit-icon">
                    <i class="fas fa-edit"></i>
                    </button>
                    <button class="action-icon delete-icon">
                    <i class="fas fa-trash"></i>
                 </button></td>
                    </tr>
                    <tr>
                        <td contenteditable="true">Monthly Report on Barangay Assembly for the 2nd Semester pursuant to DILG MC No. 2013-61 dtd 8 July 2013</td>
                        <td contenteditable="true">2:30 pm, 8 July 2018</td>
                        <td contenteditable="true">Last week of every Month</td>
                        <td contenteditable="true">DILG District Coordinating Offices and City PESO Office</td>
                        <td>
                    <button class="action-icon edit-icon">
                    <i class="fas fa-edit"></i>
                    </button>
                    <button class="action-icon delete-icon">
                    <i class="fas fa-trash"></i>
                 </button></td>
                    </tr>
                    <tr>
                        <td contenteditable="true">Violence Against Women and their Children (VAWC) Report pursuant to DILG MC 2004-118</td>
                        <td contenteditable="true">2:30 pm, 19 June 2020</td>
                        <td contenteditable="true">One (1) week before the end of the quarter</td>
                        <td contenteditable="true">DILG District Coordinating Offices and CSWDO</td>
                        <td>
                    <button class="action-icon edit-icon">
                    <i class="fas fa-edit"></i>
                    </button>
                    <button class="action-icon delete-icon">
                    <i class="fas fa-trash"></i>
                 </button></td>
                    </tr>
                    <tr>
                        <td contenteditable="true">Katarungang Pambarangay Compliance Report pursuant to DILG MC No. 1993-93; DILG MC No. 1996-110</td>
                        <td contenteditable="true">2:30 pm, 14 January 2019</td>
                        <td contenteditable="true">One (1) week before the end of the quarter</td>
                        <td contenteditable="true">DILG District Coordinating Offices</td>
                        <td>
                    <button class="action-icon edit-icon">
                    <i class="fas fa-edit"></i>
                    </button>
                    <button class="action-icon delete-icon">
                    <i class="fas fa-trash"></i>
                 </button></td>
                    </tr>
                    <tr>
                        <td contenteditable="true">Barangay Full Disclosure Policy Report pursuant to DILG MC No. 2018-81</td>
                        <td contenteditable="true">8:00 am, 20 August 2018</td>
                        <td contenteditable="true">One (1) week before the end of the quarter</td>
                        <td contenteditable="true">DILG District Coordinating Offices</td>
                        <td>
                    <button class="action-icon edit-icon">
                    <i class="fas fa-edit"></i>
                    </button>
                    <button class="action-icon delete-icon">
                    <i class="fas fa-trash"></i>
                 </button></td>
                    </tr>
                </tbody>
            </table><br>
            <button class="add-button" onclick="addRow()">Add Report</button>
        </div>
    </div> <!-- Close the .form.container div -->
<footer>
    <p>2024 Compliance</p>
</footer>

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

<script src="../../js/sign-out.js"></script>

</body>

</html>