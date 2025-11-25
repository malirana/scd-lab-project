<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lost_found";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_name = $conn->real_escape_string($_POST['item_name']);
    $item_description = $conn->real_escape_string($_POST['item_description']);
    $item_location = $conn->real_escape_string($_POST['item_location']);
    $item_date = $_POST['item_date'];
    $item_contact = $conn->real_escape_string($_POST['item_contact']);

    // Insert into database
    $sql = "INSERT INTO found_items (item_name, item_description, item_location, item_date, item_contact) 
            VALUES ('$item_name', '$item_description', '$item_location', '$item_date', '$item_contact')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Item reported successfully!'); window.location='dashboard.html';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
