-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2026 at 05:34 PM
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
-- Database: `u24611400_tripistry`
--

-- --------------------------------------------------------

--
-- Table structure for table `accommodations`
--

CREATE TABLE `accommodations` (
  `Accommodation_ID` int(11) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Type` varchar(100) NOT NULL,
  `Price_PN` decimal(10,2) NOT NULL CHECK (`Price_PN` > 0),
  `Image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accommodations`
--

INSERT INTO `accommodations` (`Accommodation_ID`, `Name`, `Type`, `Price_PN`, `Image`) VALUES
(1, 'Sea Point Hotel', 'Hotel', 1500.00, 'https://images.com/seapoint.jpg'),
(2, 'Kruger River Lodge', 'Lodge', 3500.00, 'https://images.com/krugerlodge.jpg'),
(3, 'Knysna Guesthouse', 'Guesthouse', 1200.00, 'https://images.com/knysna.jpg'),
(14, 'Granpanorama-Hotel Stephanshof', 'HotelPension', 1000.00, ''),
(15, '10- Bettzimmer im Restaurant Sternen', 'Apartment', 1000.00, 'https://media-v2.discover.swiss/rawmedia/ctd/8705a5326c050244a82e16e30f6b9c8c7ac93e85_9cea1a6d_5876_4e78_9355_8b0aec925087.jpeg'),
(16, '1100 APARTMENT', 'BedBreakfast', 1000.00, ''),
(17, '1477 Reichhalter', 'BedBreakfast', 1000.00, ''),
(18, '164 apt.', 'BedBreakfast', 1000.00, ''),
(19, '22 Summits Apartments', 'Apartment', 1000.00, 'https://cdn.tomas-travel.com/tds/repository/TDS00020010416503159/TDS00020010000158950/TDS00020015218339065.jpg'),
(20, '22 Summits Boutique Hotel', 'HotelPension', 1000.00, 'https://cdn.tomas-travel.com/tds/repository/TDS00020011844279793/TDS00020010000158950/TDS00020015648757944.jpg'),
(21, '25hours Hotel Langstrasse', 'HotelPension', 1000.00, 'https://www.zuerich.com/sites/default/files/web_zuerich_25hours_langstrasse_29434.jpg'),
(22, '25hours Hotel Langstrasse', 'HotelPension', 1000.00, 'https://www.zuerich.com/sites/default/files/web_zuerich_25hours_langstrasse_29434.jpg'),
(23, '25hours Hotel Zürich West', 'HotelPension', 1000.00, 'https://www.zuerich.com/sites/default/files/nethotel-images/490006770_14_de65df00-3976-41f3-a14e-59acb30a410e.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `Booking_ID` int(11) NOT NULL,
  `Package_ID` int(11) NOT NULL,
  `Booking_Date` date NOT NULL,
  `Start_Date` date NOT NULL,
  `End_Date` date NOT NULL,
  `Booking_Type` enum('Solo','Group') NOT NULL
) ;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`Booking_ID`, `Package_ID`, `Booking_Date`, `Start_Date`, `End_Date`, `Booking_Type`) VALUES
(1, 1, '2026-01-10', '2026-06-01', '2026-06-05', 'Solo'),
(2, 2, '2026-02-15', '2026-07-10', '2026-07-13', 'Solo'),
(3, 3, '2026-03-01', '2026-08-20', '2026-08-26', 'Group'),
(4, 3, '2026-03-01', '2026-08-20', '2026-08-26', 'Solo'),
(5, 1, '2026-03-10', '2026-09-01', '2026-09-05', 'Solo'),
(6, 2, '2026-04-05', '2026-10-15', '2026-10-18', 'Solo');

-- --------------------------------------------------------

--
-- Table structure for table `booking_travelers`
--

CREATE TABLE `booking_travelers` (
  `Booking_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Joined_Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_travelers`
--

INSERT INTO `booking_travelers` (`Booking_ID`, `User_ID`, `Joined_Date`) VALUES
(1, 1, '2026-01-10'),
(2, 2, '2026-02-15'),
(3, 1, '2026-03-01'),
(3, 2, '2026-03-02');

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `Destination_ID` int(11) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Country` varchar(100) NOT NULL,
  `Image` varchar(500) NOT NULL
) ;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`Destination_ID`, `Name`, `Country`, `Image`) VALUES
(1, 'Cape Town', 'South Africa', 'https://images.com/capetown.jpg'),
(2, 'Kruger National Park', 'South Africa', 'https://images.com/kruger.jpg'),
(3, 'Garden Route', 'South Africa', 'https://images.com/gardenroute.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `flights`
--

CREATE TABLE `flights` (
  `Flight_ID` int(11) NOT NULL,
  `Airline` varchar(100) NOT NULL,
  `Departure_Loc` varchar(100) NOT NULL,
  `Arrival_Loc` varchar(100) NOT NULL,
  `Time_Dept` datetime NOT NULL,
  `Time_Arrive` datetime NOT NULL,
  `Price` decimal(10,2) NOT NULL CHECK (`Price` > 0)
) ;

--
-- Dumping data for table `flights`
--

INSERT INTO `flights` (`Flight_ID`, `Airline`, `Departure_Loc`, `Arrival_Loc`, `Time_Dept`, `Time_Arrive`, `Price`) VALUES
(1, 'FlySafair', 'Johannesburg', 'Cape Town', '2026-06-01 08:00:00', '2026-06-01 10:00:00', 1800.00),
(2, 'Airlink', 'Johannesburg', 'Kruger Mpumalanga', '2026-06-02 11:00:00', '2026-06-02 12:30:00', 2500.00),
(3, 'FlySafair', 'Johannesburg', 'George', '2026-06-03 07:00:00', '2026-06-03 09:00:00', 1600.00),
(75, 'unknown', 'Kwajalein', '', '2026-05-20 08:45:00', '2026-05-20 09:05:00', 1000.00),
(76, 'Batik Air', 'Kuala Lumpur International Airport (klia)', 'Presidente Nicolau Lobato International', '2026-05-20 02:15:00', '2026-05-20 07:30:00', 1000.00),
(77, 'Pel-Air', 'Dubbo', 'Sydney Kingsford Smith Airport', '2026-05-20 00:20:00', '2026-05-20 01:09:00', 1000.00),
(78, 'Bangkok Airways', 'Suvarnabhumi International', 'Kansai International', '2026-05-20 00:30:00', '2026-05-20 07:55:00', 1000.00),
(79, 'SriLankan Airlines', 'Suvarnabhumi International', 'Kansai International', '2026-05-20 00:30:00', '2026-05-20 07:55:00', 1000.00),
(80, 'TAP Air Portugal', 'Suvarnabhumi International', 'Brussels Airport', '2026-05-20 00:05:00', '2026-05-20 07:15:00', 1000.00),
(81, 'All Nippon Airways', 'Suvarnabhumi International', 'Chu-Bu Centrair International (Central Japan International)', '2026-05-20 00:05:00', '2026-05-20 08:00:00', 1000.00),
(82, 'El Al', 'Suvarnabhumi International', 'Chu-Bu Centrair International (Central Japan International)', '2026-05-20 00:05:00', '2026-05-20 08:00:00', 1000.00),
(83, 'unknown', 'Adelaide International Airport', 'Port Pirie', '2026-05-20 00:35:00', '2026-05-20 01:01:00', 1000.00),
(84, 'Juneyao Air', 'Shanghai Pudong International', 'Haneda Airport', '2026-05-20 01:50:00', '2026-05-20 05:45:00', 1000.00),
(85, 'Air China', 'Shanghai Pudong International', 'Haneda Airport', '2026-05-20 01:50:00', '2026-05-20 05:45:00', 1000.00),
(86, 'Southwind Airlines', 'Orenburg', 'Antalya', '2026-05-20 01:10:00', '2026-05-20 03:35:00', 1000.00),
(87, 'Eastar Jet', 'Shanghai Pudong International', 'Jeju Airport', '2026-05-20 05:05:00', '2026-05-20 07:15:00', 1000.00),
(88, 'Korean Air', 'Shanghai Pudong International', 'Seoul (Incheon)', '2026-05-20 05:00:00', '2026-05-20 08:10:00', 1000.00),
(89, 'China Cargo Airlines', 'Shanghai Pudong International', 'Charles De Gaulle', '2026-05-20 04:55:00', '2026-05-20 10:35:00', 1000.00),
(90, 'Cathay Pacific', 'Shanghai Pudong International', 'Hong Kong International', '2026-05-20 04:55:00', '2026-05-20 08:05:00', 1000.00),
(91, 'China Cargo Airlines', 'Shanghai Pudong International', 'Suvarnabhumi International', '2026-05-20 04:50:00', '2026-05-20 08:10:00', 1000.00),
(92, 'SF Airlines', 'Shanghai Pudong International', 'Shenzhen', '2026-05-20 04:40:00', '2026-05-20 07:00:00', 1000.00),
(93, 'Cathay Pacific', 'Shanghai Pudong International', 'Zhengzhou', '2026-05-20 04:30:00', '2026-05-20 06:30:00', 1000.00),
(94, 'KlasJet', 'Shanghai Pudong International', 'Seoul (Incheon)', '2026-05-20 04:25:00', '2026-05-20 07:30:00', 1000.00),
(95, 'unknown', 'Port Macquarie', 'Lord Howe Island', '2026-05-20 07:00:00', '2026-05-20 08:44:00', 1000.00),
(96, 'Qantas', 'Port Macquarie', 'Sydney Kingsford Smith Airport', '2026-05-20 06:30:00', '2026-05-20 07:50:00', 1000.00),
(97, 'China Eastern Airlines', 'Port Macquarie', 'Sydney Kingsford Smith Airport', '2026-05-20 06:30:00', '2026-05-20 07:50:00', 1000.00),
(98, 'Air New Zealand', 'Port Macquarie', 'Sydney Kingsford Smith Airport', '2026-05-20 06:30:00', '2026-05-20 07:50:00', 1000.00),
(99, 'Emirates', 'Port Macquarie', 'Sydney Kingsford Smith Airport', '2026-05-20 06:30:00', '2026-05-20 07:50:00', 1000.00),
(100, 'Air Niugini', 'Jackson Field', 'Rabaul Airport', '2026-05-20 07:00:00', '2026-05-20 08:25:00', 1000.00),
(101, 'PNG Air', 'Jackson Field', 'Nadzab', '2026-05-20 07:00:00', '2026-05-20 08:10:00', 1000.00),
(102, 'PNG Air', 'Jackson Field', 'Daru', '2026-05-20 06:50:00', '2026-05-20 08:15:00', 1000.00),
(103, 'Air Niugini', 'Jackson Field', 'Brisbane International', '2026-05-20 06:30:00', '2026-05-20 09:40:00', 1000.00),
(104, 'Virgin Atlantic', 'Bangalore International Airport', 'Lohegaon', '2026-05-20 01:05:00', '2026-05-20 02:35:00', 1000.00),
(105, 'Qantas', 'Bangalore International Airport', 'Lohegaon', '2026-05-20 01:05:00', '2026-05-20 02:35:00', 1000.00),
(106, 'Japan Airlines', 'Bangalore International Airport', 'Lohegaon', '2026-05-20 01:05:00', '2026-05-20 02:35:00', 1000.00),
(107, 'Rex', 'Merimbula', 'Moruya', '2026-05-20 06:30:00', '2026-05-20 07:00:00', 1000.00),
(108, 'Fiji Airways', 'Nadi International', 'Sydney Kingsford Smith Airport', '2026-05-20 09:00:00', '2026-05-20 12:05:00', 1000.00),
(109, 'Qantas', 'Nadi International', 'Sydney Kingsford Smith Airport', '2026-05-20 09:00:00', '2026-05-20 12:05:00', 1000.00),
(110, 'Air Niugini', 'Nadi International', 'Henderson International', '2026-05-20 08:30:00', '2026-05-20 10:30:00', 1000.00),
(111, 'Fiji Airways', 'Nadi International', 'Henderson International', '2026-05-20 08:30:00', '2026-05-20 10:30:00', 1000.00),
(112, 'Fiji Airways', 'Nadi International', 'Melbourne - Tullamarine Airport', '2026-05-20 08:30:00', '2026-05-20 12:25:00', 1000.00),
(113, 'Qantas', 'Nadi International', 'Melbourne - Tullamarine Airport', '2026-05-20 08:30:00', '2026-05-20 12:25:00', 1000.00),
(114, 'Fiji Airways', 'Nadi International', 'Brisbane International', '2026-05-20 08:15:00', '2026-05-20 10:35:00', 1000.00),
(115, 'Qantas', 'Nadi International', 'Brisbane International', '2026-05-20 08:15:00', '2026-05-20 10:35:00', 1000.00),
(116, 'Qantas', 'Mildura', 'Melbourne - Tullamarine Airport', '2026-05-20 06:45:00', '2026-05-20 08:00:00', 1000.00),
(117, 'China Eastern Airlines', 'Mildura', 'Melbourne - Tullamarine Airport', '2026-05-20 06:45:00', '2026-05-20 08:00:00', 1000.00),
(118, 'Emirates', 'Mildura', 'Melbourne - Tullamarine Airport', '2026-05-20 06:45:00', '2026-05-20 08:00:00', 1000.00),
(119, 'Air New Zealand', 'Mildura', 'Melbourne - Tullamarine Airport', '2026-05-20 06:45:00', '2026-05-20 08:00:00', 1000.00),
(120, 'LATAM Airlines', 'Mildura', 'Melbourne - Tullamarine Airport', '2026-05-20 06:45:00', '2026-05-20 08:00:00', 1000.00),
(121, 'Rex', 'Mildura', 'Melbourne - Tullamarine Airport', '2026-05-20 06:30:00', '2026-05-20 07:50:00', 1000.00),
(122, 'Qantas', 'Mildura', 'Sydney Kingsford Smith Airport', '2026-05-20 06:30:00', '2026-05-20 08:25:00', 1000.00),
(123, 'Philippine Airlines', 'Techo International Airport', 'Ninoy Aquino International', '2026-05-20 01:15:00', '2026-05-20 05:05:00', 1000.00),
(124, 'Singapore Airlines', 'Singapore Changi', 'Ninoy Aquino International', '2026-05-20 00:35:00', '2026-05-20 04:20:00', 1000.00),
(125, 'Cebu Pacific', 'Ninoy Aquino International', 'Noibai International', '2026-05-20 05:05:00', '2026-05-20 07:40:00', 1000.00),
(126, 'Philippine Airlines', 'Ninoy Aquino International', 'Mactan-Cebu International', '2026-05-20 05:00:00', '2026-05-20 06:25:00', 1000.00),
(127, 'Malaysia Airlines', 'Ninoy Aquino International', 'Mactan-Cebu International', '2026-05-20 05:00:00', '2026-05-20 06:25:00', 1000.00),
(128, 'China Airlines', 'Ninoy Aquino International', 'Mactan-Cebu International', '2026-05-20 05:00:00', '2026-05-20 06:25:00', 1000.00),
(129, 'Philippine Airlines', 'Ninoy Aquino International', 'Dipolog', '2026-05-20 05:00:00', '2026-05-20 06:30:00', 1000.00),
(130, 'Cebu Pacific', 'Ninoy Aquino International', 'Cagayan De Oro Domestic Airport', '2026-05-20 04:55:00', '2026-05-20 06:40:00', 1000.00),
(131, 'Philippine Airlines', 'Ninoy Aquino International', 'Tagbilaran', '2026-05-20 04:50:00', '2026-05-20 06:20:00', 1000.00),
(132, 'All Nippon Airways', 'Ninoy Aquino International', 'Tagbilaran', '2026-05-20 04:50:00', '2026-05-20 06:20:00', 1000.00),
(133, 'Malaysia Airlines', 'Ninoy Aquino International', 'Tagbilaran', '2026-05-20 04:50:00', '2026-05-20 06:20:00', 1000.00),
(134, 'Cebu Pacific', 'Ninoy Aquino International', 'Mactan-Cebu International', '2026-05-20 04:50:00', '2026-05-20 06:25:00', 1000.00),
(135, 'Philippine Airlines', 'Ninoy Aquino International', 'Francisco Bangoy International', '2026-05-20 04:45:00', '2026-05-20 06:40:00', 1000.00),
(136, 'Malaysia Airlines', 'Ninoy Aquino International', 'Francisco Bangoy International', '2026-05-20 04:45:00', '2026-05-20 06:40:00', 1000.00),
(137, 'China Airlines', 'Ninoy Aquino International', 'Francisco Bangoy International', '2026-05-20 04:45:00', '2026-05-20 06:40:00', 1000.00),
(138, 'Philippine Airlines', 'Ninoy Aquino International', 'Labo', '2026-05-20 04:40:00', '2026-05-20 06:20:00', 1000.00),
(139, 'Singapore Airlines', 'Ninoy Aquino International', 'Labo', '2026-05-20 04:40:00', '2026-05-20 06:20:00', 1000.00),
(140, 'Philippines AirAsia', 'Ninoy Aquino International', 'Narita International Airport', '2026-05-20 04:35:00', '2026-05-20 10:10:00', 1000.00),
(141, 'Cebu Pacific', 'Ninoy Aquino International', 'Puerto Princesa', '2026-05-20 04:35:00', '2026-05-20 06:05:00', 1000.00),
(142, 'Cebu Pacific', 'Ninoy Aquino International', 'Butuan', '2026-05-20 04:30:00', '2026-05-20 06:15:00', 1000.00),
(143, 'Cebu Pacific', 'Ninoy Aquino International', 'Laoag International Airport', '2026-05-20 04:25:00', '2026-05-20 05:40:00', 1000.00),
(144, 'Cebu Pacific', 'Ninoy Aquino International', 'Francisco Bangoy International', '2026-05-20 04:20:00', '2026-05-20 06:20:00', 1000.00),
(145, 'Cebu Pacific', 'Ninoy Aquino International', 'Bacolod', '2026-05-20 04:20:00', '2026-05-20 05:45:00', 1000.00),
(146, 'Philippine Airlines', 'Ninoy Aquino International', 'Mactan-Cebu International', '2026-05-20 04:15:00', '2026-05-20 05:40:00', 1000.00),
(147, 'Royal Brunei Airlines', 'Ninoy Aquino International', 'Mactan-Cebu International', '2026-05-20 04:15:00', '2026-05-20 05:40:00', 1000.00),
(148, 'Malaysia Airlines', 'Ninoy Aquino International', 'Mactan-Cebu International', '2026-05-20 04:15:00', '2026-05-20 05:40:00', 1000.00),
(149, 'China Airlines', 'Ninoy Aquino International', 'Mactan-Cebu International', '2026-05-20 04:15:00', '2026-05-20 05:40:00', 1000.00),
(150, 'Philippine Airlines', 'Ninoy Aquino International', 'D.Z. Romualdez', '2026-05-20 04:15:00', '2026-05-20 05:40:00', 1000.00),
(151, 'Malaysia Airlines', 'Ninoy Aquino International', 'D.Z. Romualdez', '2026-05-20 04:15:00', '2026-05-20 05:40:00', 1000.00),
(152, 'All Nippon Airways', 'Ninoy Aquino International', 'D.Z. Romualdez', '2026-05-20 04:15:00', '2026-05-20 05:40:00', 1000.00),
(153, 'Philippines AirAsia', 'Ninoy Aquino International', 'Iloilo International', '2026-05-20 04:10:00', '2026-05-20 05:25:00', 1000.00),
(154, 'Cebu Pacific', 'Ninoy Aquino International', 'Zamboanga International', '2026-05-20 04:10:00', '2026-05-20 06:00:00', 1000.00),
(155, 'Maldivian', 'Malé International Airport', 'Chengdu Tianfu International Airport', '2026-05-20 01:55:00', '2026-05-20 10:55:00', 1000.00),
(156, 'Virgin Australia', 'Mackay', 'Brisbane International', '2026-05-20 06:20:00', '2026-05-20 07:50:00', 1000.00),
(157, 'United Airlines', 'Mackay', 'Brisbane International', '2026-05-20 06:20:00', '2026-05-20 07:50:00', 1000.00),
(158, 'Singapore Airlines', 'Mackay', 'Brisbane International', '2026-05-20 06:20:00', '2026-05-20 07:50:00', 1000.00),
(159, 'Qatar Airways', 'Mackay', 'Brisbane International', '2026-05-20 06:20:00', '2026-05-20 07:50:00', 1000.00),
(160, 'Air Niugini', 'Mackay', 'Brisbane International', '2026-05-20 06:20:00', '2026-05-20 07:50:00', 1000.00),
(161, 'China Southern Airlines', 'Mackay', 'Brisbane International', '2026-05-20 06:20:00', '2026-05-20 07:50:00', 1000.00),
(162, 'Air Canada', 'Mackay', 'Brisbane International', '2026-05-20 06:20:00', '2026-05-20 07:50:00', 1000.00),
(163, 'Rex', 'Mount Gambier', 'Melbourne - Tullamarine Airport', '2026-05-20 06:30:00', '2026-05-20 08:05:00', 1000.00),
(164, 'Qantas', 'Melbourne - Tullamarine Airport', 'Canberra', '2026-05-20 07:05:00', '2026-05-20 08:25:00', 1000.00),
(165, 'Jetstar', 'Melbourne - Tullamarine Airport', 'Maroochydore', '2026-05-20 07:05:00', '2026-05-20 09:25:00', 1000.00),
(166, 'Jetstar', 'Melbourne - Tullamarine Airport', 'Adelaide International Airport', '2026-05-20 07:05:00', '2026-05-20 08:00:00', 1000.00),
(167, 'Qantas', 'Melbourne - Tullamarine Airport', 'Brisbane International', '2026-05-20 07:00:00', '2026-05-20 09:20:00', 1000.00),
(168, 'Qantas', 'Melbourne - Tullamarine Airport', 'Sydney Kingsford Smith Airport', '2026-05-20 07:00:00', '2026-05-20 08:40:00', 1000.00),
(169, 'Rex', 'Melbourne - Tullamarine Airport', 'Devonport', '2026-05-20 07:00:00', '2026-05-20 08:20:00', 1000.00),
(170, 'Virgin Australia', 'Melbourne - Tullamarine Airport', 'Sydney Kingsford Smith Airport', '2026-05-20 07:00:00', '2026-05-20 08:25:00', 1000.00),
(171, 'Batik Air Malaysia', 'Melbourne - Tullamarine Airport', 'Ngurah Rai International', '2026-05-20 07:00:00', '2026-05-20 11:25:00', 1000.00),
(172, 'Batik Air', 'Melbourne - Tullamarine Airport', 'Ngurah Rai International', '2026-05-20 07:00:00', '2026-05-20 11:25:00', 1000.00);

-- --------------------------------------------------------

--
-- Table structure for table `group_bookings`
--

CREATE TABLE `group_bookings` (
  `Booking_ID` int(11) NOT NULL,
  `Guest_Limit` int(11) NOT NULL CHECK (`Guest_Limit` > 0),
  `Guest_Count` int(11) NOT NULL,
  `Agency_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `group_bookings`
--

INSERT INTO `group_bookings` (`Booking_ID`, `Guest_Limit`, `Guest_Count`, `Agency_ID`) VALUES
(3, 10, 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `Package_ID` int(11) NOT NULL,
  `Agency_ID` int(11) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Price` decimal(10,2) NOT NULL CHECK (`Price` > 0),
  `Description` text NOT NULL,
  `Duration` int(11) NOT NULL CHECK (`Duration` > 0)
) ;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`Package_ID`, `Agency_ID`, `Name`, `Price`, `Description`, `Duration`) VALUES
(1, 3, 'Cape Town Getaway', 12500.00, 'Explore the Mother City with Table Mountain, beaches, and wine tours.', 5),
(2, 3, 'Kruger Safari Experience', 22000.00, 'Big 5 game drives, luxury lodge, all meals included.', 4),
(3, 3, 'Garden Route Road Trip', 18000.00, 'Scenic coastal drive from Cape Town to Gqeberha.', 7);

