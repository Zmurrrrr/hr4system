<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tax Tables</title>
    <link rel="stylesheet" href="PAYROLL.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .top-nav {
            background-color: #333;
            color: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .top-nav h1 {
            margin: 0;
            font-size: 1.5em;
        }
        .top-nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .top-nav li {
            margin-right: 20px;
        }
        .top-nav a {
            color: #fff;
            text-decoration: none;
            padding: 8px 15px;
            transition: background-color 0.3s;
        }
        .top-nav a:hover {
            background-color: #575757;
        }
        .logout {
            background-color: #d9534f;
            color: #fff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .logout:hover {
            background-color: #c9302c;
        }
        .content {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        button[type="submit"],
        .back-home {
            background-color: #5cb85c;
            color: #fff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }
        button[type="submit"]:hover,
        .back-home:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <div class="top-nav">
        <ul>
            <li class="top">
                <a class="top1" href="PAYROLLTAB.php">Home</a>
                <a class="top1" href="tax-tables.php">Tax Table</a>
                <a class="top1" href="overtime-rules.php">Overtime Rules</a>
                <a class="top1" href="payroll-deduction.php">Payroll Deductions</a>
                <a class="top1" href="direct-deposit-settings.php">Direct Deposit Settings</a>
            </li>
        </ul>
        <form method="POST" action="logout.php">
            <button class="logout">Logout</button>
        </form>
    </div>

    <div class="content">
        <h2>Philippine Payroll Deductions</h2>
        <p>Here are the standard payroll deductions for the Philippines:</p>
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Rate</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>SSS Contribution</td>
                    <td>11%</td>
                    <td>Social Security System (SSS) contribution, split between employer and employee.</td>
                </tr>
                <tr>
                    <td>PhilHealth</td>
                    <td>3%</td>
                    <td>Philippine Health Insurance Corporation contribution for health benefits.</td>
                </tr>
                <tr>
                    <td>Pag-IBIG</td>
                    <td>2%</td>
                    <td>Home Development Mutual Fund for housing loans and savings programs.</td>
                </tr>
                <tr>
                    <td>Withholding Tax</td>
                    <td>Varies</td>
                    <td>Based on the employee's taxable income, aligned with the BIR tax tables.</td>
                </tr>
            </tbody>
        </table>

        <button class="back-home" onclick="location.href='PAYROLLTAB.php'">Back to Home</button>
    </div>
</body>
</html>
