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
        $sql = "SELECT p.Package_ID, p.Agency_ID, p.Name AS package_name, p.Price, p.Description, p.Duration,
                u.Name AS agency_name,
                COALESCE(AVG(r.Rating), 0) AS avg_rating,
                COUNT(r.Review_ID) AS review_count
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
        $sql = "SELECT p.Package_ID, p.Agency_ID, p.Name AS package_name, p.Price, p.Description, p.Duration,
                u.Name AS agency_name,
                COALESCE(AVG(r.Rating), 0) AS avg_rating,
                COUNT(r.Review_ID) AS review_count,
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
                p.Package_ID, p.Agency_ID, p.Name AS package_name, p.Price, p.Description, p.Duration,
                u.Name AS agency_name,
                COALESCE(AVG(r.Rating), 0) AS avg_rating,
                COUNT(r.Review_ID) AS review_count
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

    }

    function getPackageFlights($conn, $packageID) {

    }

    function getPackageAccommodations($conn, $packageID) {

    }

    function getPackageAttractions($conn, $packageID) {

    }

    function getPackageRestaurants($conn, $packageID) {

    }

    function getPackageReviews($conn, $packageID) {
        
    }

    function getAllDestinations($conn){
        $sql = "SELECT DISTINCT Destination_ID, Name, Country, Image FROM destinations ORDER BY Name";
        $result = $conn->query($sql);

        $destinations = [];
        while ($row = $result->fetch_assoc()) {
            $destinations[] = $row;
        }

        return $destinations;
    }

    function generateStarRating($rating){
        $fullStars = floor($rating);
        $halfStar = ($rating - $fullStars) >= 0.5 ? true : false;
        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);

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

    }

    function packageHasRestaurants($conn, $packageID){

    }

    function packageHasAttractions($conn, $packageID){

    }
