<?php
require 'vendor/autoload.php';
use Kreait\Firebase\Factory;

// Initialize Firebase
$serviceAccount = 'path/to/your/serviceAccount.json';
$firebase = (new Factory)
    ->withServiceAccount($serviceAccount)
    ->withDatabaseUri('https://your-database-url/')
    ->createDatabase();

// Get time range from query parameters
$range = isset($_GET['range']) ? $_GET['range'] : '1';
$timeThreshold = '';

// Calculate time threshold based on the selected range
if ($range == '1') {
    $timeThreshold = date('Y-m-d H:i:s', strtotime('-1 hour'));
} elseif ($range == '24') {
    $timeThreshold = date('Y-m-d H:i:s', strtotime('-24 hours'));
} elseif ($range == '168') {
    $timeThreshold = date('Y-m-d H:i:s', strtotime('-7 days'));
}

// Query your Firebase for data after the threshold
$records = $firebase->getReference('FloodMonitor/Records')
    ->orderByChild('tm') // Assuming 'tm' is your timestamp field
    ->startAt($timeThreshold)
    ->getValue();

// Prepare the data for the chart
$chartData = [];
foreach ($records as $key => $record) {
    $chartData[] = [
        'time' => $record['tm'], // Assuming your timestamp field is 'tm'
        'level' => $record['level'] // Assuming your water level field is 'level'
    ];
}

// Return the filtered data as JSON
header('Content-Type: application/json');
echo json_encode($chartData);
?>
