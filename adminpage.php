<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Added for mobile responsiveness -->
    <link rel="stylesheet" href="style.css">
    <title>Water Test</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="title">
        <h1>Flood Monitoring System: With Real-Time Monitoring</h1>
    </div>
    <div class="navbar">
        <a href="adminpage.php" class="tab">Water Level</a>
        <a href="water_level_history.php" class="tab">Water Level History</a>
        <a href="sms.php" class="tab">SMS</a>
    </div>

    <div class="center-box">
        <!-- Container for meter, graph, and chart -->
<!-- New Box: Graph for real-time water levels -->
<div class="chart-container">
    <canvas id="waterLevelChart"></canvas> <!-- Adjusted Graph Canvas Height -->
</div>


        <div class="meter-graph-container">
            <!-- Meter scale on the left side -->
            <div class="meter-scale">
                <div class="meter-level">6m</div>
                <div class="meter-level">5m</div>
                <div class="meter-level">4m</div>
                <div class="meter-level">3m</div>
                <div class="meter-level">2m</div>
                <div class="meter-level">1m</div>
                <div class="meter-level">0m</div>
            </div>

            <!-- Water graph -->
            <div class="water-container">
                <div class="water-bar"></div>
            </div>
        </div>

        

        <!-- Real-time date and time -->
        <div class="real-time-container">
        <div class="real-time">
            <p id="date-time"></p>
        </div>
    </div>
</div>

    <script>
        $(document).ready(function() {
            var waterLevel = 0;
            var chartData = [];  // Array to store water level history
            var labels = [];     // Array to store corresponding time

            // Initialize the Chart.js graph
            var ctx = document.getElementById('waterLevelChart').getContext('2d');
            var waterLevelChart = new Chart(ctx, {
                type: 'line',  // Choose the type of graph (line graph)
                data: {
                    labels: labels,  // Time labels on X-axis
                    datasets: [{
                        label: 'Water Level (m)',  // Label for the line
                        data: chartData,  // Water level data
                        borderColor: 'green',  // Line color
                        fill: false,  // No filling under the line
                    }]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Time'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Water Level (m)'
                            },
                            min: 0, // Set minimum y-axis value
                            max: 6  // Set maximum y-axis value (based on the meter)
                        }
                    }
                }
            });

            // Function to update water level from Blynk
            function updateWaterLevel() {
                $.ajax({
                    type: "GET",
                    url: "https://blynk.cloud/external/api/get?token=A2aaNzwGNXBJC6pjxQj1NZhfqOC-Y6Ls&V0", // Replace with your Blynk Token and Virtual Pin
                    dataType: "json",
                    success: function(data) {
                        waterLevel = parseFloat(data);

                        // Reverse the water level for display (0 meters on sensor = 6 meters on display)
                        var displayWaterLevel = 6 - waterLevel;

                        let waterHeight = (displayWaterLevel / 6) * 235; // Convert water level to height (500px max)

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

                        // Add data to the chart
                        var now = new Date().toLocaleTimeString();  // Get current time
                        labels.push(now);  // Add current time to labels
                        chartData.push(displayWaterLevel);  // Add water level to chart data

                        // Update chart
                        waterLevelChart.update();
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            }

            // Function to update the date and time display
            function updateDateTime() {
                var now = new Date();
                var dateTimeString = now.toLocaleString();
                $("#date-time").text("Date and Time: " + dateTimeString);
            }

            // Set interval to update water level from Blynk API every 2 seconds
            setInterval(updateWaterLevel, 5000);
            setInterval(updateDateTime, 1000);
        });
    </script>

</body>
</html>