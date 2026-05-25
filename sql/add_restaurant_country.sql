-- Adds a Country column to the restaurants table so restaurants can be
-- searched by country. Run this once against an already-imported database.
-- Anke de Frey u24611400

ALTER TABLE `restaurants`
  ADD COLUMN `Country` varchar(100) NOT NULL DEFAULT '' AFTER `Cuisine`;

-- Seed each restaurant's country from the destinations of the packages
-- that include it. Any restaurant's Country can be edited afterwards.
UPDATE `restaurants` r
SET r.`Country` = COALESCE((
    SELECT d.`Country`
    FROM `package_restaurants` pr
    JOIN `package_destinations` pd ON pd.`Package_ID` = pr.`Package_ID`
    JOIN `destinations` d ON d.`Destination_ID` = pd.`Destination_ID`
    WHERE pr.`Restaurant_ID` = r.`Restaurant_ID`
    LIMIT 1
), '');
