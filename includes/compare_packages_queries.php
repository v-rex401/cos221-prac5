<?php
    /* Anke de Frey u24611400


        When the database is ready:
        - replace the body of mockComparisonPackages() with a real query
            (the $conn parameter is already passed through), and
        - keep the SAME array shape (see one package below) so the page
            and its JavaScript keep working unchanged.

        Shape of one package record:
        id            int
        name          string   - package title
        location      string   - destination location
        image         string   - image URL (leave '' to use a placeholder)
        theme         string   - placeholder gradient: tropical|city|
                                mountain|metro|ocean|island
        duration      int      - number of days
        flight        [ airline, route, class, stops ]
        accommodation [ name, type, stars (1-5), nights ]
        meals         string   - meals included
        activities    string[] - activities included
        transfers     string   - transfer arrangements
        rating        float    - traveller rating (out of 5)
        reviews       int      - number of traveller reviews
        costs         [ flights, accommodation, activities, meals,
                        transfers, taxes ]   (Rand amounts)
        costs.total   int      - added automatically below
        price         int      - added automatically (equals costs.total)
    */

    /*  Returns every package available for comparison, as full records.
        The comparison page embeds this for its dropdowns and JavaScript. */
    function getComparisonPackages($conn = null){
        // TODO (backend): replace mockComparisonPackages() with a real query,
        $packages = mockComparisonPackages();

        // Derive each package's total + headline price from its breakdown
        // so the cost table and the price always stay consistent.
        foreach($packages as &$package){
            $package['costs']['total'] = (int) array_sum([
                $package['costs']['flights'],
                $package['costs']['accommodation'],
                $package['costs']['activities'],
                $package['costs']['meals'],
                $package['costs']['transfers'],
                $package['costs']['taxes'],
            ]);
            $package['price'] = $package['costs']['total'];
        }
        unset($package);

        return $packages;
    }

    /*  Convenience list of { id, name, location } used to populate the
        "Select Package 1" / "Select Package 2" dropdown selectors. */
    function getComparisonPackageOptions($conn = null){
        $options = [];
        foreach(getComparisonPackages($conn) as $package){
            $options[] = [
                'id'       => $package['id'],
                'name'     => $package['name'],
                'location' => $package['location'],
            ];
        }
        return $options;
    }

    /*  Look up a single package record by its id (mock helper). */
    function getComparisonPackageById($conn, $packageID){
        foreach(getComparisonPackages($conn) as $package){
            if($package['id'] == $packageID){
                return $package;
            }
        }
        return null;
    }

    /*  The mock dataset - realistic sample packages with every field the
        comparison page needs. Prices are in South African Rand (R). */
    function mockComparisonPackages(){
        return [
            [
                'id'        => 1,
                'name'      => 'Bali Beach Escape',
                'location'  => 'Bali, Indonesia',
                'image'     => '',
                'theme'     => 'tropical',
                'duration'  => 7,
                'flight'    => [
                    'airline' => 'Singapore Airlines',
                    'route'   => 'Johannesburg to Denpasar',
                    'class'   => 'Economy',
                    'stops'   => '1 stop (Singapore)',
                ],
                'accommodation' => [
                    'name'   => 'The Coral Beachfront Resort',
                    'type'   => 'Beachfront Resort',
                    'stars'  => 5,
                    'nights' => 6,
                ],
                'meals'      => 'Breakfast & dinner daily',
                'activities' => [
                    'Uluwatu Temple tour',
                    'Nusa Penida snorkeling trip',
                    'Tegalalang rice terrace hike',
                    'Balinese cooking class',
                ],
                'transfers'  => 'Private airport transfers + daily resort shuttle',
                'rating'     => 4.7,
                'reviews'    => 128,
                'costs'      => [
                    'flights'       => 9800,
                    'accommodation' => 8400,
                    'activities'    => 2600,
                    'meals'         => 1800,
                    'transfers'     => 900,
                    'taxes'         => 1499,
                ],
            ],
            [
                'id'        => 2,
                'name'      => 'Paris City Break',
                'location'  => 'Paris, France',
                'image'     => '',
                'theme'     => 'city',
                'duration'  => 5,
                'flight'    => [
                    'airline' => 'Air France',
                    'route'   => 'Johannesburg to Paris CDG',
                    'class'   => 'Economy',
                    'stops'   => 'Direct',
                ],
                'accommodation' => [
                    'name'   => 'Hotel Le Marais',
                    'type'   => 'Boutique City Hotel',
                    'stars'  => 4,
                    'nights' => 4,
                ],
                'meals'      => 'Breakfast daily',
                'activities' => [
                    'Louvre Museum guided tour',
                    'Seine River dinner cruise',
                    'Eiffel Tower summit access',
                ],
                'transfers'  => 'Shared airport shuttle + 5-day metro pass',
                'rating'     => 4.5,
                'reviews'    => 212,
                'costs'      => [
                    'flights'       => 11200,
                    'accommodation' => 7600,
                    'activities'    => 3200,
                    'meals'         => 2400,
                    'transfers'     => 700,
                    'taxes'         => 1390,
                ],
            ],
            [
                'id'        => 3,
                'name'      => 'Cape Town Explorer',
                'location'  => 'Cape Town, South Africa',
                'image'     => '',
                'theme'     => 'mountain',
                'duration'  => 6,
                'flight'    => [
                    'airline' => 'FlySafair',
                    'route'   => 'Johannesburg to Cape Town',
                    'class'   => 'Economy',
                    'stops'   => 'Direct',
                ],
                'accommodation' => [
                    'name'   => 'Table Bay View Hotel',
                    'type'   => 'City & Sea Hotel',
                    'stars'  => 4,
                    'nights' => 5,
                ],
                'meals'      => 'Breakfast daily + 2 dinners',
                'activities' => [
                    'Table Mountain cableway',
                    'Cape Peninsula day tour',
                    'Robben Island ferry & tour',
                    'Winelands tasting trip',
                    'V&A Waterfront harbour cruise',
                ],
                'transfers'  => 'Private airport transfers + tour transport',
                'rating'     => 4.6,
                'reviews'    => 95,
                'costs'      => [
                    'flights'       => 3200,
                    'accommodation' => 6300,
                    'activities'    => 2900,
                    'meals'         => 1600,
                    'transfers'     => 850,
                    'taxes'         => 640,
                ],
            ],
            [
                'id'        => 4,
                'name'      => 'Tokyo Adventure',
                'location'  => 'Tokyo, Japan',
                'image'     => '',
                'theme'     => 'metro',
                'duration'  => 9,
                'flight'    => [
                    'airline' => 'Cathay Pacific',
                    'route'   => 'Johannesburg to Tokyo Haneda',
                    'class'   => 'Economy',
                    'stops'   => '1 stop (Hong Kong)',
                ],
                'accommodation' => [
                    'name'   => 'Shinjuku Sky Hotel',
                    'type'   => 'Modern City Hotel',
                    'stars'  => 4,
                    'nights' => 8,
                ],
                'meals'      => 'Breakfast daily',
                'activities' => [
                    'Mt Fuji & Hakone day trip',
                    'Shibuya & Harajuku walking tour',
                    'Sushi-making workshop',
                    'TeamLab digital art museum',
                    'Asakusa temple & river cruise',
                ],
                'transfers'  => 'Airport express tickets + 7-day metro pass',
                'rating'     => 4.8,
                'reviews'    => 164,
                'costs'      => [
                    'flights'       => 13500,
                    'accommodation' => 11700,
                    'activities'    => 4100,
                    'meals'         => 3100,
                    'transfers'     => 1200,
                    'taxes'         => 1890,
                ],
            ],
            [
                'id'        => 5,
                'name'      => 'Santorini Luxury Getaway',
                'location'  => 'Santorini, Greece',
                'image'     => '',
                'theme'     => 'ocean',
                'duration'  => 8,
                'flight'    => [
                    'airline' => 'Emirates',
                    'route'   => 'Johannesburg to Santorini',
                    'class'   => 'Business',
                    'stops'   => '1 stop (Dubai)',
                ],
                'accommodation' => [
                    'name'   => 'Caldera Cliff Suites',
                    'type'   => 'Luxury Cliffside Suites',
                    'stars'  => 5,
                    'nights' => 7,
                ],
                'meals'      => 'All-inclusive (breakfast, lunch & dinner)',
                'activities' => [
                    'Private caldera sunset cruise',
                    'Oia village & winery tour',
                    'Volcano & hot springs trip',
                    'Couples spa experience',
                ],
                'transfers'  => 'Private luxury transfers throughout',
                'rating'     => 4.9,
                'reviews'    => 87,
                'costs'      => [
                    'flights'       => 12800,
                    'accommodation' => 18400,
                    'activities'    => 3600,
                    'meals'         => 4200,
                    'transfers'     => 1500,
                    'taxes'         => 2490,
                ],
            ],
            [
                'id'        => 6,
                'name'      => 'Zanzibar Island Retreat',
                'location'  => 'Zanzibar, Tanzania',
                'image'     => '',
                'theme'     => 'island',
                'duration'  => 5,
                'flight'    => [
                    'airline' => 'Kenya Airways',
                    'route'   => 'Johannesburg to Zanzibar',
                    'class'   => 'Economy',
                    'stops'   => '1 stop (Nairobi)',
                ],
                'accommodation' => [
                    'name'   => 'Nungwi Sands Lodge',
                    'type'   => 'Beach Lodge',
                    'stars'  => 3,
                    'nights' => 4,
                ],
                'meals'      => 'Breakfast daily',
                'activities' => [
                    'Stone Town heritage walk',
                    'Spice farm tour',
                    'Dhow sunset sail',
                ],
                'transfers'  => 'Shared airport transfers',
                'rating'     => 4.2,
                'reviews'    => 61,
                'costs'      => [
                    'flights'       => 6400,
                    'accommodation' => 4250,
                    'activities'    => 1500,
                    'meals'         => 1100,
                    'transfers'     => 600,
                    'taxes'         => 640,
                ],
            ],
        ];
    }
?>
