-- Step 4: Run Optimised Query- now 1.60 so very efficient
USE tripistry; 

EXPLAIN FORMAT=JSON
SELECT 
    p.Name AS Package_Name, p.Price, u.Name AS Agency_Name, d.Name AS Destination,
    COALESCE((
        SELECT AVG(r.Rating)
        FROM bookings b
        JOIN reviews r ON b.Booking_ID = r.Booking_ID
        WHERE b.Package_ID = p.Package_ID
    ), 0) AS Avg_Rating
FROM packages p
JOIN users u ON p.Agency_ID = u.User_ID
JOIN package_destinations pd ON p.Package_ID = pd.Package_ID
JOIN destinations d ON pd.Destination_ID = d.Destination_ID
WHERE d.Name = 'Cape Town'
GROUP BY p.Package_ID, p.Name, p.Price, u.Name, d.Name
ORDER BY Avg_Rating DESC;