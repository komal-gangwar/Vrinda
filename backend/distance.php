<?php
function haversineDistance($lat1, $lon1, $lat2, $lon2, $unit = 'K') {
    // Convert degrees to radians
    $lat1 = deg2rad($lat1);
    $lon1 = deg2rad($lon1);
    $lat2 = deg2rad($lat2);
    $lon2 = deg2rad($lon2);

    // Radius of Earth in different units
    $earth_radius_km = 6371; // Kilometers
    $earth_radius_miles = 3959; // Miles

    // Haversine formula
    $dlat = $lat2 - $lat1;
    $dlon = $lon2 - $lon1;

    $a = sin($dlat/2) * sin($dlat/2) +
         cos($lat1) * cos($lat2) *
         sin($dlon/2) * sin($dlon/2);

    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    $distance = $earth_radius_km * $c; // default in kilometers

    if ($unit == 'M') {
        $distance = $earth_radius_miles * $c; // in miles
    } elseif ($unit == 'N') {
        $distance = $earth_radius_km * $c * 0.539957; // in nautical miles
    }

    return $distance;
}
?>