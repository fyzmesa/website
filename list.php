<?php
$servername = "localhost";
$username = "admin";     
$password = "ENTERYOURPASSWORD";
$dbname = "people";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>People List</h2>";
echo "<table border='0' class='center-table'><tr><th>Name</th><th>Email</th></tr>";

$sql = "SELECT name, email FROM people";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
    echo "<tr><td>" . htmlspecialchars($row["name"]) . "</td><td>" . htmlspecialchars($row["email"]) . "</td></tr>";
}
echo "</table>";

$conn->close();
?>
