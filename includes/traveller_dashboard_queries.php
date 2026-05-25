<?php
    /*  Dashboard query helpers
        Anke de Frey u24611400*/

    function getTopRatedPackages($conn, $limit = 1){
        $sql = "SELECT p.Package_ID, p.Name, p.Price, p.Duration, p.Description,
                a.Name AS Agency_Name,
                AVG(r.Rating) AS avg_rating,
                COUNT(r.Review_ID) AS review_count,
                    (SELECT pi.Image_URL FROM package_images pi
                        WHERE pi.Package_ID = p.Package_ID LIMIT 1)
                    AS Image_URL
                FROM packages p
                    JOIN users a ON a.User_ID= p.Agency_ID
                    JOIN bookings b ON b.Package_ID = p.Package_ID
                    JOIN reviews r ON r.Booking_ID = b.Booking_ID
                GROUP BY p.Package_ID
                HAVING review_count >= 1
                ORDER BY avg_rating DESC, review_count DESC LIMIT " . (int) $limit;

        $result = $conn->query($sql);
        if (!$result) return [];

        $rows = [];
        while ($row = $result->fetch_assoc()) $rows[] = $row;
        return $rows;
    }

    function getAllPackages($conn){
        $sql = "SELECT p.Package_ID, p.Agency_ID, p.Name AS package_name, p.Price, p.Description, p.Duration, p.Capacity,
                u.Name AS agency_name,
                COALESCE(AVG(r.Rating), 0) AS avg_rating,
                COUNT(r.Review_ID) AS review_count,
                GREATEST(p.Capacity - (SELECT COUNT(*) FROM bookings sb WHERE sb.Package_ID = p.Package_ID), 0) AS spots_left,
                (p.Price
                    + COALESCE((SELECT SUM(fl.Price) FROM package_flights pf JOIN flights fl ON fl.Flight_ID = pf.Flight_ID WHERE pf.Package_ID = p.Package_ID), 0)
                    + COALESCE((SELECT SUM(ac.Price_PN) FROM package_accommodations pa JOIN accommodations ac ON ac.Accommodation_ID = pa.Accommodation_ID WHERE pa.Package_ID = p.Package_ID), 0) * p.Duration) AS full_price
                FROM packages p
                    JOIN users u ON p.Agency_ID = u.User_ID
                    LEFT JOIN bookings b ON p.Package_ID = b.Package_ID
                    LEFT JOIN reviews r ON b.Booking_ID = r.Booking_ID
                GROUP BY p.Package_ID
                ORDER BY p.Package_ID";
        $result = $conn->query($sql);
        $packages = [];

        if($result && $result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $packages[] = $row;
            }
        }

        return $packages;
    }

    function getPackagesByDestination($conn, $destinationID) {
        $sql = "SELECT p.Package_ID, p.Agency_ID, p.Name AS package_name, p.Price, p.Description, p.Duration, p.Capacity,
                u.Name AS agency_name,
                COALESCE(AVG(r.Rating), 0) AS avg_rating,
                COUNT(r.Review_ID) AS review_count,
                GREATEST(p.Capacity - (SELECT COUNT(*) FROM bookings sb WHERE sb.Package_ID = p.Package_ID), 0) AS spots_left,
                (p.Price
                    + COALESCE((SELECT SUM(fl.Price) FROM package_flights pf JOIN flights fl ON fl.Flight_ID = pf.Flight_ID WHERE pf.Package_ID = p.Package_ID), 0)
                    + COALESCE((SELECT SUM(ac.Price_PN) FROM package_accommodations pa JOIN accommodations ac ON ac.Accommodation_ID = pa.Accommodation_ID WHERE pa.Package_ID = p.Package_ID), 0) * p.Duration) AS full_price,
                (SELECT Image_URL FROM package_images WHERE Package_ID = p.Package_ID LIMIT 1) AS image_url
                FROM packages p
                    JOIN users u ON p.Agency_ID = u.User_ID
                    JOIN package_destinations pd ON p.Package_ID = pd.Package_ID
                    LEFT JOIN bookings b ON p.Package_ID = b.Package_ID
                    LEFT JOIN reviews r ON b.Booking_ID = r.Booking_ID
                WHERE pd.Destination_ID = ?
                GROUP BY p.Package_ID
                ORDER BY p.Package_ID";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $destinationID);
        $stmt->execute();
        $result = $stmt->get_result();

        $packages = [];
        while ($row = $result->fetch_assoc()) {
            $packages[] = $row;
        }

        $stmt->close();
        return $packages;
    }

    function getPackageDetails($conn, $packageID){
        $sql = "SELECT
                p.Package_ID, p.Agency_ID, p.Name AS package_name, p.Price, p.Description, p.Duration, p.Capacity,
                u.Name AS agency_name,
                COALESCE(AVG(r.Rating), 0) AS avg_rating,
                COUNT(r.Review_ID) AS review_count,
                GREATEST(p.Capacity - (SELECT COUNT(*) FROM bookings sb WHERE sb.Package_ID = p.Package_ID), 0) AS spots_left,
                (p.Price
                    + COALESCE((SELECT SUM(fl.Price) FROM package_flights pf JOIN flights fl ON fl.Flight_ID = pf.Flight_ID WHERE pf.Package_ID = p.Package_ID), 0)
                    + COALESCE((SELECT SUM(ac.Price_PN) FROM package_accommodations pa JOIN accommodations ac ON ac.Accommodation_ID = pa.Accommodation_ID WHERE pa.Package_ID = p.Package_ID), 0) * p.Duration) AS full_price
                FROM packages p
                    JOIN users u ON p.Agency_ID = u.User_ID
                    LEFT JOIN bookings b ON p.Package_ID = b.Package_ID
                    LEFT JOIN reviews r ON b.Booking_ID = r.Booking_ID
                WHERE p.Package_ID = ?
                GROUP BY p.Package_ID";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $packageID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0){
            return null;
        }

        $package = $result->fetch_assoc();
        $stmt->close();

        // Get images
        $package['images'] = getPackageImages($conn, $packageID);

        // Get destinations
        $package['destinations'] = getPackageDestinations($conn, $packageID);

        // Get flights
        $package['flights'] = getPackageFlights($conn, $packageID);

        // Get accommodations
        $package['accommodations'] = getPackageAccommodations($conn, $packageID);

        // Get attractions
        $package['attractions'] = getPackageAttractions($conn, $packageID);

        // Get restaurants
        $package['restaurants'] = getPackageRestaurants($conn, $packageID);

        // Get reviews
        $package['reviews'] = getPackageReviews($conn, $packageID);

        return $package;
    }

    function getPackageImages($conn, $packageID) {
        $sql = "SELECT Image_URL
                FROM package_images
                WHERE Package_ID = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $packageID);
        $stmt->execute();

        $result = $stmt->get_result();

        $images = [];
        while ($row = $result->fetch_assoc()) {
            $images[] = $row;
        }

        $stmt->close();

        return $images;
    }

    function getPackageDestinations($conn, $packageID) {
        $sql = "SELECT destinations.Destination_ID, destinations.Name, destinations.Country, destinations.Image
                FROM destinations
                JOIN package_destinations ON destinations.Destination_ID = package_destinations.Destination_ID
                WHERE package_destinations.Package_ID = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $packageID);
        $stmt->execute();

        $result = $stmt->get_result();

        $destinations = [];
        while ($row = $result->fetch_assoc()) {
            $destinations[] = $row;
        }

        $stmt->close();

        return $destinations;
    }

    function getPackageFlights($conn, $packageID) {
        $sql = "SELECT flights.Flight_ID, flights.Airline, flights.Departure_Loc, flights.Arrival_Loc, flights.Time_Dept, flights.Time_Arrive, flights.Price
                FROM flights
                JOIN package_flights ON flights.Flight_ID = package_flights.Flight_ID
                WHERE package_flights.Package_ID = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $packageID);
        $stmt->execute();

        $result = $stmt->get_result();

        $flights = [];
        while ($row = $result->fetch_assoc()) {
            $flights[] = $row;
        }

        $stmt->close();

        return $flights;
    }

    function getPackageAccommodations($conn, $packageID) {
        $sql = "SELECT accommodations.Accommodation_ID, accommodations.Name, accommodations.Type, accommodations.Price_PN, accommodations.Image
                FROM accommodations
                JOIN package_accommodations ON accommodations.Accommodation_ID = package_accommodations.Accommodation_ID
                WHERE package_accommodations.Package_ID = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $packageID);
        $stmt->execute();

        $result = $stmt->get_result();

        $accommodations = [];
        while ($row = $result->fetch_assoc()) {
            $accommodations[] = $row;
        }

        $stmt->close();

        return $accommodations;
    }

    function getPackageAttractions($conn, $packageID) {
        $sql = "SELECT tourist_attractions.Attraction_ID, tourist_attractions.Name, tourist_attractions.Image
                FROM tourist_attractions
                JOIN package_attractions ON tourist_attractions.Attraction_ID = package_attractions.Attraction_ID
                WHERE package_attractions.Package_ID = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $packageID);
        $stmt->execute();

        $result = $stmt->get_result();

        $attractions = [];
        while ($row = $result->fetch_assoc()) {
            $attractions[] = $row;
        }

        $stmt->close();

        return $attractions;
    }

    function getPackageRestaurants($conn, $packageID) {
        $sql = "SELECT restaurants.Restaurant_ID, restaurants.Name, restaurants.Cuisine, restaurants.Image
                FROM restaurants
                JOIN package_restaurants ON restaurants.Restaurant_ID = package_restaurants.Restaurant_ID
                WHERE package_restaurants.Package_ID = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $packageID);
        $stmt->execute();

        $result = $stmt->get_result();

        $restaurants = [];
        while ($row = $result->fetch_assoc()) {
            $restaurants[] = $row;
        }

        $stmt->close();

        return $restaurants;
    }

    function getPackageReviews($conn, $packageID) {
        $sql = "SELECT reviews.Review_ID, reviews.Booking_ID, reviews.Rating, reviews.Comment, reviews.Date, reviews.User_ID
                FROM reviews
                JOIN bookings ON reviews.Booking_ID = bookings.Booking_ID
                JOIN packages ON bookings.Package_ID = packages.Package_ID
                WHERE packages.Package_ID = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $packageID);
        $stmt->execute();

        $result = $stmt->get_result();

        $reviews = [];
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }

        $stmt->close();

        return $reviews;
    }

    function getAllDestinations($conn){
        $sql = "SELECT DISTINCT Destination_ID, Name, Country, Image FROM destinations ORDER BY Name";
        $result = $conn->query($sql);

        $destinations = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $destinations[] = $row;
            }
        }

        return $destinations;
    }

    function generateStarRating($rating){
        $fullStars = floor($rating);
        if (($rating - $fullStars) >= 0.5) {
            $halfStar = true;
        } else {
            $halfStar = false;
        }

        if ($halfStar) {
            $emptyStars = 5 - $fullStars - 1;
        } else {
            $emptyStars = 5 - $fullStars;
        }

        $html = '';

        // Full stars
        for ($i = 0; $i < $fullStars; $i++) {
            $html .= '★';
        }

        // Half star
        if ($halfStar) {
            $html .= '★';
        }

        // Empty stars
        for ($i = 0; $i < $emptyStars; $i++) {
            $html .= '☆';
        }

        return $html;
    }

    //returns the display text + css class for a package's remaining spots
    function getSpotsStatus($spotsLeft){
        $spotsLeft = (int)$spotsLeft;

        if ($spotsLeft <= 0) {
            return ['text' => 'Fully booked', 'class' => 'spots-full'];
        }

        if ($spotsLeft === 1) {
            $word = 'spot';
        } else {
            $word = 'spots';
        }

        if ($spotsLeft <= 3) {
            return ['text' => 'Only ' . $spotsLeft . ' ' . $word . ' left', 'class' => 'spots-low'];
        }

        return ['text' => $spotsLeft . ' ' . $word . ' left', 'class' => 'spots-open'];
    }

    function packageHasFlights($conn, $packageID){
        $sql = "SELECT COUNT(*) as count
                FROM package_flights
                WHERE Package_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $packageID);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row['count'] > 0;
    }
    
    function packageHasAccommodations($conn, $packageID){
        $sql = "SELECT COUNT(*) as count
                FROM package_accommodations
                WHERE Package_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $packageID);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row['count'] > 0;
    }

    function packageHasRestaurants($conn, $packageID){
        $sql = "SELECT COUNT(*) as count
                FROM package_restaurants
                WHERE Package_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $packageID);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row['count'] > 0;
    }

    function packageHasAttractions($conn, $packageID){
        $sql = "SELECT COUNT(*) as count
                FROM package_attractions
                WHERE Package_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $packageID);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row['count'] > 0;
    }

    function userHasBookedPackage($conn, $userID, $packageID) {
        $sql = "SELECT COUNT(*) as count
                FROM bookings
                WHERE User_ID = ? AND Package_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $userID, $packageID);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row['count'] > 0;
    }

    function userHasReviewedPackage($conn, $userID, $packageID) {
        $sql = "SELECT r.Review_ID
                FROM reviews r
                JOIN bookings b ON r.Booking_ID = b.Booking_ID
                WHERE b.User_ID = ? AND b.Package_ID = ?
                LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $userID, $packageID);
        $stmt->execute();

        $result = $stmt->get_result();
        $review = $result->fetch_assoc();
        $stmt->close();

        return $review;
    }

    function submitReview($conn, $bookingID, $userID, $rating, $comment) {
        //reviews.User_ID is NOT NULL, so the reviewer must be stored too
        $sql = "INSERT INTO reviews (Booking_ID, User_ID, Rating, Comment, Date)
                VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        if (!$stmt) return ['success' => false, 'error' => 'Database error'];

        $stmt->bind_param("iiis", $bookingID, $userID, $rating, $comment);
        if ($stmt->execute()) {
            $insertId = $stmt->insert_id;
            $stmt->close();
            return ['success' => true, 'review_id' => $insertId];
        } else {
            $stmt->close();
            return ['success' => false, 'error' => 'Failed to submit review'];
        }
    }

    function getTravellerReviews($conn, $userID) {
        $sql = "SELECT r.Review_ID, r.Rating, r.Comment, r.Date,
                        p.Name AS package_name, p.Package_ID,
                        b.Booking_Date
                FROM reviews r
                JOIN bookings b ON r.Booking_ID = b.Booking_ID
                JOIN packages p ON b.Package_ID = p.Package_ID
                WHERE b.User_ID = ?
                ORDER BY r.Date DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $userID);
        $stmt->execute();

        $result = $stmt->get_result();
        $reviews = [];
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }
        $stmt->close();

        return $reviews;
    }
