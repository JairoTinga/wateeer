<?php
// Remove Firebase initialization and database reference
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Level History</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script>
        $(function() {
            $("#datepicker").datepicker({
                dateFormat: 'yy-mm-dd',
                onSelect: function(dateText) {
                    window.location.href = "water_level_history.php?date=" + dateText;
                }
            });
        });
    </script>
</head>
<body>
    <div class="navbar">
        <a href="adminpage.php" class="tab">Water Levels</a>
        <a href="water_level_history.php" class="tab">Water Level History</a>
        <a href="sms.php" class="tab">SMS</a>
    </div>
    <div class="center-box">
        <input type="text" id="datepicker" placeholder="Select Date">

        <?php
        if (isset($_GET['date']) && !empty($_GET['date'])) {
            $selected_date = htmlspecialchars($_GET['date']);
            echo "<h3>Water Level History for $selected_date</h3>";

            // You will need to replace this with your own data retrieval logic
            $data = array(); // Replace with your own data

            if (!empty($data)) {
                echo "<table border='1' cellpadding='10' cellspacing='0'>";
                echo "<thead><tr><th>Time</th><th>Water Level</th></tr></thead>";
                echo "<tbody>";
                foreach ($data as $record) {
                    echo "<tr><td>" . htmlspecialchars($record['time']) . "</td><td>" . htmlspecialchars($record['water_level']) . "</td></tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p>No records found for this date.</p>";
            }
        } else {
            echo "<p>Please select a date to view the history.</p>";
        }
        ?>
    </div>
</body>
</html>