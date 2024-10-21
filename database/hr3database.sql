-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2024 at 03:21 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hr3final9`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `admin_username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `admin_username`, `password`) VALUES
(1, 'defaultAdmin', 'admin123'),
(2, 'admin', '$2y$10$0TMicWNiVKVxPEzKAFjzx.tENlPT10Sfcxv/gKjkBVPsn6VdT0Q3m');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_log`
--

CREATE TABLE `attendance_log` (
  `log_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL,
  `source` varchar(255) NOT NULL,
  `recorded_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance_log`
--

INSERT INTO `attendance_log` (`log_id`, `employee_id`, `employee_name`, `date`, `time_in`, `time_out`, `source`, `recorded_at`) VALUES
(12, 1, 'John Doe', '2024-10-12', '08:00:00', '20:00:00', 'Guard Log', '2024-10-14 00:06:56'),
(13, 10, 'Tyrone Mandie Arol', '2024-10-07', '05:13:00', '17:13:00', 'Guard Log', '2024-10-14 05:13:55'),
(14, 10, 'Tyrone Mandie Arol', '2024-10-08', '05:14:00', '14:14:00', 'Guard Log', '2024-10-14 05:14:27'),
(15, 15, 'Tyrone Manok Azuzal', '2024-10-07', '07:04:00', '15:04:00', 'Guard Log', '2024-10-14 06:04:36'),
(16, 15, 'Tyrone Manok Azuzal', '2024-10-08', '07:04:00', '16:04:00', 'Guard Log', '2024-10-14 06:04:58'),
(17, 15, 'Tyrone Manok Azuzal', '2024-10-09', '07:05:00', '14:05:00', 'Guard Log', '2024-10-14 06:05:20');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` varchar(10) NOT NULL,
  `department_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department_name`) VALUES
('AF', 'Accounting/Finance'),
('B', 'Bar'),
('ECS', 'Events/Convention Services'),
('FB', 'Food and Beverage'),
('FD', 'Front Desk'),
('HR', 'Human Resources'),
('HS', 'Housekeeping'),
('KI', 'Kitchen'),
('MS', 'Maintenance'),
('PI', 'Purchasing/Inventory'),
('SE', 'Security'),
('SM', 'Sales and Marketing');

-- --------------------------------------------------------

--
-- Table structure for table `employee_info`
--

CREATE TABLE `employee_info` (
  `employee_id` int(11) NOT NULL,
  `employee_name` varchar(100) NOT NULL,
  `department_id` varchar(10) DEFAULT NULL,
  `position` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `date_hired` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `basic_salary` decimal(10,2) DEFAULT NULL,
  `department_employee_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_info`
--

INSERT INTO `employee_info` (`employee_id`, `employee_name`, `department_id`, `position`, `date_of_birth`, `contact_no`, `email_address`, `address`, `date_hired`, `status`, `basic_salary`, `department_employee_id`) VALUES
(1, 'John Doe', 'HR', 'HR Manager', '1990-05-15', '1234567890', 'john.doe@example.com', '123 Main St, City', '2020-01-15', 'Full-time', 0.00, NULL),
(10, 'Tyrone Mandie Arol', 'SM', 'Maglalako', '2024-10-02', '09920105191', 'Lebronaaa@gmail.com', 'Marikina City', '2024-10-14', 'Contractual', NULL, NULL),
(15, 'Tyrone Manok Azuzal', 'KI', 'Tindero', '1959-12-11', '09920105191', 'Lebronaaa@gmail.com', 'asdas', '2024-10-14', 'Full-time', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_information`
--

CREATE TABLE `employee_information` (
  `employee_id` int(11) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `contact_no` varchar(15) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `date_hired` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_leave_requests`
--

CREATE TABLE `employee_leave_requests` (
  `employee_id` int(11) NOT NULL,
  `leave_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_days` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `leave_id` int(11) NOT NULL,
  `leave_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
  `payroll_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `payroll_date` date DEFAULT NULL,
  `gross_salary` decimal(10,2) DEFAULT NULL,
  `sss_deduction` decimal(10,2) DEFAULT NULL,
  `philhealth_deduction` decimal(10,2) DEFAULT NULL,
  `pagibig_deduction` decimal(10,2) DEFAULT NULL,
  `loan_deduction` decimal(10,2) DEFAULT NULL,
  `total_deductions` decimal(10,2) DEFAULT NULL,
  `net_salary` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance_log`
--
ALTER TABLE `attendance_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `employee_info`
--
ALTER TABLE `employee_info`
  ADD PRIMARY KEY (`employee_id`),
  ADD UNIQUE KEY `department_employee_id` (`department_employee_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `employee_information`
--
ALTER TABLE `employee_information`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `employee_leave_requests`
--
ALTER TABLE `employee_leave_requests`
  ADD PRIMARY KEY (`employee_id`,`start_date`),
  ADD KEY `leave_id` (`leave_id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`leave_id`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`payroll_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attendance_log`
--
ALTER TABLE `attendance_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `employee_info`
--
ALTER TABLE `employee_info`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `employee_information`
--
ALTER TABLE `employee_information`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `leave_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payroll`
--
ALTER TABLE `payroll`
  MODIFY `payroll_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance_log`
--
ALTER TABLE `attendance_log`
  ADD CONSTRAINT `attendance_log_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee_info` (`employee_id`);

--
-- Constraints for table `employee_leave_requests`
--
ALTER TABLE `employee_leave_requests`
  ADD CONSTRAINT `employee_leave_requests_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee_info` (`employee_id`),
  ADD CONSTRAINT `employee_leave_requests_ibfk_2` FOREIGN KEY (`leave_id`) REFERENCES `leave_types` (`leave_id`);

--
-- Constraints for table `payroll`
--
ALTER TABLE `payroll`
  ADD CONSTRAINT `payroll_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee_information` (`employee_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
