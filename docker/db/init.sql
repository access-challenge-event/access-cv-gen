-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Feb 09, 2026 at 01:23 PM
-- Server version: 8.4.8
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cvgen`
--

-- --------------------------------------------------------

--
-- Table structure for table `awards`
--

CREATE TABLE `awards` (
  `award_id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(512) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `chat_id` int NOT NULL,
  `user_id` int NOT NULL,
  `questions` blob NOT NULL,
  `answers` blob NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `education_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `title` varchar(50) NOT NULL,
  `school` varchar(50) NOT NULL,
  `length` int NOT NULL,
  `graduation_date` datetime NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `experience`
--

CREATE TABLE `experience` (
  `experience_id` int NOT NULL,
  `user_id` int NOT NULL,
  `job_title` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `duration` varchar(50) NOT NULL,
  `content` varchar(512) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `username` varchar(24) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(24),
  `lastname` varchar(24),
  `age` date,
  `about` varchar(512),
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_listings`
--

CREATE TABLE `job_listings` (
  `job_id` int NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
  `title` varchar(80) NOT NULL,
  `company` varchar(80) NOT NULL,
  `location` varchar(80) NOT NULL,
  `employment_type` varchar(30) NOT NULL,
  `level` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `responsibilities` text NOT NULL,
  `requirements` text NOT NULL,
  `salary_range` varchar(40) DEFAULT NULL,
  `posted_date` date NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Seed data for table `job_listings`
--

INSERT INTO `job_listings` (
  `title`,
  `company`,
  `location`,
  `employment_type`,
  `level`,
  `description`,
  `responsibilities`,
  `requirements`,
  `salary_range`,
  `posted_date`
) VALUES
(
  'Software Engineer',
  'Northbridge Labs',
  'Seattle, WA (Hybrid)',
  'Full-time',
  'Mid-level',
  'Build and maintain customer-facing web services used by small businesses to manage bookings and payments.',
  'Deliver features in a PHP and JavaScript stack; write unit tests; collaborate with product and design; monitor and improve performance.',
  '3+ years of web development; solid PHP and MySQL; experience with REST APIs; familiarity with Docker and CI; strong problem-solving skills.',
  '$95k - $120k',
  '2026-02-02'
),
(
  'Data Analyst',
  'Cedar Analytics',
  'Austin, TX (On-site)',
  'Full-time',
  'Junior',
  'Support reporting and insights for marketing and operations teams with clean dashboards and ad hoc analysis.',
  'Build SQL queries and dashboards; validate data quality; document metrics; present findings to stakeholders.',
  '1-2 years in analytics or internship experience; SQL proficiency; Excel or Google Sheets; basic statistics; BI tools like Tableau or Power BI.',
  '$55k - $70k',
  '2026-02-04'
),
(
  'UX Designer',
  'Harbor Health',
  'Remote (US)',
  'Full-time',
  'Mid-level',
  'Design accessible patient-facing experiences for scheduling, telehealth, and intake flows.',
  'Lead discovery workshops; create user flows and prototypes; run usability tests; partner with engineers for handoff.',
  '3+ years of UX design; portfolio with web and mobile work; experience with Figma; knowledge of accessibility standards (WCAG).',
  '$85k - $105k',
  '2026-02-03'
),
(
  'IT Support Specialist',
  'Summit Logistics',
  'Chicago, IL (On-site)',
  'Full-time',
  'Entry-level',
  'Provide frontline support for laptops, printers, and warehouse systems across multiple sites.',
  'Resolve tickets; image and deploy devices; document fixes; support user onboarding and offboarding.',
  'CompTIA A+ or equivalent; basic Windows and macOS support; customer service experience; ability to lift 30 lbs.',
  '$42k - $52k',
  '2026-01-29'
),
(
  'Product Manager',
  'BrightPath Finance',
  'Denver, CO (Hybrid)',
  'Full-time',
  'Senior',
  'Own roadmap for a small business lending platform and drive delivery of new onboarding and underwriting features.',
  'Define requirements and success metrics; coordinate cross-functional delivery; run stakeholder reviews; prioritize backlog based on impact.',
  '5+ years in product management; experience in fintech or regulated industries; strong communication and analytics skills; Agile experience.',
  '$125k - $145k',
  '2026-02-01'
);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `awards`
--
ALTER TABLE `awards`
  ADD PRIMARY KEY (`award_id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`education_id`);

--
-- Indexes for table `experience`
--
ALTER TABLE `experience`
  ADD PRIMARY KEY (`experience_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `unique_username` (`username`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- Indexes for table `job_listings`
--
ALTER TABLE `job_listings`
  ADD PRIMARY KEY (`job_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `awards`
--
ALTER TABLE `awards`
  MODIFY `award_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `chat_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `education_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `experience`
--
ALTER TABLE `experience`
  MODIFY `experience_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_listings`
--
ALTER TABLE `job_listings`
  MODIFY `job_id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
