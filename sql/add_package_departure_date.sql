-- Adds a Departure_Date column to the packages table so the agency can
-- set a package's departure date and travellers can book against it.
-- Run this once against an already-imported database.
-- Anke de Frey u24611400

ALTER TABLE `packages`
  ADD COLUMN `Departure_Date` date DEFAULT NULL AFTER `Capacity`;

-- Give existing packages a departure date so they are bookable.
-- New packages get their date from the agency create-package form.
UPDATE `packages`
SET `Departure_Date` = DATE_ADD(CURDATE(), INTERVAL (30 + `Package_ID`) DAY)
WHERE `Departure_Date` IS NULL;
