-- Adds a Capacity column to the packages table so "spots left" can be tracked.
-- Run this once against an already-imported database.
-- Anke de Frey u24611400

ALTER TABLE `packages`
  ADD COLUMN `Capacity` int(11) NOT NULL DEFAULT 20 CHECK (`Capacity` > 0) AFTER `Duration`;

-- Existing rows take the DEFAULT (20). Adjust per-package capacity if needed, e.g.:
-- UPDATE `packages` SET `Capacity` = 12 WHERE `Package_ID` = 2;
