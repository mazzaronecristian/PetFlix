-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 03, 2023 at 09:14 AM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `petflix`
--

-- --------------------------------------------------------


--
-- Table structure for table `utenti`
--

CREATE TABLE `utenti` (
  `email` varchar(50) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `utenti`
--

INSERT INTO `utenti` (`email`, `pwd`) VALUES
('cristianmazzarone@gmail.com', 'Lavidaloca1!'),
('grosadini@gmail.com', 'Emilyctrlv1!');

-- --------------------------------------------------------

--
-- Table structure for table `schede`
--

CREATE TABLE `schede` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `utenti_schede`
--

CREATE TABLE `utenti_schede` (
  `scheda` int(11) NOT NULL,
  `utente` varchar(50) NOT NULL,
  PRIMARY KEY (`utente`, `scheda`),
  FOREIGN KEY (`utente`) REFERENCES `utenti`(`email`),
  FOREIGN KEY (`scheda`) REFERENCES `schede`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `impostazioni`
--

CREATE TABLE `impostazioni` (
  `id` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `scheda` int(11) NOT NULL,
  PRIMARY KEY (`id`, `scheda`),
  FOREIGN KEY (`scheda`) REFERENCES  `schede`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `orari`
--

CREATE TABLE `orari` (
  `id` int(11) NOT NULL,
  `controlFlag` bit(1) NOT NULL,
  `time` time NOT NULL,
  `scheda` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`scheda`) REFERENCES  `schede`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `pesi`
--

CREATE TABLE `pesi` (
  `id` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `date` date NOT NULL,
  `scheda` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`scheda`) REFERENCES  `schede`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- AUTO_INCREMENT for table `orari`
--
ALTER TABLE `orari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pesi`
--
ALTER TABLE `pesi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
