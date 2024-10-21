<?php
session_start();
include('../config.php');

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

// Create the payslips directory if it doesn't exist
$directory = 'payslips';
if (!is_dir($directory)) {
    mkdir($directory, 0777, true); // Create directory if it doesn't exist
}

// Create a new ZIP file
$zipFilename = 'payslips/payslips.zip';
$zip = new ZipArchive();
if ($zip->open($zipFilename, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
    exit("Cannot open <$zipFilename>\n");
}

// Fetch all employees
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
}

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

require('fpdf.php');

foreach ($employees as $employee_id => $employee) {
    // Fetch attendance data for the employee
    $query = "SELECT time_in, time_out, date FROM attendance_log WHERE employee_id = '$employee_id'";
    $attendance_result = mysqli_query($conn, $query);

    $total_hours = 0;
    $attendance_summary = [];

    if ($attendance_result) {
        while ($attendance = mysqli_fetch_assoc($attendance_result)) {
            $time_in = strtotime($attendance['time_in']);
            $time_out = strtotime($attendance['time_out']);
            $hours_worked = ($time_out - $time_in) / 3600;

            $attendance_summary[] = [
                'date' => $attendance['date'],
                'time_in' => date('H:i', $time_in),
                'time_out' => date('H:i', $time_out),
                'hours_worked' => number_format($hours_worked, 2)
            ];

            $total_hours += $hours_worked;
        }
    }

    // Calculate total pay based on hours worked
    $department_id = $employee['department_id'];
    $total_pay = isset($hourly_rates[$department_id]) ? $total_hours * $hourly_rates[$department_id] : 0;

    // Calculate deductions
    $deductions = calculateDeductions($total_pay);

    // Create PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Paradise Hotel Payslip', 0, 1, 'C');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Employee Name: ' . $employee['employee_name'], 0, 1);
    $pdf->Cell(0, 10, 'Position: ' . $employee['position'], 0, 1);
    $pdf->Cell(0, 10, 'Employee ID: ' . $employee_id, 0, 1);
    $pdf->Cell(0, 10, 'Generated On: ' . date('Y-m-d H:i:s'), 0, 1);

    // Attendance Summary Table
    $pdf->Cell(0, 10, 'Attendance Summary', 0, 1);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(30, 10, 'Date', 1);
    $pdf->Cell(30, 10, 'Time In', 1);
    $pdf->Cell(30, 10, 'Time Out', 1);
    $pdf->Cell(30, 10, 'Hours Worked', 1);
    $pdf->Ln();
    foreach ($attendance_summary as $record) {
        $pdf->Cell(30, 10, $record['date'], 1);
        $pdf->Cell(30, 10, $record['time_in'], 1);
        $pdf->Cell(30, 10, $record['time_out'], 1);
        $pdf->Cell(30, 10, $record['hours_worked'], 1);
        $pdf->Ln();
    }

    // Earnings Section
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Earnings', 0, 1);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 10, 'Total Hours Worked: ' . number_format($total_hours, 2), 0, 1);
    $pdf->Cell(0, 10, 'Total Pay: ' . number_format($total_pay, 2) . ' pesos', 0, 1);

    // Deductions Section
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Deductions', 0, 1);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 10, 'SSS: ' . number_format($deductions['sss'], 2) . ' pesos', 0, 1);
    $pdf->Cell(0, 10, 'PhilHealth: ' . number_format($deductions['philhealth'], 2) . ' pesos', 0, 1);
    $pdf->Cell(0, 10, 'Pag-IBIG: ' . number_format($deductions['pagibig'], 2) . ' pesos', 0, 1);
    $pdf->Cell(0, 10, 'Total Deductions: ' . number_format($deductions['total_deductions'], 2) . ' pesos', 0, 1);

    // Net Pay
    $net_pay = $total_pay - $deductions['total_deductions'];
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Net Pay: ' . number_format($net_pay, 2) . ' pesos', 0, 1);

    // Save PDF file to the directory
    $pdfFilePath = 'payslips/' . $employee['employee_name'] . '_payslip.pdf';
    $pdf->Output('F', $pdfFilePath);

    // Add PDF to ZIP
    $zip->addFile($pdfFilePath, basename($pdfFilePath));
}

// Close the ZIP file
$zip->close();

// Send the ZIP file to the browser
header('Content-Type: application/zip');
header('Content-disposition: attachment; filename=payslips.zip');
header('Content-Length: ' . filesize($zipFilename));
readfile($zipFilename);

// Optional: Clean up by deleting the ZIP file after download
unlink($zipFilename);

function calculateDeductions($totalPay) {
    $sss = $totalPay * 0.11; // Assuming 11% for SSS
    $philHealth = $totalPay * 0.03; // Assuming 3% for PhilHealth
    $pagIbig = 100; // Pag-IBIG deduction is fixed at 100
    $total_deductions = $sss + $philHealth + $pagIbig;

    return [
        'sss' => $sss,
        'philhealth' => $philHealth,
        'pagibig' => $pagIbig,
        'total_deductions' => $total_deductions,
    ];
}
?>
