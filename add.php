<?php
$servername = "localhost";
$username = "admin";
$password = "ENTERYOURPASSWORD";
$dbname = "people";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];

$sql = "INSERT INTO people (name, email) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $name, $email);

if ($stmt->execute()) {
    echo "New record added successfully. <a href='list.html'>See all people</a>";
} else {
    echo "Error: " . $stmt->error;
}
$stmt->close();
$conn->close();
?>
