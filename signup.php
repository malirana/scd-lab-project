<?php
// Step 1: Connect to MySQL
$host = "localhost";
$user = "root";     // default XAMPP user
$pass = "";         // default no password
$db   = "lost_found";

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Collect form data
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

// Step 3: Check if email already exists
$checkEmail = $conn->prepare("SELECT id FROM users WHERE email=?");
$checkEmail->bind_param("s", $email);
$checkEmail->execute();
$checkEmail->store_result();

if ($checkEmail->num_rows > 0) {
    echo "<script>alert('Email already exists. Try another one.'); window.history.back();</script>";
    exit;
}

// Step 4: Insert into database
$stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $fullname, $email, $password);

if ($stmt->execute()) {
    echo "<script>alert('Account created successfully!'); window.location='login.html';</script>";
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();
?>
