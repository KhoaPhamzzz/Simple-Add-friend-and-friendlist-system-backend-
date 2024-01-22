-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2023 at 01:43 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assign`
--

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `friend_id` int(11) NOT NULL,
  `friend_email` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL,
  `profile_name` varchar(30) NOT NULL,
  `date_started` date NOT NULL,
  `num_of_friends` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`friend_id`, `friend_email`, `password`, `profile_name`, `date_started`, `num_of_friends`) VALUES
(1, 'ayesha@gmail.com', '123', 'shoaib', '2023-05-20', 5),
(2, 'ayeshaEnglish@gmail.com', '123', 'ayesha', '2023-05-20', 0),
(3, 'shaebukhan34@gmail.com', '123', 'shaebu', '2023-05-20', 0),
(4, 'amir@gmail.com', '123', 'Amir khan', '2023-05-20', 0),
(5, 'shehroz@gmail.com', '123', 'Shehroz', '2023-05-20', 0),
(6, 'mohsin@gmail.com', '123', 'Mohsin', '2023-05-20', 0),
(7, 'khalid@gmail.com', '123', 'Khalid', '2023-05-20', 0),
(8, 'junaid@gmail.com', '123', 'Junaid', '2023-05-20', 0),
(9, 'maryam@gmail.com', '123', 'maryam', '2023-05-20', 0),
(10, 'yashfa@gmail.com', '123', 'yashfa', '2023-05-20', 0),
(11, 'sh@gmail.com', '123', 'shahid', '2023-05-20', 0),
(12, 'zunaira@gmail.com', '123', 'zunaira', '2023-05-20', 0),
(13, 'areeba@gmail.com', '123', 'Areeba', '2023-05-20', 0),
(14, 'saba@gmail.com', '123', 'Saba', '2023-05-20', 0),
(15, 'sehar@gmail.com', '123', 'Sehar', '2023-05-20', 0),
(16, 'laiba@gmai.com', '123', 'Laiba', '2023-05-20', 0),
(17, 'fatima@gmail.com', '123', 'Fatima', '2023-05-20', 0),
(18, 'zafar@gmail.com', '123', 'Zafar', '2023-05-20', 0),
(19, 'shahid@gmail.com', '123', 'Shahid', '2023-05-20', 0),
(20, 'sania@gmail.com', '123', 'Sania', '2023-05-20', 5);

-- --------------------------------------------------------

--
-- Table structure for table `myfriends`
--

CREATE TABLE `myfriends` (
  `id` int(11) NOT NULL,
  `friend_id1` int(11) NOT NULL,
  `friend_id2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `myfriends`
--

INSERT INTO `myfriends` (`id`, `friend_id1`, `friend_id2`) VALUES
(4, 2, 1),
(15, 17, 1),
(16, 17, 2),
(17, 17, 1),
(18, 17, 3),
(19, 17, 4),
(20, 17, 20),
(27, 0, 1),
(42, 20, 1),
(44, 20, 6),
(45, 20, 2),
(46, 20, 3),
(49, 20, 7),
(75, 1, 4),
(76, 1, 8),
(77, 1, 16),
(78, 1, 17),
(81, 1, 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`friend_id`);

--
-- Indexes for table `myfriends`
--
ALTER TABLE `myfriends`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `friend_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `myfriends`
--
ALTER TABLE `myfriends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
