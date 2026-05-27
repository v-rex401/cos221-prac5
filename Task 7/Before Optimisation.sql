-- This creates a Cartesian product and filters late that violates Rule 6. 
-- measure the time for the new inefficient query. Now it's 101.62 so very inefficient. 
USE tripistry;

SET @end = NOW(6);

-- Get execution plan for the inefficient query
EXPLAIN FORMAT=JSON
SELECT 
    p.Name AS Package_Name,
    p.Price,
    u.Name AS Agency_Name,
    d.Name AS Destination,
    COALESCE(AVG(r.Rating), 0) AS Avg_Rating
FROM packages p
CROSS JOIN destinations d                               -- Cartesian product first (BAD!)
LEFT JOIN users u ON p.Agency_ID = u.User_ID
LEFT JOIN package_destinations pd ON p.Package_ID = pd.Package_ID AND pd.Destination_ID = d.Destination_ID
LEFT JOIN bookings b ON p.Package_ID = b.Package_ID
LEFT JOIN reviews r ON b.Booking_ID = r.Booking_ID
WHERE d.Name = 'Cape Town'                               -- Filter happens late (BAD!)
GROUP BY p.Package_ID, p.Name, p.Price, u.Name, d.Name
ORDER BY Avg_Rating DESC;