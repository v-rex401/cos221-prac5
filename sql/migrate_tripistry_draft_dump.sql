-- ============================================================
-- Migration for tripistry_draft_dump.sql
-- Run this ONCE, after importing tripistry_draft_dump.sql.
-- Anke de Frey u24611400
--
-- Already in this dump (nothing to do):
--   * packages.Capacity        -- present and populated
--   * packages.Departure_Date  -- present and populated
--   * restaurants.Country      -- column present (but empty - see step 2)
--   * group_bookings.Sharing_Code -- present (group system needs no change)
--
-- Not in this dump (this script adds it):
--   1. the booking_traveller_details table
--   2. country values for the restaurants (the column is empty)
-- ============================================================


-- 1) Stores each traveller's name + cellphone for a booking.
--    The booking popup collects these; without this table, completing
--    a booking will fail.
CREATE TABLE `booking_traveller_details` (
  `Detail_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Booking_ID` int(11) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `Cell` varchar(20) NOT NULL,
  PRIMARY KEY (`Detail_ID`),
  KEY `Booking_ID` (`Booking_ID`),
  CONSTRAINT `btd_fk1` FOREIGN KEY (`Booking_ID`) REFERENCES `bookings` (`Booking_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- 2) OPTIONAL: the restaurants.Country column exists but is empty in this
--    dump, so the "search by country" filter would have nothing to show.
--    This seeds each restaurant's country from the destinations of the
--    packages it belongs to. Any value can be edited afterwards.
--    Skip this step if you would rather fill the countries in by hand.
UPDATE `restaurants` r
SET r.`Country` = COALESCE((
    SELECT d.`Country`
    FROM `package_restaurants` pr
    JOIN `package_destinations` pd ON pd.`Package_ID` = pr.`Package_ID`
    JOIN `destinations` d ON d.`Destination_ID` = pd.`Destination_ID`
    WHERE pr.`Restaurant_ID` = r.`Restaurant_ID`
    LIMIT 1
), '');
