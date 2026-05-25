<?php
    /*  Anke de Frey u24611400

        Comparison page data — real database queries.

        Every comparison record is built from getPackageDetails()
        (defined in traveller_dashboard_queries.php), so all data on the
        comparison page comes straight from the database. Nothing here is
        mock data or hardcoded. */

    require_once __DIR__ . '/traveller_dashboard_queries.php';

    /*  Returns every package as a comparison record. The comparison page
        embeds this list for its dropdowns and JavaScript. */
    function getComparisonPackages($conn){
        $packages = [];

        foreach(getAllPackages($conn) as $row){
            $details = getPackageDetails($conn, $row['Package_ID']);
            if($details === null){
                continue;
            }
            $packages[] = buildComparisonRecord($details);
        }

        return $packages;
    }

    /*  Turns a getPackageDetails() result into the flat record shape the
        comparison page's JavaScript expects. */
    function buildComparisonRecord($details){
        // location — every destination this package covers
        $destinationNames = [];
        foreach($details['destinations'] as $destination){
            $destinationNames[] = $destination['Name'] . ', ' . $destination['Country'];
        }
        if(empty($destinationNames)){
            $location = 'Destination not set';
        } else {
            $location = implode('  •  ', $destinationNames);
        }

        // image — first package image, if the agency added one
        if(!empty($details['images'])){
            $image = $details['images'][0]['Image_URL'];
        } else {
            $image = '';
        }

        // flights — airline, route and the price set on the flight
        $flights = [];
        $flightsTotal = 0;
        foreach($details['flights'] as $flight){
            $flights[] = [
                'airline' => $flight['Airline'],
                'route'   => $flight['Departure_Loc'] . ' to ' . $flight['Arrival_Loc'],
                'price'   => (float)$flight['Price'],
            ];
            $flightsTotal = $flightsTotal + (float)$flight['Price'];
        }

        // accommodation — name, type and the per-night price
        $accommodations = [];
        $accommodationPerNight = 0;
        foreach($details['accommodations'] as $accommodation){
            $accommodations[] = [
                'name'    => $accommodation['Name'],
                'type'    => $accommodation['Type'],
                'pricePN' => (float)$accommodation['Price_PN'],
            ];
            $accommodationPerNight = $accommodationPerNight + (float)$accommodation['Price_PN'];
        }

        // attractions — just the names
        $attractions = [];
        foreach($details['attractions'] as $attraction){
            $attractions[] = $attraction['Name'];
        }

        // restaurants — name and cuisine
        $restaurants = [];
        foreach($details['restaurants'] as $restaurant){
            $restaurants[] = [
                'name'    => $restaurant['Name'],
                'cuisine' => $restaurant['Cuisine'],
            ];
        }

        return [
            'id'                    => (int)$details['Package_ID'],
            'name'                  => $details['package_name'],
            'location'              => $location,
            'image'                 => $image,
            'agency'                => $details['agency_name'],
            'duration'              => (int)$details['Duration'],
            'price'                 => (float)$details['full_price'],
            'fee'                   => (float)$details['Price'],
            'capacity'              => (int)$details['Capacity'],
            'spotsLeft'             => (int)$details['spots_left'],
            'rating'                => (float)$details['avg_rating'],
            'reviews'               => (int)$details['review_count'],
            'flights'               => $flights,
            'flightsTotal'          => $flightsTotal,
            'accommodations'        => $accommodations,
            'accommodationPerNight' => $accommodationPerNight,
            'attractions'           => $attractions,
            'restaurants'           => $restaurants,
        ];
    }
?>
