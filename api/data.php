<?php
// Load JSON files
$zonesData = json_decode(file_get_contents('../data/zones.json'), true);
$countriesData = json_decode(file_get_contents('../data/countries.json'), true);
$statesData = json_decode(file_get_contents('../data/states.json'), true);

// Function to extract `data` from phpMyAdmin-style JSON
function extractTableData($jsonArray, $tableName) {
    if (is_array($jsonArray)) {
        foreach ($jsonArray as $item) {
            if (isset($item['type'], $item['name'], $item['data']) && 
                $item['type'] === 'table' && 
                $item['name'] === $tableName) {
                return $item['data'];
            }
        }
    }
    return null;
}

// Extract data arrays
$zones = extractTableData($zonesData, 'zones');
$countries = extractTableData($countriesData, 'countries');
$states = extractTableData($statesData, 'states');

var_dump($zones, $countries, $states);
die(); 
?>