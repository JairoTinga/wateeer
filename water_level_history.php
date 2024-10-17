<?php
// Include the Firebase SDK via Composer's autoload
require 'vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

// Path to the Firebase Service Account JSON file
$serviceAccount = 'C:/xampp/htdocs/water/firebase/waterr-15387-firebase-adminsdk-e89jr-870f5f8395.json';

// Initialize Firebase
$firebase = (new Factory)
    ->withServiceAccount($serviceAccount)
    ->withDatabaseUri('https://waterr-15387-default-rtdb.asia-southeast1.firebasedatabase.app/') // Replace with your Firebase Realtime Database URL
    ->createDatabase();

// Get selected date from the URL, default to today's date if none selected
$selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// Firebase reference to "/FloodMonitor/Records"
$database = $firebase->getReference('FloodMonitor/Records');
$records = $database->getValue();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Level History</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        $(function() {
            flatpickr("#datepicker", {
                dateFormat: 'Y-m-d',
                onChange: function(selectedDates, dateStr, instance) {
                    window.location.href = "water_level_history.php?date=" + dateStr;
                },
                defaultDate: "<?php echo $selectedDate; ?>"
            });
        });
    </script>
</head>
<body>
    <div class="navbar">
        <a href="adminpage.php" class="tab">Water Level</a>
        <a href="water_level_history.php" class="tab">Water Level History</a>
        <a href="sms.php" class="tab">SMS</a>
    </div>
    <div class="container">
        <div class="datepicker-container">
            <input type="text" id="datepicker" placeholder="Select Date">
        </div>

        <div class="table-container">
        <?php
        if ($records) {
            echo "<h3>Water Level History for " . htmlspecialchars($selectedDate) . "</h3>";
            echo "<table class='history-table'>";
            echo "<thead><tr><th>Date & Time</th><th>Water Level</th></tr></thead><tbody>";

            // Loop through each record in Records
            foreach ($records as $record) {
                if (isset($record['tm']) && isset($record['lvl'])) {
                    // Convert the Firebase time format to a DateTime object
                    $recordDateTime = DateTime::createFromFormat('d/m/Y H:i:s', $record['tm']);
                    // Check if the date matches the selected date
                    if ($recordDateTime && $recordDateTime->format('Y-m-d') === $selectedDate) {
                        echo "<tr><td>" . htmlspecialchars($record['tm']) . "</td><td>" . htmlspecialchars($record['lvl']) . "</td></tr>";
                    }
                }
            }

            echo "</tbody></table>";
        } else {
            echo "<p>No records found.</p>";
        }
        ?>
        </div>
    </div>
</body>
</html>
