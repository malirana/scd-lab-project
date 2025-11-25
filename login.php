<?php
session_start();

// DB Connection
$host = "localhost";
$user = "root";
$pass = "";
$db   = "lost_found";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Read form data
$email = $_POST['email'];
$password = $_POST['password'];

// Check if email exists
$stmt = $conn->prepare("SELECT id, fullname, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Email not found!'); window.history.back();</script>";
    exit;
}

$user = $result->fetch_assoc();

// Verify password
if (!password_verify($password, $user['password'])) {
    echo "<script>alert('Incorrect password!'); window.history.back();</script>";
    exit;
}

// Save user session
$_SESSION['user_id'] = $user['id'];
$_SESSION['fullname'] = $user['fullname'];
$_SESSION['email'] = $email;

// Redirect to dashboard
echo "<script>alert('Login successful!'); window.location='dashboard.html';</script>";
?>
