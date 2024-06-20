-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2024 at 05:25 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tudelft_vragendb`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

CREATE TABLE `chapters` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `optionmcms`
--

CREATE TABLE `optionmcms` (
  `ID` int(11) NOT NULL,
  `OptionID` int(11) DEFAULT NULL,
  `OptionNumber` int(11) NOT NULL,
  `Option` varchar(50) DEFAULT NULL,
  `OptionPoints` int(11) DEFAULT NULL,
  `OptionFeedback` varchar(50) DEFAULT NULL,
  `OptionRequired` tinyint(1) DEFAULT NULL,
  `OptionExpression` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pool`
--

CREATE TABLE `pool` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` int(11) NOT NULL,
  `type` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `type`) VALUES
(1, 'MC'),
(2, 'MS'),
(3, 'WR'),
(4, 'TF');

-- --------------------------------------------------------

--
-- Table structure for table `vraag`
--

CREATE TABLE `vraag` (
  `ID` int(11) NOT NULL,
  `Type` varchar(2) DEFAULT NULL,
  `Title` varchar(50) DEFAULT NULL,
  `Points` int(11) DEFAULT NULL,
  `Time` int(11) DEFAULT NULL,
  `Difficulty` int(1) DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `QuestionText` varchar(6000) DEFAULT NULL,
  `Feedback` varchar(6000) DEFAULT NULL,
  `Hint` varchar(255) DEFAULT NULL,
  `Pool` varchar(255) DEFAULT NULL,
  `Tags` varchar(255) DEFAULT NULL,
  `Courses` varchar(255) DEFAULT NULL,
  `Chapters` varchar(255) DEFAULT NULL,
  `Categories` varchar(255) DEFAULT NULL,
  `Exams` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vraagmcms`
--

CREATE TABLE `vraagmcms` (
  `ID` int(11) NOT NULL,
  `VraagID` int(11) DEFAULT NULL,
  `NumberOptions` int(11) DEFAULT NULL,
  `OptionUnique` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vraagtf`
--

CREATE TABLE `vraagtf` (
  `ID` int(11) NOT NULL,
  `VraagID` int(5) DEFAULT NULL,
  `True` varchar(50) DEFAULT NULL,
  `TrueFeedback` varchar(255) DEFAULT NULL,
  `False` varchar(50) DEFAULT NULL,
  `FalseFeedback` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vraagwr`
--

CREATE TABLE `vraagwr` (
  `ID` int(11) NOT NULL,
  `VraagID` int(11) DEFAULT NULL,
  `InitialText` varchar(255) DEFAULT NULL,
  `AnswerKey` varchar(255) DEFAULT NULL,
  `AnswerType` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `optionmcms`
--
ALTER TABLE `optionmcms`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `pool`
--
ALTER TABLE `pool`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vraag`
--
ALTER TABLE `vraag`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `vraagmcms`
--
ALTER TABLE `vraagmcms`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `vraagtf`
--
ALTER TABLE `vraagtf`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `vraagwr`
--
ALTER TABLE `vraagwr`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=908;

--
-- AUTO_INCREMENT for table `chapters`
--
ALTER TABLE `chapters`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=294;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `optionmcms`
--
ALTER TABLE `optionmcms`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25068;

--
-- AUTO_INCREMENT for table `pool`
--
ALTER TABLE `pool`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=800;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=256;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vraag`
--
ALTER TABLE `vraag`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4682;

--
-- AUTO_INCREMENT for table `vraagmcms`
--
ALTER TABLE `vraagmcms`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3300;

--
-- AUTO_INCREMENT for table `vraagtf`
--
ALTER TABLE `vraagtf`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1177;

--
-- AUTO_INCREMENT for table `vraagwr`
--
ALTER TABLE `vraagwr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
