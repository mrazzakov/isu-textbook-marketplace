-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2019 at 12:30 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `isu_tb_mp`
--

-- --------------------------------------------------------

--
-- Table structure for table `listings`
--

CREATE TABLE `listings` (
  `id` int(11) NOT NULL,
  `isbn` varchar(13) NOT NULL,
  `class_num` varchar(255) NOT NULL,
  `bk_title` varchar(255) NOT NULL,
  `bk_desc` varchar(1024) DEFAULT NULL,
  `bk_author` varchar(255) DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `bk_price` decimal(5,2) NOT NULL,
  `userid` int(11) NOT NULL,
  `bk_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `listings`
--

INSERT INTO `listings` (`id`, `isbn`, `class_num`, `bk_title`, `bk_desc`, `bk_author`, `create_date`, `bk_price`, `userid`, `bk_image`) VALUES
(97, '1234567890123', 'IT363', 'Test Title', 'This is a Test Book that we will be adding', 'Test McTest', '2019-04-22 03:30:09', '9.99', 47, 'uploads/97.png'),
(98, '0987654321098', 'IT213', 'Another Test Book', 'this is a random description', 'Hello World', '2019-04-22 03:31:25', '1.99', 47, NULL),
(105, '1234567890123', 'it534', 'hello', 'this is a random description', 'hello author', '2019-04-30 06:07:32', '9.99', 47, 'uploads/105.png'),
(106, '1234567890123', 'IT363', 'hello sdfgdfsg', 'this is a random description', 'hello author', '2019-04-30 06:26:09', '9.99', 47, NULL),
(107, '1234567890123', 'IT213', 'test book 2', 'this is a random description', 'hello author', '2019-04-30 06:46:06', '9.99', 47, NULL),
(108, '1234567890123', 'IT363', 'hello there test', '', 'hello author', '2019-04-30 06:46:28', '9.99', 47, NULL),
(133, '1234567890123', 'IT363', 'hello', 'this is a random description', 'hello author', '2019-04-30 07:14:01', '9.99', 47, 'uploads/133.png'),
(134, '1234567890123', 'IT363', 'hello', 'this is a random description', 'hello author', '2019-04-30 07:15:20', '9.99', 47, 'uploads/134.png');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `userid` int(11) NOT NULL,
  `class_num` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `validation_code` text NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `admin` bit(1) NOT NULL DEFAULT b'0',
  `strike` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `first_name`, `last_name`, `username`, `email`, `password`, `validation_code`, `active`, `admin`, `strike`) VALUES
(44, 'Tim', 'Ford', 'trford2', 'trford2@ilstu.edu', '202cb962ac59075b964b07152d234b70', '0', 1, b'0', 0),
(47, 'Mike', 'Razz', 'mrazz', 'mrazzak@ilstu.edu', '827ccb0eea8a706c4c34a16891f84e7b', '0', 1, b'1', 0),
(48, 'Tima', 'Forda', 'trford3', 'trford3@ilstu.edu', '202cb962ac59075b964b07152d234b70', '0', 1, b'0', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `listings`
--
ALTER TABLE `listings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `listings_userid_fk` (`userid`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`userid`,`class_num`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `listings`
--
ALTER TABLE `listings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `listings`
--
ALTER TABLE `listings`
  ADD CONSTRAINT `listings_userid_fk` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`);

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;