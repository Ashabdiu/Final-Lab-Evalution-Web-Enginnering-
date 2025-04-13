-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2025 at 04:46 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `university_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_code` varchar(20) NOT NULL,
  `course_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_code`, `course_title`) VALUES
('CSE101', 'Problem Solving'),
('CSE201', 'Algorithm'),
('CSE400', 'NLP'),
('CSE412', 'Computer Graphics'),
('CSE415', 'Web Engineering Lab'),
('CSE455', 'Phase 1/ Thesis/ Defense'),
('MAT101', 'Calculus I'),
('MAT201', 'Engineering Mathematics');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `course_code` varchar(20) NOT NULL,
  `semester` varchar(20) NOT NULL,
  `grade` varchar(2) DEFAULT NULL,
  `enrolled_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `student_id`, `course_code`, `semester`, `grade`, `enrolled_at`) VALUES
(1, '213-15-4479', 'CSE415', 'Spring 2024', 'C', '2025-04-13 03:48:21'),
(3, '213-15-4479', 'CSE455', 'Fall 2023', 'A', '2025-04-13 04:16:59'),
(5, '213-15-4479', 'CSE400', 'Spring 2023', 'A+', '2025-04-13 04:17:35'),
(6, '213-15-4470', 'CSE455', 'Spring 2023', 'C', '2025-04-13 04:34:22'),
(7, '213-15-4470', 'CSE412', 'Spring 2023', 'B+', '2025-04-13 04:34:31'),
(8, '213-15-4470', 'CSE101', 'Summer 2023', NULL, '2025-04-13 04:34:45'),
(9, '213-15-4471', 'CSE415', 'Spring 2023', NULL, '2025-04-13 04:34:57'),
(10, '213-15-4471', 'CSE201', 'Spring 2023', NULL, '2025-04-13 04:35:07'),
(11, '213-15-4471', 'CSE455', 'Summer 2023', NULL, '2025-04-13 04:35:17');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `student_id` varchar(20) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `major` varchar(50) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `student_id`, `department`, `major`, `date_of_birth`, `address`, `created_at`) VALUES
(1, 'Ashab', 'ashab@gmail.com', '213-15-4479', 'CSE', 'Computer Science', '2001-10-04', 'Dhaka,BD', '2025-04-13 03:47:44'),
(2, 'Raihan', 'Raihan@gmail.com', '213-15-4470', 'BBA', 'Business Management', '2001-01-01', 'Mirpur,Dhaka\r\n', '2025-04-13 04:03:33'),
(3, 'Shibly', 'shibly@gmail.com', '213-15-4471', 'ENG', 'Electrical Engineering', '2002-02-02', 'CNB, Savar, Dhaka', '2025-04-13 04:31:49'),
(4, 'Hisham', 'hisham@gmail.com', '213-15-4472', 'CSE', 'Software Engineering', '2001-03-03', 'Uttara,Dhaka', '2025-04-13 04:32:51'),
(5, 'Sharmin', 'sharmin@gmail.com', '213-15-4473', 'EEE', 'Electrical Engineering', '2002-04-04', 'Uttara,Dhaka', '2025-04-13 04:33:41'),
(7, 'Rahman', 'rahman15@gmail.com', '213-15-4475', 'CSE', 'Computer Science', '2001-05-05', 'Dhaka,BD', '2025-04-13 14:06:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_code`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_code` (`course_code`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_code`) REFERENCES `courses` (`course_code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
