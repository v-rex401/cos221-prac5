<?php
    //u24611400 Anke de Frey

    require_once __DIR__ . '/../../includes/session.php';
    require_once __DIR__ . '/../../includes/database.php';
    require_once __DIR__ . '/../../includes/auth.php';
    require_once __DIR__ . '/../../includes/validation.php';
    require_once __DIR__ . '/../../includes/traveller_dashboard_queries.php';
    require_once __DIR__ . '/../../includes/flights_queries.php';

    //session.php
    redirectIfNotTraveller();

    //session.php
    $userID = getCurrentUserID();

    //auth.php
    $userResult = getTravellerByUserID($userID);

    //validation.php
    if ($userResult['success']) {
        $userName = sanitise($userResult['user']['Name']);
    } else {
        $userName = 'Traveller';
    }

    // Get all flights (flights_queries.php)
    $allFlights = getAllFlights($conn);

    // Get unique airlines, departure locations, and arrival locations
    $airlines = [];
    $departureLocations = [];
    $arrivalLocations = [];

    foreach ($allFlights as $flight) {
        if (!in_array($flight['Airline'], $airlines)) {
            $airlines[] = $flight['Airline'];
        }
        if (!in_array($flight['Departure_Loc'], $departureLocations)) {
            $departureLocations[] = $flight['Departure_Loc'];
        }
        if (!in_array($flight['Arrival_Loc'], $arrivalLocations)) {
            $arrivalLocations[] = $flight['Arrival_Loc'];
        }
    }
    sort($airlines);
    sort($departureLocations);
    sort($arrivalLocations);

    // Get filter parameters
    $searchAirline = '';
    $filterDeparture = '';
    $filterArrival = '';
    $filterDateFrom = '';
    $filterDateTo = '';
    $sortBy = 'price_asc';

    if (isset($_GET['airline'])) {
        $searchAirline = sanitise($_GET['airline']);
    }
    if (isset($_GET['departure'])) {
        $filterDeparture = sanitise($_GET['departure']);
    }
    if (isset($_GET['arrival'])) {
        $filterArrival = sanitise($_GET['arrival']);
    }
    if (isset($_GET['date_from'])) {
        $filterDateFrom = sanitise($_GET['date_from']);
    }
    if (isset($_GET['date_to'])) {
        $filterDateTo = sanitise($_GET['date_to']);
    }
    if (isset($_GET['sort'])) {
        $sortBy = sanitise($_GET['sort']);
    }

    // Filter flights
    $filteredFlights = [];
    foreach ($allFlights as $flight) {
        $airlineMatch = empty($searchAirline) || stripos($flight['Airline'], $searchAirline) !== false;
        $departureMatch = empty($filterDeparture) || strcasecmp($flight['Departure_Loc'], $filterDeparture) === 0;
        $arrivalMatch = empty($filterArrival) || strcasecmp($flight['Arrival_Loc'], $filterArrival) === 0;

        $dateMatch = true;
        if (!empty($filterDateFrom) || !empty($filterDateTo)) {
            $flightDate = date('Y-m-d', strtotime($flight['Time_Dept']));
            if (!empty($filterDateFrom) && $flightDate < $filterDateFrom) {
                $dateMatch = false;
            }
            if (!empty($filterDateTo) && $flightDate > $filterDateTo) {
                $dateMatch = false;
            }
        }

        if ($airlineMatch && $departureMatch && $arrivalMatch && $dateMatch) {
            $filteredFlights[] = $flight;
        }
    }

    // Sort flights
    usort($filteredFlights, function ($a, $b) use ($sortBy) {
        switch ($sortBy) {
            case 'price_asc':
                return $a['Price'] <=> $b['Price'];
            case 'price_desc':
                return $b['Price'] <=> $a['Price'];
            case 'departure_asc':
                return strtotime($a['Time_Dept']) <=> strtotime($b['Time_Dept']);
            case 'departure_desc':
                return strtotime($b['Time_Dept']) <=> strtotime($a['Time_Dept']);
            default:
                return 0;
        }
    });

    // Calculate flight duration helper function
    function calculateDuration($depTime, $arrTime) {
        $dep = strtotime($depTime);
        $arr = strtotime($arrTime);
        $diff = $arr - $dep;
        $hours = floor($diff / 3600);
        $minutes = floor(($diff % 3600) / 60);
        return "{$hours}h {$minutes}m";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Flights - Tripistry</title>
    <link rel="stylesheet" href="../../css/flights.css">
    <link rel="stylesheet" href="../../css/style.css">

</head>

<body>

<div class="container">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="logo">Tripistry</div>

        <ul>
            <li><a href="traveller_dashboard.php">Home</a></li>
            <li><a href="destinations.php">Destinations</a></li>
            <li><a href="flights.php" class="active-link">Flights</a></li>
            <li><a href="accommodations.php">Accommodations</a></li>
            <li><a href="attractions.php">Attractions</a></li>
            <li><a href="restaurants.php">Restaurants</a></li>
            <li><a href="compare_packages.php">Compare Packages</a></li>
            <li><a href="bookings.php">My Bookings</a></li>
            <li><a href="reviews.php">Reviews</a></li>
        </ul>

        <a href="../logout.php" class="sidebar-logout">Logout</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <!-- TOP BAR -->
        <div class="topbar">
            <div class="topbar-spacer"></div>
            <div class="profile">
                Welcome, <?php echo htmlspecialchars($userName); ?>
            </div>
        </div>

        <!-- FLIGHTS PAGE CONTENT -->
        <div class="flights-page">

            <div class="flights-header">
                <h1>Flights</h1>
            </div>

            <!-- FILTERS -->
            <div class="filter-section">
                <form method="GET" class="filter-form">
                    <div class="filter-group">
                        <label for="airline">Search Airline</label>
                        <input type="text" id="airline" name="airline" placeholder="search"
                            value="<?php echo htmlspecialchars($searchAirline); ?>">
                    </div>

                    <div class="filter-group">
                        <label for="departure">Departure Location</label>
                        <select id="departure" name="departure">
                            <option value="">All Locations</option>
                            <?php foreach ($departureLocations as $loc): ?>
                                <option value="<?php echo htmlspecialchars($loc); ?>" <?php if ($filterDeparture === $loc) { echo 'selected'; } ?> >
                                    <?php echo htmlspecialchars($loc); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="arrival">Arrival Locations</label>
                        <select id="arrival" name="arrival">
                            <option value="">All Locations</option>
                            <?php foreach ($arrivalLocations as $loc): ?>
                                <option value="<?php echo htmlspecialchars($loc); ?>" <?php if ($filterArrival === $loc) { echo 'selected'; } ?> >
                                    <?php echo htmlspecialchars($loc); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="date_from">Departure From</label>
                        <input type="date" id="date_from" name="date_from"
                            value="<?php echo htmlspecialchars($filterDateFrom); ?>">
                    </div>

                    <div class="filter-group">
                        <label for="date_to">Departure To</label>
                        <input type="date" id="date_to" name="date_to"
                            value="<?php echo htmlspecialchars($filterDateTo); ?>">
                    </div>

                    <div class="sort-group">
                        <label for="sort">Sort By</label>
                        <select id="sort" name="sort">
                            <option value="price_asc" <?php if ($sortBy === 'price_asc'){
                                                                    echo 'selected';
                                                                }?>
                                >Price: Low to High</option>
                            <option value="price_desc" <?php if ($sortBy === 'price_desc'){
                                                                    echo 'selected';
                                                                } ?>
                                >Price: High to Low</option>
                        </select>
                    </div>

                    <div class="filter-buttons">
                        <button type="submit">Apply Filters</button>
                        <a href="flights.php" class="reset">Reset</a>
                    </div>
                </form>
            </div>

            <!-- FLIGHTS TABLE -->
            <?php if (empty($filteredFlights)): ?>
                <div class="empty-state">
                    <h2>No flights found</h2>
                    <p>Try adjusting your search or filters</p>
                    <a href="flights.php">View all flights</a>
                </div>
            <?php else: ?>
                <?php $flightCount = count($filteredFlights); ?>
                <div class="flights-count">
                    Showing <?php echo $flightCount; ?> flight<?php if ($flightCount !== 1) { echo 's'; } ?>
                </div>

                <table class="flights-table">
                    <thead>
                        <tr>
                            <th>Airline</th>
                            <th>Route</th>
                            <th>Departure</th>
                            <th>Arrival</th>
                            <th>Duration</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($filteredFlights as $flight): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($flight['Airline']); ?></td>
                                <td>
                                    <div class="flight-route">
                                        <?php echo htmlspecialchars($flight['Departure_Loc']); ?> to <?php echo htmlspecialchars($flight['Arrival_Loc']); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="flight-time">
                                        <?php echo date('Y-m-d H:i', strtotime($flight['Time_Dept'])); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="flight-time">
                                        <?php echo date('Y-m-d H:i', strtotime($flight['Time_Arrive'])); ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="flight-duration">
                                        <?php echo calculateDuration($flight['Time_Dept'], $flight['Time_Arrive']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="flight-price">
                                        R<?php echo number_format($flight['Price'], 2); ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

        </div>

    </div>

</div>

</body>
</html>
