-- Adds a table to store the name and cellphone of every traveller on a booking.
-- The booking popup collects these; this is where they are kept.
-- Run this once against an already-imported database.
-- Anke de Frey u24611400

CREATE TABLE `booking_traveller_details` (
  `Detail_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Booking_ID` int(11) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `Cell` varchar(20) NOT NULL,
  PRIMARY KEY (`Detail_ID`),
  KEY `Booking_ID` (`Booking_ID`),
  CONSTRAINT `btd_fk1` FOREIGN KEY (`Booking_ID`) REFERENCES `bookings` (`Booking_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
