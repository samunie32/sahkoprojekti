<?php
// Open database connection
$servername = 'localhost';
$username = 'root';
$password = '4321';
$dbname = 'sahko';
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Import weather data
$base_url = "https://opendata.fmi.fi/wfs/fin?request=getFeature";

$params = array(
    "storedquery_id" => "fmi::forecast::hirlam::surface::point::multipointcoverage",
    "place" => "Helsinki",
    "parameters" => "temperature,windspeedms,precipitation1h",
    "starttime" => "now",
    "endtime" => "next24hours",
    "timestep" => "60",
    "timezone" => "Europe/Helsinki",
    "format" => "json"
);

$response = file_get_contents($base_url . '&' . http_build_query($params));

$data = json_decode($response, true);

foreach ($data["features"] as $feature) {
    $properties = $feature["properties"];
    $timestamp = $properties["time"];
    $temperature = $properties["temperature"];
    $wind_speed = $properties["windspeedms"];
    $precipitation = $properties["precipitation1h"];

    $add_data = "INSERT INTO saatiedot (timestamp, temperature, wind_speed, precipitation)
                VALUES ('$timestamp', '$temperature', '$wind_speed', '$precipitation')";

    mysqli_query($conn, $add_data);
}

// Close database connection
mysqli_close($conn);
