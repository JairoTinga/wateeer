<?php
  // Check if the request is a POST request
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the water level and signal color from the POST request
    $waterLevel = $_POST['water_level'];
    $signalColor = $_POST['signal_color'];

    // Update the water level and signal color
    $data = array('water_level' => $waterLevel, 'signal_color' => $signalColor);

    // Output the updated data in JSON format
    echo json_encode($data);
  } else {
    // If the request is not a POST request, output an error message
    echo 'Error: Invalid request method';
  }
?>