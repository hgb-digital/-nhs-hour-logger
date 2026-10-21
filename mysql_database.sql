-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 21, 2026 at 05:13 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nhs-centennial`
--
CREATE DATABASE IF NOT EXISTS `nhs-centennial` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `nhs-centennial`;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `html` text NOT NULL,
  `posted` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_verification`
--

CREATE TABLE `email_verification` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires` datetime NOT NULL,
  `type` enum('verify_email','reset_password') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hours`
--

CREATE TABLE `hours` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` enum('isp','gsp') NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `duration` float NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `supervisor_name` varchar(55) DEFAULT NULL,
  `supervisor_contact` varchar(85) DEFAULT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hours`
--

INSERT INTO `hours` (`id`, `user_id`, `type`, `role_id`, `duration`, `title`, `description`, `supervisor_name`, `supervisor_contact`, `timestamp`) VALUES
(9, 2, 'gsp', NULL, 2, 'Event Setup', 'Helped prepare school event', 'Mrs. Carter', 'carter@school.org', '2026-04-16 23:54:02'),
(10, 123, 'isp', NULL, 3, 'Secretary Work', 'Recorded meeting minutes', 'Dr. Allen', 'allen@school.org', '2026-04-16 23:54:02'),
(11, 123, 'gsp', NULL, 2, 'Library Help', 'Organized library shelves', 'Mrs. Carter', 'carter@school.org', '2026-04-16 23:54:02'),
(12, 124, 'isp', NULL, 4, 'Publicity Campaign', 'Managed NHS social media', 'Dr. Allen', 'allen@school.org', '2026-04-16 23:54:02'),
(13, 124, 'gsp', NULL, 2, 'Flyer Distribution', 'Distributed flyers around school', 'Mrs. Carter', 'carter@school.org', '2026-04-16 23:54:02'),
(14, 125, 'isp', NULL, 4, 'Policy Research', 'Reviewed school policies', 'Dr. Allen', 'allen@school.org', '2026-04-16 23:54:02'),
(15, 125, 'gsp', NULL, 3, 'Volunteer Help', 'Assisted at food drive', 'Mrs. Carter', 'carter@school.org', '2026-04-16 23:54:02'),
(16, 126, 'isp', NULL, 5, 'Officer Coordination', 'Coordinated officer team', 'Dr. Allen', 'allen@school.org', '2026-04-16 23:54:02'),
(17, 126, 'gsp', NULL, 2, 'Campus Event', 'Helped run school event', 'Mrs. Carter', 'carter@school.org', '2026-04-16 23:54:02'),
(18, 129, 'isp', NULL, 4, 'Budget Planning', 'Created NHS budget plan', 'Dr. Allen', 'allen@school.org', '2026-04-16 23:54:02'),
(19, 129, 'gsp', NULL, 2, 'Tutoring Help', 'Helped students with math', 'Mrs. Carter', 'carter@school.org', '2026-04-16 23:54:02'),
(21, 127, 'gsp', NULL, 4, 'Tutoring Session', 'Tutored younger students', 'Ms. Johnson', 'johnson@school.org', '2026-04-16 23:54:02'),
(23, 128, 'gsp', NULL, 3, 'Community Service', 'Helped at shelter', 'Ms. Johnson', 'johnson@school.org', '2026-04-16 23:54:02'),
(24, 130, 'isp', NULL, 2, 'Meeting Notes', 'Recorded polis notes', 'Ms. Johnson', 'johnson@school.org', '2026-04-16 23:54:02'),
(25, 130, 'gsp', NULL, 3, 'Food Pantry', 'Sorted donations', 'Ms. Johnson', 'johnson@school.org', '2026-04-16 23:54:02'),
(26, 131, 'isp', NULL, 2, 'Research', 'Studied civic engagement', 'Ms. Johnson', 'johnson@school.org', '2026-04-16 23:54:02'),
(27, 131, 'gsp', NULL, 2, 'Volunteer Work', 'Assisted at event', 'Ms. Johnson', 'johnson@school.org', '2026-04-16 23:54:02'),
(28, 132, 'isp', NULL, 2, 'Prep Work', 'Prepared discussion points', 'Ms. Johnson', 'johnson@school.org', '2026-04-16 23:54:02'),
(29, 132, 'gsp', NULL, 3, 'Cleanup Crew', 'Helped campus cleanup', 'Ms. Johnson', 'johnson@school.org', '2026-04-16 23:54:02'),
(30, 133, 'isp', NULL, 4, 'Fundraising Strategy', 'Planned donation outreach', 'Mr. Lee', 'lee@school.org', '2026-04-16 23:54:02'),
(31, 133, 'gsp', NULL, 3, 'Bake Sale', 'Helped run bake sale', 'Mr. Lee', 'lee@school.org', '2026-04-16 23:54:02'),
(32, 134, 'isp', NULL, 3, 'Marketing Design', 'Created posters for event', 'Mr. Lee', 'lee@school.org', '2026-04-16 23:54:02'),
(33, 134, 'gsp', NULL, 3, 'Ticket Sales', 'Sold fundraiser tickets', 'Mr. Lee', 'lee@school.org', '2026-04-16 23:54:02'),
(34, 135, 'isp', NULL, 2, 'Budget Tracking', 'Tracked fundraising income', 'Mr. Lee', 'lee@school.org', '2026-04-16 23:54:02'),
(35, 135, 'gsp', NULL, 3, 'Setup Crew', 'Set up tables and chairs', 'Mr. Lee', 'lee@school.org', '2026-04-16 23:54:02'),
(36, 136, 'isp', NULL, 3, 'Sponsor Outreach', 'Contacted local sponsors', 'Mr. Lee', 'lee@school.org', '2026-04-16 23:54:02'),
(37, 136, 'gsp', NULL, 2, 'Car Wash', 'Helped run car wash fundraiser', 'Mr. Lee', 'lee@school.org', '2026-04-16 23:54:02'),
(38, 137, 'isp', NULL, 2, 'Planning Meeting', 'Attended fundraiser planning', 'Mr. Lee', 'lee@school.org', '2026-04-16 23:54:02'),
(39, 137, 'gsp', NULL, 3, 'Donation Sorting', 'Sorted donations', 'Mr. Lee', 'lee@school.org', '2026-04-16 23:54:02'),
(40, 138, 'isp', NULL, 2, 'Event Prep', 'Prepared fundraiser materials', 'Mr. Lee', 'lee@school.org', '2026-04-16 23:54:02'),
(41, 138, 'gsp', NULL, 2, 'Cleanup', 'Cleaned after event', 'Mr. Lee', 'lee@school.org', '2026-04-16 23:54:02'),
(42, 139, 'isp', NULL, 4, 'Mentor Program', 'Designed mentoring system', 'Dr. Smith', 'smith@school.org', '2026-04-16 23:54:02'),
(43, 139, 'gsp', NULL, 3, 'Tutoring', 'Helped freshmen study', 'Dr. Smith', 'smith@school.org', '2026-04-16 23:54:02'),
(44, 140, 'isp', NULL, 3, 'Leadership Prep', 'Prepared elder meeting agenda', 'Dr. Smith', 'smith@school.org', '2026-04-16 23:54:02'),
(45, 140, 'gsp', NULL, 4, 'Reading Help', 'Assisted reading program', 'Dr. Smith', 'smith@school.org', '2026-04-16 23:54:02'),
(46, 141, 'isp', NULL, 2, 'Curriculum Review', 'Reviewed tutoring materials', 'Dr. Smith', 'smith@school.org', '2026-04-16 23:54:02'),
(47, 141, 'gsp', NULL, 3, 'Study Help', 'Helped students after school', 'Dr. Smith', 'smith@school.org', '2026-04-16 23:54:02'),
(48, 142, 'isp', NULL, 3, 'Program Design', 'Helped design mentoring program', 'Dr. Smith', 'smith@school.org', '2026-04-16 23:54:02'),
(49, 142, 'gsp', NULL, 2, 'Library Work', 'Organized books', 'Dr. Smith', 'smith@school.org', '2026-04-16 23:54:02'),
(50, 143, 'isp', NULL, 2, 'Meeting Notes', 'Recorded elder meeting notes', 'Dr. Smith', 'smith@school.org', '2026-04-16 23:54:02'),
(51, 143, 'gsp', NULL, 3, 'Food Drive', 'Helped sort donations', 'Dr. Smith', 'smith@school.org', '2026-04-16 23:54:02'),
(52, 144, 'isp', NULL, 2, 'Planning', 'Discussed mentoring goals', 'Dr. Smith', 'smith@school.org', '2026-04-16 23:54:02'),
(53, 144, 'gsp', NULL, 3, 'Volunteer Work', 'Assisted community service', 'Dr. Smith', 'smith@school.org', '2026-04-16 23:54:02'),
(54, 145, 'isp', NULL, 4, 'Event Planning', 'Organized school assembly', 'Principal Harris', 'harris@school.org', '2026-04-16 23:54:02'),
(55, 145, 'gsp', NULL, 3, 'Pep Rally', 'Helped run pep rally', 'Principal Harris', 'harris@school.org', '2026-04-16 23:54:02'),
(56, 146, 'isp', NULL, 3, 'Media Outreach', 'Promoted school events', 'Principal Harris', 'harris@school.org', '2026-04-16 23:54:02'),
(57, 146, 'gsp', NULL, 4, 'Setup Crew', 'Set up stage equipment', 'Principal Harris', 'harris@school.org', '2026-04-16 23:54:02'),
(58, 147, 'isp', NULL, 2, 'Agenda Prep', 'Created assembly agenda', 'Principal Harris', 'harris@school.org', '2026-04-16 23:54:02'),
(59, 147, 'gsp', NULL, 3, 'Cleanup', 'Cleaned auditorium', 'Principal Harris', 'harris@school.org', '2026-04-16 23:54:02'),
(60, 148, 'isp', NULL, 2, 'Speech Writing', 'Helped prepare speeches', 'Principal Harris', 'harris@school.org', '2026-04-16 23:54:02'),
(61, 148, 'gsp', NULL, 3, 'Event Support', 'Assisted during event', 'Principal Harris', 'harris@school.org', '2026-04-16 23:54:02'),
(62, 149, 'isp', NULL, 2, 'Logistics', 'Planned seating layout', 'Principal Harris', 'harris@school.org', '2026-04-16 23:54:02'),
(63, 149, 'gsp', NULL, 2, 'Volunteer Work', 'Helped school cleanup', 'Principal Harris', 'harris@school.org', '2026-04-16 23:54:02'),
(64, 150, 'isp', NULL, 3, 'Coordination', 'Coordinated announcements', 'Principal Harris', 'harris@school.org', '2026-04-16 23:54:02'),
(65, 150, 'gsp', NULL, 2, 'Setup Help', 'Assisted setup team', 'Principal Harris', 'harris@school.org', '2026-04-16 23:54:02'),
(66, 151, 'isp', NULL, 2, 'Notes', 'Recorded meeting notes', 'Principal Harris', 'harris@school.org', '2026-04-16 23:54:02'),
(67, 151, 'gsp', NULL, 2, 'Support Staff', 'Helped event staff', 'Principal Harris', 'harris@school.org', '2026-04-16 23:54:02'),
(68, 152, 'isp', NULL, 2, 'Review', 'Evaluated event success', 'Principal Harris', 'harris@school.org', '2026-04-16 23:54:02'),
(69, 152, 'gsp', NULL, 3, 'Cleanup', 'Post-event cleanup', 'Principal Harris', 'harris@school.org', '2026-04-16 23:54:02'),
(72, 123, 'isp', NULL, 2, 'Minutes Review', 'Edited meeting minutes', 'Dr. Allen', 'allen@school.org', '2026-04-16 23:54:25'),
(73, 124, 'gsp', NULL, 3, 'Flyer Campaign', 'Distributed promotional flyers', 'Mrs. Carter', 'carter@school.org', '2026-04-16 23:54:25'),
(74, 125, 'isp', NULL, 3, 'Policy Review', 'Reviewed leadership policies', 'Dr. Allen', 'allen@school.org', '2026-04-16 23:54:25'),
(75, 126, 'gsp', NULL, 2, 'Event Help', 'Assisted during campus event', 'Mrs. Carter', 'carter@school.org', '2026-04-16 23:54:25'),
(76, 129, 'isp', NULL, 2, 'Budget Update', 'Updated financial tracking sheet', 'Dr. Allen', 'allen@school.org', '2026-04-16 23:54:25'),
(77, 127, 'isp', NULL, 2, 'Debate Prep', 'Prepared arguments for meeting', 'Ms. Johnson', 'johnson@school.org', '2026-04-16 23:54:25'),
(78, 128, 'gsp', NULL, 3, 'Shelter Help', 'Assisted local shelter work', 'Ms. Johnson', 'johnson@school.org', '2026-04-16 23:54:25'),
(79, 130, 'isp', NULL, 2, 'Meeting Prep', 'Organized discussion topics', 'Ms. Johnson', 'johnson@school.org', '2026-04-16 23:54:25'),
(80, 131, 'gsp', NULL, 2, 'Volunteer Shift', 'Helped at food pantry', 'Ms. Johnson', 'johnson@school.org', '2026-04-16 23:54:25'),
(81, 132, 'isp', NULL, 1, 'Notes', 'Recorded meeting notes', 'Ms. Johnson', 'johnson@school.org', '2026-04-16 23:54:25'),
(82, 133, 'gsp', NULL, 3, 'Bake Sale', 'Ran bake sale booth', 'Mr. Lee', 'lee@school.org', '2026-04-16 23:54:25'),
(83, 134, 'isp', NULL, 2, 'Poster Design', 'Created fundraiser posters', 'Mr. Lee', 'lee@school.org', '2026-04-16 23:54:25'),
(84, 135, 'gsp', NULL, 2, 'Event Setup', 'Set up tables and chairs', 'Mr. Lee', 'lee@school.org', '2026-04-16 23:54:25'),
(85, 136, 'isp', NULL, 3, 'Sponsor Outreach', 'Contacted donors', 'Mr. Lee', 'lee@school.org', '2026-04-16 23:54:25'),
(86, 137, 'gsp', NULL, 2, 'Donation Sorting', 'Sorted donated items', 'Mr. Lee', 'lee@school.org', '2026-04-16 23:54:25'),
(87, 138, 'isp', NULL, 2, 'Planning', 'Attended fundraiser meeting', 'Mr. Lee', 'lee@school.org', '2026-04-16 23:54:25'),
(88, 139, 'gsp', NULL, 3, 'Tutoring', 'Helped underclassmen study', 'Dr. Smith', 'smith@school.org', '2026-04-16 23:54:25'),
(89, 140, 'isp', NULL, 2, 'Mentor Prep', 'Prepared mentoring curriculum', 'Dr. Smith', 'smith@school.org', '2026-04-16 23:54:25'),
(90, 141, 'gsp', NULL, 2, 'Study Help', 'Assisted students after school', 'Dr. Smith', 'smith@school.org', '2026-04-16 23:54:25'),
(91, 142, 'isp', NULL, 3, 'Program Work', 'Improved mentorship system', 'Dr. Smith', 'smith@school.org', '2026-04-16 23:54:25'),
(92, 143, 'gsp', NULL, 2, 'Library Help', 'Helped organize books', 'Dr. Smith', 'smith@school.org', '2026-04-16 23:54:25'),
(93, 144, 'isp', NULL, 2, 'Meeting Prep', 'Prepared elder meeting agenda', 'Dr. Smith', 'smith@school.org', '2026-04-16 23:54:25'),
(94, 145, 'gsp', NULL, 3, 'Event Help', 'Assisted school assembly', 'Principal Harris', 'harris@school.org', '2026-04-16 23:54:25'),
(95, 146, 'isp', NULL, 2, 'Media Planning', 'Planned announcements', 'Principal Harris', 'harris@school.org', '2026-04-16 23:54:25'),
(96, 147, 'gsp', NULL, 2, 'Cleanup', 'Cleaned auditorium after event', 'Principal Harris', 'harris@school.org', '2026-04-16 23:54:25'),
(97, 148, 'isp', NULL, 3, 'Speech Prep', 'Helped prepare speeches', 'Principal Harris', 'harris@school.org', '2026-04-16 23:54:25'),
(98, 149, 'gsp', NULL, 2, 'Setup Crew', 'Helped set up stage', 'Principal Harris', 'harris@school.org', '2026-04-16 23:54:25'),
(100, 151, 'gsp', NULL, 2, 'Support Staff', 'Assisted event staff', 'Principal Harris', 'harris@school.org', '2026-04-16 23:54:25'),
(101, 152, 'isp', NULL, 2, 'Review', 'Evaluated assembly effectiveness', 'Principal Harris', 'harris@school.org', '2026-04-16 23:54:25'),
(102, 127, 'gsp', NULL, 2, 'Community Service', 'Helped local cleanup', 'Ms. Johnson', 'johnson@school.org', '2026-04-16 23:54:25'),
(103, 130, 'gsp', NULL, 3, 'Food Drive', 'Sorted donations', 'Ms. Johnson', 'johnson@school.org', '2026-04-16 23:54:25'),
(104, 133, 'isp', NULL, 2, 'Fundraising Strategy', 'Planned outreach campaign', 'Mr. Lee', 'lee@school.org', '2026-04-16 23:54:25'),
(105, 139, 'isp', NULL, 3, 'Mentor Training', 'Trained new mentors', 'Dr. Smith', 'smith@school.org', '2026-04-16 23:54:25'),
(106, 145, 'isp', NULL, 2, 'Event Coordination', 'Organized school assembly schedule', 'Principal Harris', 'harris@school.org', '2026-04-16 23:54:25'),
(111, 1, 'isp', NULL, 3, 'grandma', 'again', 'yes', 'no', '2026-04-17 09:28:33'),
(113, 1, 'gsp', NULL, 5, NULL, NULL, NULL, NULL, '2026-04-20 16:24:19');

