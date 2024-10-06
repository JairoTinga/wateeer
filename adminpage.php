<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Water Test</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="navbar">
        <a href="adminpage.php" class="tab">Water Levels</a>
        <a href="water_level_history.php" class="tab">Water Level History</a>
        <a href="sms.php" class="tab">SMS</a>
    </div>
    <div class="center-box">
        <!-- Add a meter scale on the left side -->
        <div class="meter-scale">
            <div class="meter-level">6m</div>
            <div class="meter-level">5m</div>
            <div class="meter-level">4m</div>
            <div class="meter-level">3m</div>
            <div class="meter-level">2m</div>
            <div class="meter-level">1m</div>
            <div class="meter-level">0m</div>
        </div>
        <div class="water-container" style="height: 500px; position: relative;">
            <div class="water-bar" style="position: absolute; bottom: 0; width: 100%; background-color: blue;"></div>
            <div class="ripple"></div>
        </div>
    </div>
    <!-- <div class="time-intervals">
        <button class="time-btn" data-interval="2s">2s</button>
        <button class="time-btn" data-interval="1hr">1hr</button>
        <button class="time-btn" data-interval="1day">1 day</button>
        <button class="time-btn" data-interval="1week">1 week</button>
        <button class="time-btn" data-interval="1month">1 month</button>
        <button class="time-btn" data-interval="3months">3 months</button>
        <button class="time-btn" data-interval="1year">1 year</button>
        <button class="time-btn" data-interval="all-time">All-time</button>
     </di> -->

    <script>
  $(document).ready(function() {
    var waterLevel = 0;

    function updateWaterLevel() {
      $.ajax({
        type: "GET",
        url: "https://blynk.cloud/external/api/get?token=A2aaNzwGNXBJC6pjxQj1NZhfqOC-Y6Ls&V0", // Replace with your Blynk Token and Virtual Pin
        dataType: "json",
        success: function(data) {
          waterLevel = parseFloat(data);

          // Reverse the water level for display (0 meters on sensor = 6 meters on display)
          var displayWaterLevel = 6 - waterLevel;

          let waterHeight = (displayWaterLevel / 6) * 500; // Convert water level to height (500px max)

          console.log("Sensor water level: " + waterLevel);
          console.log("Display water level: " + displayWaterLevel);
          console.log("Water height: " + waterHeight);

          // Update water level bar height
          $(".water-bar").css("height", waterHeight + "px");

          // Adjust signal color based on display water level
          if (displayWaterLevel >= 5) {
            $(".water-bar").css("background-color", "red"); // Red alert, high water level (dangerous)
          } else if (displayWaterLevel >= 3 && displayWaterLevel < 5) {
            $(".water-bar").css("background-color", "yellow"); // Yellow alert, moderate water level
          } else {
            $(".water-bar").css("background-color", "green"); // Green, safe water level
          }
        },
        error: function(xhr, status, error) {
          console.log(xhr.responseText);
        }
      });
    }

    // Set interval to update water level from Blynk API every 2 seconds
    setInterval(updateWaterLevel, 2000);
  });
</script>

</body>
</html>
