-- Adding 30 more packages now
USE tripistry;

INSERT INTO packages (Agency_ID, Name, Price, Description, Duration)
SELECT 
    3,
    CONCAT('Package ', n, ' - ', d.Name),
    5000 + (n * 1000),
    CONCAT('Sample package for ', d.Name),
    3 + (n % 8)
FROM destinations d
CROSS JOIN (
    SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION
    SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10
) AS numbers(n)
LIMIT 30;

-- Add corresponding package-destination links
INSERT IGNORE INTO package_destinations (Package_ID, Destination_ID)
SELECT p.Package_ID, d.Destination_ID
FROM packages p, destinations d
WHERE p.Package_ID > 18
AND d.Destination_ID = 1 + (p.Package_ID % 3);