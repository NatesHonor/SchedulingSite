<?php
session_start();

if (!isset($_SESSION['valid_token']) || $_SESSION['valid_token'] !== true) {
    header("Location: index.php?error=invalid_token");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $discordUsername = trim($_POST['discord_username']);
    if (empty($discordUsername)) {
        $discordUsernameErr = "Discord Username is required";
    } else {
    }

    $selectedDateTime = $_POST['selected_datetime'];

    $allowedDates = ['2023-08-01', '2023-08-02'];
    $selectedDate = date('Y-m-d', strtotime($selectedDateTime));
    if (!in_array($selectedDate, $allowedDates)) {
        $selectedDateTimeErr = "Please select a date from August 1st or 2nd.";
    }

    if (empty($discordUsernameErr) && empty($selectedDateTimeErr)) {
        include 'db_connect.php';

        $sanitizedUsername = $conn->real_escape_string($discordUsername);

        $insertQuery = "INSERT INTO user_entries (discord_username, timestamp_entry) VALUES ('$sanitizedUsername', '$selectedDateTime')";
        if ($conn->query($insertQuery) === TRUE) {
            header("Location: success.php");
            exit();
        } else {
            echo "Error: " . $insertQuery . "<br>" . $conn->error;
        }

        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Next Page</title>
</head>
<body>
    <h1>Dev Meeting Time Scheduling</h1>
    <form action="" method="POST">
        <label for="discord_username">Discord Username:</label>
        <input type="text" name="discord_username" id="discord_username" required>
        <?php if (isset($discordUsernameErr)) { ?>
            <span style="color: red;"><?php echo $discordUsernameErr; ?></span>
        <?php } ?>

        <br><br>
        <label for="selected_datetime">Select a date and time (EST):</label>
        <input type="datetime-local" name="selected_datetime" id="selected_datetime" required>
        <?php if (isset($selectedDateTimeErr)) { ?>
            <span style="color: red;"><?php echo $selectedDateTimeErr; ?></span>
        <?php } ?>

        <br><br>
        <p>Note: Times are in Eastern Standard Time (EST).</p>
        <p>Convert your time to EST using this <a href="https://www.timeanddate.com/worldclock/converter.html" target="_blank">Time Zone Converter</a>.</p>

        <br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
