/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-12.2.2-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: Triptistry
-- ------------------------------------------------------
-- Server version	12.2.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `accommodations`
--

DROP TABLE IF EXISTS `accommodations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `accommodations` (
  `Accommodation_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) NOT NULL,
  `Type` varchar(100) NOT NULL,
  `Price_PN` decimal(10,2) NOT NULL CHECK (`Price_PN` > 0),
  `Image` varchar(500) NOT NULL,
  PRIMARY KEY (`Accommodation_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accommodations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `accommodations` WRITE;
/*!40000 ALTER TABLE `accommodations` DISABLE KEYS */;
INSERT INTO `accommodations` VALUES
(1,'Sea Point Hotel','Hotel',1500.00,'https://images.com/seapoint.jpg'),
(2,'Kruger River Lodge','Lodge',3500.00,'https://images.com/krugerlodge.jpg'),
(3,'Knysna Guesthouse','Guesthouse',1200.00,'https://images.com/knysna.jpg');
/*!40000 ALTER TABLE `accommodations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `booking_travelers`
--

DROP TABLE IF EXISTS `booking_travelers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_travelers` (
  `Booking_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Joined_Date` date NOT NULL,
  PRIMARY KEY (`Booking_ID`,`User_ID`),
  KEY `User_ID` (`User_ID`),
  CONSTRAINT `booking_travelers_fk1` FOREIGN KEY (`Booking_ID`) REFERENCES `bookings` (`Booking_ID`) ON DELETE CASCADE,
  CONSTRAINT `booking_travelers_fk2` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booking_travelers`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `booking_travelers` WRITE;
/*!40000 ALTER TABLE `booking_travelers` DISABLE KEYS */;
INSERT INTO `booking_travelers` VALUES
(1,1,'2026-01-10'),
(2,2,'2026-02-15'),
(3,1,'2026-03-01'),
(3,2,'2026-03-02');
/*!40000 ALTER TABLE `booking_travelers` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `bookings` (
  `Booking_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Package_ID` int(11) NOT NULL,
  `Booking_Date` date NOT NULL,
  `Start_Date` date NOT NULL,
  `End_Date` date NOT NULL,
  `Booking_Type` enum('Solo','Group') NOT NULL,
  PRIMARY KEY (`Booking_ID`),
  KEY `Package_ID` (`Package_ID`),
  CONSTRAINT `bookings_fk1` FOREIGN KEY (`Package_ID`) REFERENCES `packages` (`Package_ID`) ON DELETE CASCADE,
  CONSTRAINT `CHK_End_After_Start` CHECK (`End_Date` > `Start_Date`),
  CONSTRAINT `CHK_Booking_Before_Start` CHECK (`Booking_Date` <= `Start_Date`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
INSERT INTO `bookings` VALUES
(1,1,'2026-01-10','2026-06-01','2026-06-05','Solo'),
(2,2,'2026-02-15','2026-07-10','2026-07-13','Solo'),
(3,3,'2026-03-01','2026-08-20','2026-08-26','Group'),
(4,3,'2026-03-01','2026-08-20','2026-08-26','Solo'),
(5,1,'2026-03-10','2026-09-01','2026-09-05','Solo'),
(6,2,'2026-04-05','2026-10-15','2026-10-18','Solo');
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `destinations`
--

DROP TABLE IF EXISTS `destinations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `destinations` (
  `Destination_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) NOT NULL,
  `Country` varchar(100) NOT NULL,
  `Image` varchar(500) NOT NULL,
  PRIMARY KEY (`Destination_ID`),
  CONSTRAINT `CHK_Name_Length` CHECK (octet_length(`Name`) >= 2)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `destinations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `destinations` WRITE;
/*!40000 ALTER TABLE `destinations` DISABLE KEYS */;
INSERT INTO `destinations` VALUES
(1,'Cape Town','South Africa','https://images.com/capetown.jpg'),
(2,'Kruger National Park','South Africa','https://images.com/kruger.jpg'),
(3,'Garden Route','South Africa','https://images.com/gardenroute.jpg');
/*!40000 ALTER TABLE `destinations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `flights`
--

DROP TABLE IF EXISTS `flights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `flights` (
  `Flight_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Airline` varchar(100) NOT NULL,
  `Departure_Loc` varchar(100) NOT NULL,
  `Arrival_Loc` varchar(100) NOT NULL,
  `Time_Dept` datetime NOT NULL,
  `Time_Arrive` datetime NOT NULL,
  `Price` decimal(10,2) NOT NULL CHECK (`Price` > 0),
  PRIMARY KEY (`Flight_ID`),
  CONSTRAINT `CHK_Arrival_After_Departure` CHECK (`Time_Arrive` > `Time_Dept`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flights`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `flights` WRITE;
/*!40000 ALTER TABLE `flights` DISABLE KEYS */;
INSERT INTO `flights` VALUES
(1,'FlySafair','Johannesburg','Cape Town','2026-06-01 08:00:00','2026-06-01 10:00:00',1800.00),
(2,'Airlink','Johannesburg','Kruger Mpumalanga','2026-06-02 11:00:00','2026-06-02 12:30:00',2500.00),
(3,'FlySafair','Johannesburg','George','2026-06-03 07:00:00','2026-06-03 09:00:00',1600.00);
/*!40000 ALTER TABLE `flights` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `group_bookings`
--

DROP TABLE IF EXISTS `group_bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_bookings` (
  `Booking_ID` int(11) NOT NULL,
  `Guest_Limit` int(11) NOT NULL CHECK (`Guest_Limit` > 0),
  `Guest_Count` int(11) NOT NULL,
  `Agency_ID` int(11) NOT NULL,
  PRIMARY KEY (`Booking_ID`),
  KEY `FK_GroupBooking_Agency` (`Agency_ID`),
  CONSTRAINT `group_bookings_fk1` FOREIGN KEY (`Booking_ID`) REFERENCES `bookings` (`Booking_ID`) ON DELETE CASCADE,
  CONSTRAINT `FK_GroupBooking_Agency` FOREIGN KEY (`Agency_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_bookings`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `group_bookings` WRITE;
/*!40000 ALTER TABLE `group_bookings` DISABLE KEYS */;
INSERT INTO `group_bookings` VALUES
(3,10,4,3);
/*!40000 ALTER TABLE `group_bookings` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `package_accommodations`
--

DROP TABLE IF EXISTS `package_accommodations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `package_accommodations` (
  `Package_ID` int(11) NOT NULL,
  `Accommodation_ID` int(11) NOT NULL,
  PRIMARY KEY (`Package_ID`,`Accommodation_ID`),
  KEY `Accommodation_ID` (`Accommodation_ID`),
  CONSTRAINT `package_accommodations_fk1` FOREIGN KEY (`Package_ID`) REFERENCES `packages` (`Package_ID`) ON DELETE CASCADE,
  CONSTRAINT `package_accommodations_fk2` FOREIGN KEY (`Accommodation_ID`) REFERENCES `accommodations` (`Accommodation_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `package_accommodations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `package_accommodations` WRITE;
/*!40000 ALTER TABLE `package_accommodations` DISABLE KEYS */;
INSERT INTO `package_accommodations` VALUES
(1,1),
(2,2),
(3,3);
/*!40000 ALTER TABLE `package_accommodations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `package_attractions`
--

DROP TABLE IF EXISTS `package_attractions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `package_attractions` (
  `Package_ID` int(11) NOT NULL,
  `Attraction_ID` int(11) NOT NULL,
  PRIMARY KEY (`Package_ID`,`Attraction_ID`),
  KEY `Attraction_ID` (`Attraction_ID`),
  CONSTRAINT `package_attractions_fk1` FOREIGN KEY (`Package_ID`) REFERENCES `packages` (`Package_ID`) ON DELETE CASCADE,
  CONSTRAINT `package_attractions_fk2` FOREIGN KEY (`Attraction_ID`) REFERENCES `tourist_attractions` (`Attraction_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `package_attractions`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `package_attractions` WRITE;
/*!40000 ALTER TABLE `package_attractions` DISABLE KEYS */;
INSERT INTO `package_attractions` VALUES
(1,1),
(1,2),
(1,3),
(2,4),
(2,5);
/*!40000 ALTER TABLE `package_attractions` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `package_destinations`
--

DROP TABLE IF EXISTS `package_destinations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `package_destinations` (
  `Package_ID` int(11) NOT NULL,
  `Destination_ID` int(11) NOT NULL,
  PRIMARY KEY (`Package_ID`,`Destination_ID`),
  KEY `Destination_ID` (`Destination_ID`),
  CONSTRAINT `package_destinations_fk1` FOREIGN KEY (`Package_ID`) REFERENCES `packages` (`Package_ID`) ON DELETE CASCADE,
  CONSTRAINT `package_destinations_fk2` FOREIGN KEY (`Destination_ID`) REFERENCES `destinations` (`Destination_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `package_destinations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `package_destinations` WRITE;
/*!40000 ALTER TABLE `package_destinations` DISABLE KEYS */;
INSERT INTO `package_destinations` VALUES
(1,1),
(2,2),
(3,3);
/*!40000 ALTER TABLE `package_destinations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `package_flights`
--

DROP TABLE IF EXISTS `package_flights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `package_flights` (
  `Package_ID` int(11) NOT NULL,
  `Flight_ID` int(11) NOT NULL,
  PRIMARY KEY (`Package_ID`,`Flight_ID`),
  KEY `Flight_ID` (`Flight_ID`),
  CONSTRAINT `package_flights_fk1` FOREIGN KEY (`Package_ID`) REFERENCES `packages` (`Package_ID`) ON DELETE CASCADE,
  CONSTRAINT `package_flights_fk2` FOREIGN KEY (`Flight_ID`) REFERENCES `flights` (`Flight_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `package_flights`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `package_flights` WRITE;
/*!40000 ALTER TABLE `package_flights` DISABLE KEYS */;
INSERT INTO `package_flights` VALUES
(1,1),
(2,2),
(3,3);
/*!40000 ALTER TABLE `package_flights` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `package_images`
--

DROP TABLE IF EXISTS `package_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `package_images` (
  `Package_ID` int(11) NOT NULL,
  `Image_URL` varchar(500) NOT NULL,
  PRIMARY KEY (`Package_ID`,`Image_URL`),
  CONSTRAINT `package_images_fk1` FOREIGN KEY (`Package_ID`) REFERENCES `packages` (`Package_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `package_images`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `package_images` WRITE;
/*!40000 ALTER TABLE `package_images` DISABLE KEYS */;
INSERT INTO `package_images` VALUES
(1,'https://images.com/capetown_1.jpg'),
(1,'https://images.com/capetown_2.jpg'),
(1,'https://images.com/capetown_3.jpg'),
(2,'https://images.com/kruger_1.jpg'),
(2,'https://images.com/kruger_2.jpg'),
(3,'https://images.com/gardenroute_1.jpg'),
(3,'https://images.com/gardenroute_2.jpg');
/*!40000 ALTER TABLE `package_images` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `package_restaurants`
--

DROP TABLE IF EXISTS `package_restaurants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `package_restaurants` (
  `Package_ID` int(11) NOT NULL,
  `Restaurant_ID` int(11) NOT NULL,
  PRIMARY KEY (`Package_ID`,`Restaurant_ID`),
  KEY `Restaurant_ID` (`Restaurant_ID`),
  CONSTRAINT `package_restaurants_fk1` FOREIGN KEY (`Package_ID`) REFERENCES `packages` (`Package_ID`) ON DELETE CASCADE,
  CONSTRAINT `package_restaurants_fk2` FOREIGN KEY (`Restaurant_ID`) REFERENCES `restaurants` (`Restaurant_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `package_restaurants`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `package_restaurants` WRITE;
/*!40000 ALTER TABLE `package_restaurants` DISABLE KEYS */;
INSERT INTO `package_restaurants` VALUES
(1,1),
(2,2),
(3,3);
/*!40000 ALTER TABLE `package_restaurants` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `packages`
--

DROP TABLE IF EXISTS `packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `packages` (
  `Package_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Agency_ID` int(11) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Price` decimal(10,2) NOT NULL CHECK (`Price` > 0),
  `Description` text NOT NULL,
  `Duration` int(11) NOT NULL CHECK (`Duration` > 0),
  PRIMARY KEY (`Package_ID`),
  KEY `Agency_ID` (`Agency_ID`),
  CONSTRAINT `packages_fk1` FOREIGN KEY (`Agency_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE,
  CONSTRAINT `CHK_Name_Length` CHECK (octet_length(`Name`) >= 3)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `packages`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `packages` WRITE;
/*!40000 ALTER TABLE `packages` DISABLE KEYS */;
INSERT INTO `packages` VALUES
(1,3,'Cape Town Getaway',12500.00,'Explore the Mother City with Table Mountain, beaches, and wine tours.',5),
(2,3,'Kruger Safari Experience',22000.00,'Big 5 game drives, luxury lodge, all meals included.',4),
(3,3,'Garden Route Road Trip',18000.00,'Scenic coastal drive from Cape Town to Gqeberha.',7);
/*!40000 ALTER TABLE `packages` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `restaurants`
--

DROP TABLE IF EXISTS `restaurants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `restaurants` (
  `Restaurant_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) NOT NULL,
  `Cuisine` varchar(100) NOT NULL,
  `Image` varchar(500) NOT NULL,
  PRIMARY KEY (`Restaurant_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restaurants`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `restaurants` WRITE;
/*!40000 ALTER TABLE `restaurants` DISABLE KEYS */;
INSERT INTO `restaurants` VALUES
(1,'The Test Kitchen','Fine Dining','https://images.com/testkitchen.jpg'),
(2,'Cattle Baron','Steakhouse','https://images.com/cattlebaron.jpg'),
(3,'Freshline Fisheries','Seafood','https://images.com/freshline.jpg');
/*!40000 ALTER TABLE `restaurants` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `Review_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Booking_ID` int(11) NOT NULL,
  `Rating` int(11) NOT NULL CHECK (`Rating` >= 1 and `Rating` <= 5),
  `Comment` text NOT NULL,
  `Date` date NOT NULL,
  `User_ID` int(11) NOT NULL,
  PRIMARY KEY (`Review_ID`,`Booking_ID`),
  UNIQUE KEY `Booking_ID` (`Booking_ID`),
  KEY `FK_Review_User` (`User_ID`),
  CONSTRAINT `reviews_fk1` FOREIGN KEY (`Booking_ID`) REFERENCES `bookings` (`Booking_ID`) ON DELETE CASCADE,
  CONSTRAINT `FK_Review_User` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES
(5,1,5,'Cape Town was incredible! The itinerary was well-planned and the hotel had stunning views of Table Mountain.','2026-06-10',1),
(6,2,4,'The Kruger safari was unforgettable. Saw all Big 5! Would have liked an extra game drive though.','2026-07-18',2),
(7,3,5,'Garden Route road trip was the best group experience ever. Made new friends and the scenery was breathtaking.','2026-09-01',1);
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `solo_bookings`
--

DROP TABLE IF EXISTS `solo_bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `solo_bookings` (
  `Booking_ID` int(11) NOT NULL,
  PRIMARY KEY (`Booking_ID`),
  CONSTRAINT `solo_bookings_fk1` FOREIGN KEY (`Booking_ID`) REFERENCES `bookings` (`Booking_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solo_bookings`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `solo_bookings` WRITE;
/*!40000 ALTER TABLE `solo_bookings` DISABLE KEYS */;
INSERT INTO `solo_bookings` VALUES
(1),
(2);
/*!40000 ALTER TABLE `solo_bookings` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `tourist_attractions`
--

DROP TABLE IF EXISTS `tourist_attractions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tourist_attractions` (
  `Attraction_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) NOT NULL,
  `Image` varchar(500) NOT NULL,
  PRIMARY KEY (`Attraction_ID`),
  CONSTRAINT `CHK_Name_Length` CHECK (octet_length(`Name`) >= 2)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tourist_attractions`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `tourist_attractions` WRITE;
/*!40000 ALTER TABLE `tourist_attractions` DISABLE KEYS */;
INSERT INTO `tourist_attractions` VALUES
(1,'Table Mountain','https://images.com/table_mountain.jpg'),
(2,'Boulders Beach','https://images.com/boulders_beach.jpg'),
(3,'V&A Waterfront','https://images.com/va_waterfront.jpg'),
(4,'Kruger Gate','https://images.com/kruger_gate.jpg'),
(5,'Blyde River Canyon','https://images.com/blyde_canyon.jpg');
/*!40000 ALTER TABLE `tourist_attractions` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `User_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Password_Hash` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Cell` varchar(20) NOT NULL,
  `Type` enum('Agency','Traveler') NOT NULL,
  PRIMARY KEY (`User_ID`),
  UNIQUE KEY `Email` (`Email`),
  CONSTRAINT `CHK_Cell_Length` CHECK (octet_length(`Cell`) >= 10),
  CONSTRAINT `CHK_Email_Format` CHECK (`Email` like '%_@_%._%')
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'Alice Mabena','$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy','alice.mabena@gmail.com','+27831234567','Traveler'),
(2,'Ravi Naidoo','$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy','ravi.naidoo@outlook.com','+27829876543','Traveler'),
(3,'Safari & Sun Agency','$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy','bookings@safarisun.co.za','+27213456789','Agency');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-05-14 22:31:29
