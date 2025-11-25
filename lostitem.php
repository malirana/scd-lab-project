<?php
session_start();

// User must be logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You must be logged in to report an item.'); window.location='login.html';</script>";
    exit;
}

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db   = "lost_found";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Read form data
$item_name     = $_POST['item_name'];
$description   = $_POST['item_description'];
$location      = $_POST['item_location'];
$date_found    = $_POST['item_date'];
$contact       = $_POST['item_contact'];
$reported_by   = $_SESSION['user_id'];

// Insert into DB
$stmt = $conn->prepare(
    "INSERT INTO found_items (item_name, description, location_found, date_found, contact_info, reported_by)
    VALUES (?, ?, ?, ?, ?, ?)"
);

$stmt->bind_param("sssssi", $item_name, $description, $location, $date_found, $contact, $reported_by);

if ($stmt->execute()) {
    echo "<script>alert('Found item reported successfully!'); window.location='dashboard.html';</script>";
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();
?>