-- --------------------------------------------------------

--
-- Table structure for table `service_roles`
--

CREATE TABLE `service_roles` (
  `id` int(11) NOT NULL,
  `sheet_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `location` varchar(255) NOT NULL,
  `attire` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `slots` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_roles`
--

INSERT INTO `service_roles` (`id`, `sheet_id`, `time`, `location`, `attire`, `description`, `slots`) VALUES
(20, 5, '2026-04-08 22:27:00', 'CHS', NULL, 'Help setup the event', 2),
(21, 6, '2027-04-25 22:28:00', 'Pathway', 'All Black', 'Draw blood', 3),
(22, 7, '2026-04-26 22:29:00', 'Southern Oaks', 'NHS Shirt', 'Setup the tournament', 2),
(23, 5, '2026-04-14 22:27:00', 'CHS', NULL, 'Help teardown', 2),
(24, 7, '2026-04-28 22:29:00', 'Southern Oaks', 'NHS Shirt', 'Escort Players', 1);

-- --------------------------------------------------------

--
-- Table structure for table `service_sheet`
--

CREATE TABLE `service_sheet` (
  `id` int(11) NOT NULL,
  `title` varchar(55) NOT NULL,
  `description` longtext NOT NULL,
  `organizer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_sheet`
--

INSERT INTO `service_sheet` (`id`, `title`, `description`, `organizer_id`) VALUES
(5, 'Homecoming', 'Help organize the school dance', 1),
(6, 'Blood Drive', 'Help draw blood at Pathway', 1),
(7, 'Southern Oaks', 'Help run a golf day', 1);

-- --------------------------------------------------------

--
-- Table structure for table `signups`
--

CREATE TABLE `signups` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `signup_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `signups`
--

INSERT INTO `signups` (`id`, `role_id`, `user_id`, `signup_timestamp`) VALUES
(23, 22, 1, '2026-04-26 02:31:21'),
(25, 21, 1, '2026-10-21 03:13:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(254) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `first_name` varchar(55) NOT NULL,
  `last_name` varchar(55) NOT NULL,
  `graduation_year` int(11) NOT NULL,
  `committee` enum('polis','elders','fundraiser','assembly','officer') DEFAULT NULL,
  `permissions` enum('officer','chair','admin','member') NOT NULL DEFAULT 'member',
  `title` enum('president','vice_president','secretary','treasurer','parliamentarian','publicist','oal','jr_assembly','sr_assembly','jr_elders','sr_elders','jr_fundraiser','sr_fundraiser','jr_polis','sr_polis') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `first_name`, `last_name`, `graduation_year`, `committee`, `permissions`, `title`) VALUES
(1, 'hudson.brackeen@gmail.com', '$2y$12$5aZ/jxDgXOS/D0s80Fc.suZZlht2Yl6HgNXtKFZKtWaoVpn5OxHaG', 'Hudson', 'Brackeen', 2027, 'officer', 'officer', 'president'),
(2, 'brackhud000@bisdmail.net', '$2y$12$P91B7mWGtlItLadw86XnPOxs3gSO8huJr5fDNHzyDmGTPZbgpBwcO', 'Brody', 'Brackeen', 2030, 'officer', 'officer', 'vice_president'),
(123, 'john.smith1@nhs.org', NULL, 'John', 'Smith', 2025, 'officer', 'officer', 'secretary'),
(124, 'emma.johnson2@nhs.org', NULL, 'Emma', 'Johnson', 2025, 'officer', 'officer', 'publicist'),
(125, 'liam.williams3@nhs.org', NULL, 'Liam', 'Williams', 2026, 'officer', 'officer', 'parliamentarian'),
(126, 'olivia.brown4@nhs.org', NULL, 'Olivia', 'Brown', 2026, 'officer', 'officer', 'oal'),
(127, 'noah.jones5@nhs.org', NULL, 'Noah', 'Jones', 2025, 'polis', 'chair', 'sr_polis'),
(128, 'ava.garcia6@nhs.org', NULL, 'Ava', 'Garcia', 2026, 'polis', 'chair', 'jr_polis'),
(129, 'ethan.miller7@nhs.org', NULL, 'Ethan', 'Miller', 2026, 'officer', 'officer', 'treasurer'),
(130, 'sophia.davis8@nhs.org', NULL, 'Sophia', 'Davis', 2025, 'polis', 'member', NULL),
(131, 'lucas.rodriguez9@nhs.org', NULL, 'Lucas', 'Rodriguez', 2027, 'polis', 'member', NULL),
(132, 'mia.martinez10@nhs.org', NULL, 'Mia', 'Martinez', 2027, 'polis', 'member', NULL),
(133, 'james.hernandez11@nhs.org', NULL, 'James', 'Hernandez', 2025, 'fundraiser', 'chair', 'sr_fundraiser'),
(134, 'isabella.lopez12@nhs.org', NULL, 'Isabella', 'Lopez', 2026, 'fundraiser', 'chair', 'jr_fundraiser'),
(135, 'benjamin.gonzalez13@nhs.org', NULL, 'Benjamin', 'Gonzalez', 2026, 'fundraiser', 'member', NULL),
(136, 'charlotte.wilson14@nhs.org', NULL, 'Charlotte', 'Wilson', 2025, 'fundraiser', 'member', NULL),
(137, 'henry.anderson15@nhs.org', NULL, 'Henry', 'Anderson', 2027, 'fundraiser', 'member', NULL),
(138, 'amelia.thomas16@nhs.org', NULL, 'Amelia', 'Thomas', 2027, 'fundraiser', 'member', NULL),
(139, 'alex.taylor17@nhs.org', NULL, 'Alexander', 'Taylor', 2025, 'elders', 'chair', 'sr_elders'),
(140, 'harper.moore18@nhs.org', NULL, 'Harper', 'Moore', 2026, 'elders', 'chair', 'jr_elders'),
(141, 'daniel.jackson19@nhs.org', NULL, 'Daniel', 'Jackson', 2026, 'elders', 'member', NULL),
(142, 'evelyn.martin20@nhs.org', NULL, 'Evelyn', 'Martin', 2025, 'elders', 'member', NULL),
(143, 'matthew.lee21@nhs.org', NULL, 'Matthew', 'Lee', 2027, 'elders', 'member', NULL),
(144, 'abigail.perez22@nhs.org', NULL, 'Abigail', 'Perez', 2027, 'elders', 'member', NULL),
(145, 'david.white23@nhs.org', NULL, 'David', 'White', 2025, 'assembly', 'chair', 'sr_assembly'),
(146, 'emily.harris24@nhs.org', NULL, 'Emily', 'Harris', 2026, 'assembly', 'chair', 'jr_assembly'),
(147, 'joseph.sanchez25@nhs.org', NULL, 'Joseph', 'Sanchez', 2026, 'assembly', 'member', NULL),
(148, 'ella.clark26@nhs.org', NULL, 'Ella', 'Clark', 2025, 'assembly', 'member', NULL),
(149, 'samuel.ramirez27@nhs.org', NULL, 'Samuel', 'Ramirez', 2027, 'assembly', 'member', NULL),
(150, 'scarlett.lewis28@nhs.org', NULL, 'Scarlett', 'Lewis', 2027, 'assembly', 'member', NULL),
(151, 'carter.robinson29@nhs.org', NULL, 'Carter', 'Robinson', 2026, 'assembly', 'member', NULL),
(152, 'victoria.walker30@nhs.org', NULL, 'Victoria', 'Walker', 2025, 'assembly', 'member', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `email_verification`
--
ALTER TABLE `email_verification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `hours`
--
ALTER TABLE `hours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_hours_role` (`role_id`);

--
-- Indexes for table `service_roles`
--
ALTER TABLE `service_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sheet_id` (`sheet_id`);

--
-- Indexes for table `service_sheet`
--
ALTER TABLE `service_sheet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organizer_id` (`organizer_id`);

--
-- Indexes for table `signups`
--
ALTER TABLE `signups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_verification`
--
ALTER TABLE `email_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `hours`
--
ALTER TABLE `hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `service_roles`
--
ALTER TABLE `service_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `service_sheet`
--
ALTER TABLE `service_sheet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `signups`
--
ALTER TABLE `signups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `email_verification`
--
ALTER TABLE `email_verification`
  ADD CONSTRAINT `email_verification_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hours`
--
ALTER TABLE `hours`
  ADD CONSTRAINT `fk_hours_role` FOREIGN KEY (`role_id`) REFERENCES `service_roles` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `hours_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `service_roles`
--
ALTER TABLE `service_roles`
  ADD CONSTRAINT `fk_sheet_id` FOREIGN KEY (`sheet_id`) REFERENCES `service_sheet` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `service_roles_ibfk_1` FOREIGN KEY (`sheet_id`) REFERENCES `service_sheet` (`id`);

--
-- Constraints for table `service_sheet`
--
ALTER TABLE `service_sheet`
  ADD CONSTRAINT `service_sheet_ibfk_1` FOREIGN KEY (`organizer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `signups`
--
ALTER TABLE `signups`
  ADD CONSTRAINT `signups_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `service_roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `signups_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
