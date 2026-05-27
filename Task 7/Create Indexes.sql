USE tripistry;

-- for WHERE clause filtering
CREATE INDEX idx_dest_name ON destinations(Name);

-- for JOIN
CREATE INDEX idx_pd_dest ON package_destinations(Destination_ID);

-- for JOIN
CREATE INDEX idx_pd_package ON package_destinations(Package_ID);

-- for subquery
CREATE INDEX idx_booking_package ON bookings(Package_ID);

-- for subquery JOIN
CREATE INDEX idx_review_booking ON reviews(Booking_ID);
