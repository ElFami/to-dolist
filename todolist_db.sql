-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2024 at 03:32 PM
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
-- Database: `todolist_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `task` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `task`, `status`, `created_at`) VALUES
(102, 7, 'Mandi Makan', 1, '2024-10-22 16:42:07'),
(103, 7, 'Mandi Makan', 0, '2024-10-22 16:46:37'),
(104, 8, 'Mandi Makan', 1, '2024-10-23 07:28:26'),
(105, 8, 'Tidur', 0, '2024-10-23 07:28:29'),
(106, 8, 'Mandi Makan', 0, '2024-10-23 07:29:52'),
(107, 8, 'Mandi Makan', 0, '2024-10-23 07:29:55'),
(108, 8, 'Mandi Makan', 0, '2024-10-23 07:29:57'),
(109, 8, 'makan', 0, '2024-10-23 07:30:00'),
(110, 8, 'Tidur', 0, '2024-10-23 07:30:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `profile_pic`) VALUES
(1, 'andika', 'nicholas123@gmail.com', '$2y$10$cwL.jiUOZHmCvAgiXVpcoech0WOxImS3gI9K2uwQBRiVTCbvBWTn2', NULL),
(6, 'Kyomoto', '123@gmail.com', '$2y$10$JXit9gj6vNw0oReP1s.qsOxSYDWx0cN1fifAcXe4qdoudvz.HXNNi', 'uploads/image_2024-10-23_101416329.png'),
(7, 'Soukaku', 'abc@gmail.com', '$2y$10$l6faNNMmyAh9LHqTZ2eH7O3NmZqlSvnFP8dxuowTnsXZV24TxmClW', 'uploads/Untitled design (4).png'),
(8, 'Maura', '123456@gmail.com', '$2y$10$CSq2tdBF5IwaG5.IxakkN.QA2zFnOVuUmVrwQPDoftsSqXMffK/Fm', 'uploads/image_2024-10-23_142921499.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
