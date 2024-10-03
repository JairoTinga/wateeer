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
    <div class="time-intervals">
        <button class="time-btn" data-interval="2s">2s</button>
        <button class="time-btn" data-interval="1hr">1hr</button>
        <button class="time-btn" data-interval="1day">1 day</button>
        <button class="time-btn" data-interval="1week">1 week</button>
        <button class="time-btn" data-interval="1month">1 month</button>
        <button class="time-btn" data-interval="3months">3 months</button>
        <button class="time-btn" data-interval="1year">1 year</button>
        <button class="time-btn" data-interval="all-time">All-time</button>
    </div>

    <script>
      $(document).ready(function() {
        var waterLevel = 0;
        var signalColor = 'green';

        function updateWaterLevel() {
          $.ajax({
            type: "POST",
            url: "get_current_water_level.php",
            dataType: "json",
            success: function(data) {
              waterLevel = data.water_level;
              signalColor = data.signal_color;

              // Adjust signal color based on water level
              if (waterLevel >= 0 && waterLevel < 2) {
                signalColor = 'green';
              } else if (waterLevel >= 2 && waterLevel < 4) {
                signalColor = 'yellow';
              } else {
                signalColor = 'red';
              }

              $("#water-level-value").text(waterLevel.toFixed(2));
              $("#signal-color").text(signalColor);

              let waterHeight = (waterLevel / 6) * 600; // Convert water level to height

              console.log("Water level: " + waterLevel);
              console.log("Signal color: " + signalColor);
              console.log("Water height: " + waterHeight);
              
              $(".water-bar").css("height", waterHeight + "px");
            },
            error: function(xhr, status, error) {
              console.log(xhr.responseText);
            }
          });
        }

        // Handle time interval clicks
        $(".time-btn").click(function() {
          var interval = $(this).data("interval");
          console.log("Selected interval: " + interval);
          // Logic to adjust graph for the selected time interval
        });

        setInterval(updateWaterLevel, 1000); // Update every 1 second
      });
    </script>
</body>
</html>
