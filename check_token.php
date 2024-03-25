<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $sanitized_token = $conn->real_escape_string($token);

    $query = "SELECT * FROM tokens WHERE token_code = '$sanitized_token'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        session_start();
        $_SESSION['valid_token'] = true;
        header("Location: next_page.php");
        exit();
    } else {
        echo "Invalid token";
    }
}

$conn->close();
?>
