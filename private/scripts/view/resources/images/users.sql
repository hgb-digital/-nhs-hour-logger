-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 17, 2026 at 06:53 AM
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
(1, 'hudson.brackeen@gmail.com', '$2y$12$zmK2HVc3dyawdgLsqBaSyuRKO1I9J7jQJ91FDNrkYf4LcLt8ZDlTC', 'Hudson', 'Brackeen', 2027, 'officer', 'officer', 'president'),
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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