-- --------------------------------------------------------

--
-- Table structure for table `package_accommodations`
--

CREATE TABLE `package_accommodations` (
  `Package_ID` int(11) NOT NULL,
  `Accommodation_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package_accommodations`
--

INSERT INTO `package_accommodations` (`Package_ID`, `Accommodation_ID`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `package_attractions`
--

CREATE TABLE `package_attractions` (
  `Package_ID` int(11) NOT NULL,
  `Attraction_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package_attractions`
--

INSERT INTO `package_attractions` (`Package_ID`, `Attraction_ID`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 4),
(2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `package_destinations`
--

CREATE TABLE `package_destinations` (
  `Package_ID` int(11) NOT NULL,
  `Destination_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package_destinations`
--

INSERT INTO `package_destinations` (`Package_ID`, `Destination_ID`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `package_flights`
--

CREATE TABLE `package_flights` (
  `Package_ID` int(11) NOT NULL,
  `Flight_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package_flights`
--

INSERT INTO `package_flights` (`Package_ID`, `Flight_ID`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `package_images`
--

CREATE TABLE `package_images` (
  `Package_ID` int(11) NOT NULL,
  `Image_URL` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package_images`
--

INSERT INTO `package_images` (`Package_ID`, `Image_URL`) VALUES
(1, 'https://images.com/capetown_1.jpg'),
(1, 'https://images.com/capetown_2.jpg'),
(1, 'https://images.com/capetown_3.jpg'),
(2, 'https://images.com/kruger_1.jpg'),
(2, 'https://images.com/kruger_2.jpg'),
(3, 'https://images.com/gardenroute_1.jpg'),
(3, 'https://images.com/gardenroute_2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `package_restaurants`
--

CREATE TABLE `package_restaurants` (
  `Package_ID` int(11) NOT NULL,
  `Restaurant_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package_restaurants`
--

INSERT INTO `package_restaurants` (`Package_ID`, `Restaurant_ID`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `Restaurant_ID` int(11) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Cuisine` varchar(100) NOT NULL,
  `Image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`Restaurant_ID`, `Name`, `Cuisine`, `Image`) VALUES
(1, 'The Test Kitchen', 'Fine Dining', 'https://images.com/testkitchen.jpg'),
(2, 'Cattle Baron', 'Steakhouse', 'https://images.com/cattlebaron.jpg'),
(3, 'Freshline Fisheries', 'Seafood', 'https://images.com/freshline.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `Review_ID` int(11) NOT NULL,
  `Booking_ID` int(11) NOT NULL,
  `Rating` int(11) NOT NULL CHECK (`Rating` >= 1 and `Rating` <= 5),
  `Comment` text NOT NULL,
  `Date` date NOT NULL,
  `User_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`Review_ID`, `Booking_ID`, `Rating`, `Comment`, `Date`, `User_ID`) VALUES
(5, 1, 5, 'Cape Town was incredible! The itinerary was well-planned and the hotel had stunning views of Table Mountain.', '2026-06-10', 1),
(6, 2, 4, 'The Kruger safari was unforgettable. Saw all Big 5! Would have liked an extra game drive though.', '2026-07-18', 2),
(7, 3, 5, 'Garden Route road trip was the best group experience ever. Made new friends and the scenery was breathtaking.', '2026-09-01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `solo_bookings`
--

CREATE TABLE `solo_bookings` (
  `Booking_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `solo_bookings`
--

INSERT INTO `solo_bookings` (`Booking_ID`) VALUES
(1),
(2);

-- --------------------------------------------------------

--
-- Table structure for table `tourist_attractions`
--

CREATE TABLE `tourist_attractions` (
  `Attraction_ID` int(11) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Image` varchar(500) NOT NULL
) ;

--
-- Dumping data for table `tourist_attractions`
--

INSERT INTO `tourist_attractions` (`Attraction_ID`, `Name`, `Image`) VALUES
(1, 'Table Mountain', 'https://images.com/table_mountain.jpg'),
(2, 'Boulders Beach', 'https://images.com/boulders_beach.jpg'),
(3, 'V&A Waterfront', 'https://images.com/va_waterfront.jpg'),
(4, 'Kruger Gate', 'https://images.com/kruger_gate.jpg'),
(5, 'Blyde River Canyon', 'https://images.com/blyde_canyon.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Password_Hash` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Cell` varchar(20) NOT NULL,
  `Type` enum('Agency','Traveller') NOT NULL
) ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_ID`, `Name`, `Password_Hash`, `Email`, `Cell`, `Type`) VALUES
(1, 'Alice Mabena', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy', 'alice.mabena@gmail.com', '+27831234567', 'Traveller'),
(2, 'Ravi Naidoo', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy', 'ravi.naidoo@outlook.com', '+27829876543', 'Traveller'),
(3, 'Safari & Sun Agency', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy', 'bookings@safarisun.co.za', '+27213456789', 'Agency');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accommodations`
--
ALTER TABLE `accommodations`
  ADD PRIMARY KEY (`Accommodation_ID`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`Booking_ID`),
  ADD KEY `Package_ID` (`Package_ID`);

--
-- Indexes for table `booking_travelers`
--
ALTER TABLE `booking_travelers`
  ADD PRIMARY KEY (`Booking_ID`,`User_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`Destination_ID`);

--
-- Indexes for table `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`Flight_ID`);

--
-- Indexes for table `group_bookings`
--
ALTER TABLE `group_bookings`
  ADD PRIMARY KEY (`Booking_ID`),
  ADD KEY `FK_GroupBooking_Agency` (`Agency_ID`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`Package_ID`),
  ADD KEY `Agency_ID` (`Agency_ID`);

--
-- Indexes for table `package_accommodations`
--
ALTER TABLE `package_accommodations`
  ADD PRIMARY KEY (`Package_ID`,`Accommodation_ID`),
  ADD KEY `Accommodation_ID` (`Accommodation_ID`);

--
-- Indexes for table `package_attractions`
--
ALTER TABLE `package_attractions`
  ADD PRIMARY KEY (`Package_ID`,`Attraction_ID`),
  ADD KEY `Attraction_ID` (`Attraction_ID`);

--
-- Indexes for table `package_destinations`
--
ALTER TABLE `package_destinations`
  ADD PRIMARY KEY (`Package_ID`,`Destination_ID`),
  ADD KEY `Destination_ID` (`Destination_ID`);

--
-- Indexes for table `package_flights`
--
ALTER TABLE `package_flights`
  ADD PRIMARY KEY (`Package_ID`,`Flight_ID`),
  ADD KEY `Flight_ID` (`Flight_ID`);

--
-- Indexes for table `package_images`
--
ALTER TABLE `package_images`
  ADD PRIMARY KEY (`Package_ID`,`Image_URL`);

--
-- Indexes for table `package_restaurants`
--
ALTER TABLE `package_restaurants`
  ADD PRIMARY KEY (`Package_ID`,`Restaurant_ID`),
  ADD KEY `Restaurant_ID` (`Restaurant_ID`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`Restaurant_ID`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`Review_ID`,`Booking_ID`),
  ADD UNIQUE KEY `Booking_ID` (`Booking_ID`),
  ADD KEY `FK_Review_User` (`User_ID`);

--
-- Indexes for table `solo_bookings`
--
ALTER TABLE `solo_bookings`
  ADD PRIMARY KEY (`Booking_ID`);

--
-- Indexes for table `tourist_attractions`
--
ALTER TABLE `tourist_attractions`
  ADD PRIMARY KEY (`Attraction_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accommodations`
--
ALTER TABLE `accommodations`
  MODIFY `Accommodation_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `Booking_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `Destination_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flights`
--
ALTER TABLE `flights`
  MODIFY `Flight_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `Package_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `Restaurant_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `Review_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tourist_attractions`
--
ALTER TABLE `tourist_attractions`
  MODIFY `Attraction_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_fk1` FOREIGN KEY (`Package_ID`) REFERENCES `packages` (`Package_ID`) ON DELETE CASCADE;

--
-- Constraints for table `booking_travelers`
--
ALTER TABLE `booking_travelers`
  ADD CONSTRAINT `booking_travelers_fk1` FOREIGN KEY (`Booking_ID`) REFERENCES `bookings` (`Booking_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_travelers_fk2` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE;

--
-- Constraints for table `group_bookings`
--
ALTER TABLE `group_bookings`
  ADD CONSTRAINT `FK_GroupBooking_Agency` FOREIGN KEY (`Agency_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_bookings_fk1` FOREIGN KEY (`Booking_ID`) REFERENCES `bookings` (`Booking_ID`) ON DELETE CASCADE;

--
-- Constraints for table `packages`
--
ALTER TABLE `packages`
  ADD CONSTRAINT `packages_fk1` FOREIGN KEY (`Agency_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE;

--
-- Constraints for table `package_accommodations`
--
ALTER TABLE `package_accommodations`
  ADD CONSTRAINT `package_accommodations_fk1` FOREIGN KEY (`Package_ID`) REFERENCES `packages` (`Package_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `package_accommodations_fk2` FOREIGN KEY (`Accommodation_ID`) REFERENCES `accommodations` (`Accommodation_ID`) ON DELETE CASCADE;

--
-- Constraints for table `package_attractions`
--
ALTER TABLE `package_attractions`
  ADD CONSTRAINT `package_attractions_fk1` FOREIGN KEY (`Package_ID`) REFERENCES `packages` (`Package_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `package_attractions_fk2` FOREIGN KEY (`Attraction_ID`) REFERENCES `tourist_attractions` (`Attraction_ID`) ON DELETE CASCADE;

--
-- Constraints for table `package_destinations`
--
ALTER TABLE `package_destinations`
  ADD CONSTRAINT `package_destinations_fk1` FOREIGN KEY (`Package_ID`) REFERENCES `packages` (`Package_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `package_destinations_fk2` FOREIGN KEY (`Destination_ID`) REFERENCES `destinations` (`Destination_ID`) ON DELETE CASCADE;

--
-- Constraints for table `package_flights`
--
ALTER TABLE `package_flights`
  ADD CONSTRAINT `package_flights_fk1` FOREIGN KEY (`Package_ID`) REFERENCES `packages` (`Package_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `package_flights_fk2` FOREIGN KEY (`Flight_ID`) REFERENCES `flights` (`Flight_ID`) ON DELETE CASCADE;

--
-- Constraints for table `package_images`
--
ALTER TABLE `package_images`
  ADD CONSTRAINT `package_images_fk1` FOREIGN KEY (`Package_ID`) REFERENCES `packages` (`Package_ID`) ON DELETE CASCADE;

--
-- Constraints for table `package_restaurants`
--
ALTER TABLE `package_restaurants`
  ADD CONSTRAINT `package_restaurants_fk1` FOREIGN KEY (`Package_ID`) REFERENCES `packages` (`Package_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `package_restaurants_fk2` FOREIGN KEY (`Restaurant_ID`) REFERENCES `restaurants` (`Restaurant_ID`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `FK_Review_User` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_fk1` FOREIGN KEY (`Booking_ID`) REFERENCES `bookings` (`Booking_ID`) ON DELETE CASCADE;

--
-- Constraints for table `solo_bookings`
--
ALTER TABLE `solo_bookings`
  ADD CONSTRAINT `solo_bookings_fk1` FOREIGN KEY (`Booking_ID`) REFERENCES `bookings` (`Booking_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
