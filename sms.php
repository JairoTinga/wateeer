<?php
// Include the connection file
include 'connection.php'; // Ensure this points to your connection.php

// Add a new phone number
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['phone_number'])) {
    $newPhoneNumber = htmlspecialchars($_POST['phone_number']);
    if (!empty($newPhoneNumber)) {
        // Insert new phone number into the database
        $stmt = $conn->prepare("INSERT INTO phone_numbers (phone_number) VALUES (:phone_number)");
        $stmt->execute(['phone_number' => $newPhoneNumber]);
        
        // Redirect to prevent form resubmission
        header('Location: sms.php');
        exit; // Always call exit after header redirection
    }
}

// Delete a phone number
if (isset($_GET['delete'])) {
    $idToDelete = (int) $_GET['delete'];
    // Delete the phone number from the database
    $stmt = $conn->prepare("DELETE FROM phone_numbers WHERE id = :id");
    $stmt->execute(['id' => $idToDelete]);

    // Redirect to prevent accidental resubmission
    header('Location: sms.php');
    exit; // Always call exit after header redirection
}

// Fetch all phone numbers from the database
$stmt = $conn->query("SELECT * FROM phone_numbers");
$phoneNumbers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMS</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="navbar">
        <a href="adminpage.php" class="tab">Water Levels</a>
        <a href="water_level_history.php" class="tab">Water Level History</a>
        <a href="sms.php" class="tab">SMS</a>
    </div>

    <div class="center-box">
        <h2>SMS Receiver List</h2>
        
        <!-- List of phone numbers -->
        <ul class="receiver-list">
            <?php if (!empty($phoneNumbers)): ?>
                <?php foreach ($phoneNumbers as $phoneNumber): ?>
                    <li class="receiver-item">
                        <span><?php echo htmlspecialchars($phoneNumber['phone_number']); ?></span>
                        <a href="?delete=<?php echo $phoneNumber['id']; ?>" class="delete-btn">X</a>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No phone numbers added yet.</li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- Input form for adding a phone number -->
    <form action="sms.php" method="post">
        <input type="text" id="add-phone-input" name="phone_number" placeholder="Enter phone number" required>
        <button type="submit" id="add-btn">Add</button>
    </form>

</body>
</html>
