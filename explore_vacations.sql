-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 14, 2025 at 12:25 PM
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
-- Database: `explore_vacations`
--

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `province_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `key_activities` text DEFAULT NULL,
  `highlights` text DEFAULT NULL,
  `images` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `province_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `name`, `province_id`) VALUES
(1, 'Colombo', 1),
(2, 'Gampaha', 1),
(3, 'Kalutara', 1),
(4, 'Kandy', 2),
(5, 'Matale', 2),
(6, 'Nuwara Eliya', 2),
(7, 'Galle', 3),
(8, 'Matara', 3),
(9, 'Hambantota', 3),
(10, 'Jaffna', 4),
(11, 'Kilinochchi', 4),
(12, 'Mullaitivu', 4),
(13, 'Vavuniya', 4),
(14, 'Batticaloa', 5),
(15, 'Ampara', 5),
(16, 'Trincomalee', 5),
(17, 'Kurunegala', 6),
(18, 'Puttalam', 6),
(19, 'Anuradhapura', 7),
(20, 'Polonnaruwa', 7),
(21, 'Badulla', 8),
(22, 'Moneragala', 8),
(23, 'Kegalle', 9),
(24, 'Ratnapura', 9),
(25, 'Mannar', 4);

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`id`, `name`) VALUES
(1, 'Western'),
(2, 'Central'),
(3, 'Southern'),
(4, 'Northern'),
(5, 'Eastern'),
(6, 'North Western'),
(7, 'North Central'),
(8, 'Uva'),
(9, 'Sabaragamuwa');

-- --------------------------------------------------------

--
-- Table structure for table `tours`
--

CREATE TABLE `tours` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `days` varchar(255) NOT NULL,
  `reviews` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tours`
--

INSERT INTO `tours` (`id`, `name`, `description`, `days`, `reviews`, `image`) VALUES
(1, 'Sigiriya & Dambulla Tour', 'Explore the ancient rock fortress of Sigiriya and the Dambulla cave temples.', '2', '124', 'sigiriya_dambulla.jpg'),
(2, 'Kandy Cultural Tour', 'Visit the Temple of the Tooth and experience traditional Sri Lankan culture in Kandy.', '1', '98', 'kandy_tour.jpg'),
(3, 'Nuwara Eliya & Tea Plantation', 'See beautiful tea plantations, waterfalls, and the scenic town of Nuwara Eliya.', '2', '76', 'nuwara_eliya.jpg'),
(4, 'Yala Safari Adventure', 'Go on a thrilling safari in Yala National Park to spot elephants, leopards, and more.', '1', '145', 'yala_safari.jpg'),
(5, 'Ella Hiking & Scenic Train', 'Hike through the beautiful Ella area and enjoy the famous scenic train ride.', '2', '89', 'ella_hiking.jpg'),
(6, 'Galle & Southern Beaches', 'Relax on the beaches and explore the historic Galle Fort.', '3', '112', 'galle_beach.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tour_themes`
--

CREATE TABLE `tour_themes` (
  `id` int(11) NOT NULL,
  `theme_name` varchar(255) NOT NULL,
  `theme_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tour_themes`
--

INSERT INTO `tour_themes` (`id`, `theme_name`, `theme_images`, `created_at`) VALUES
(1, 'Adventure Tours', '[\r\n        \"images/themes/adventure1.jpg\",\r\n        \"images/themes/adventure2.jpg\",\r\n        \"images/themes/adventure3.jpg\"\r\n    ]', '2025-12-12 09:53:43'),
(2, 'Cultural Experiences', '[\r\n        \"images/themes/culture1.jpg\",\r\n        \"images/themes/culture2.jpg\",\r\n        \"images/themes/culture3.jpg\"\r\n    ]', '2025-12-12 09:54:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `province_id` (`province_id`),
  ADD KEY `district_id` (`district_id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `province_id` (`province_id`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tour_themes`
--
ALTER TABLE `tour_themes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tour_themes`
--
ALTER TABLE `tour_themes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`),
  ADD CONSTRAINT `cities_ibfk_2` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`);

--
-- Constraints for table `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `districts_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
