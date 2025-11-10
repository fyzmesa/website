## WEBSITE
# How to make a dynamic website using: HTML, CSS, PHP, MySQL and Apache2

# 1. Install softwares and dependencies
```bash
sudo apt install apache2
sudo apt install mariadb-server mariadb-client php
sudo apt install php-mysql php-xml php-curl php-mbstring
sudo apt install libapache2-mod-php
```

# 2. Create the database and user
```bash
sudo mysql -u root -p
```

```sql
CREATE DATABASE people;
USE people;

CREATE TABLE people (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100)
);

CREATE USER 'admin'@'localhost' IDENTIFIED BY 'ENTERYOURPASSWORD';
GRANT ALL PRIVILEGES ON simple_website.* TO 'admin'@'localhost';
FLUSH PRIVILEGES;
```

# 3. Create the HTML form (form.html)
```xml
<!DOCTYPE html>
<html>
<head>
    <title>Simple Site Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Add Person</h2>
    <form action="add.php" method="POST">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <input type="submit" value="Add">
    </form>
</body>
</html>
```

# 4. Create the CSS file (style.css)
```css
body {
    font-family: Arial, sans-serif;
    background: #f9f9f9;
    margin: 40px;
}
form {
    background: #fff;
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 8px;
    width: 300px;
}
label {
    font-weight: bold;
}
input[type="text"], input[type="email"] {
    width: 95%;
    padding: 8px;
    margin: 5px 0 10px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
}
input[type="submit"] {
    background: #28a745;
    color: #fff;
    border: none;
    padding: 10px 18px;
    border-radius: 4px;
    cursor: pointer;
}
input[type="submit"]:hover {
    background: #218838;
}
```

# 5. Create the PHP file to handle form submission (add.php)
```php
<?php
$servername = "localhost";
$username = "admin";
$password = "ENTERYOURPASSWORD";
$dbname = "simple_site";

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
    echo "New record added successfully. <a href='list.php'>See all people</a>";
} else {
    echo "Error: " . $stmt->error;
}
$stmt->close();
$conn->close();
?>
```

# 6. Create the PHP file to display records (list.php) 
```php
<?php
$servername = "localhost";
$username = "admin";     
$password = "ENTERYOURPASSWORD";
$dbname = "simple_site";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>People List</h2>";
echo "<table border='1'><tr><th>Name</th><th>Email</th></tr>";

$sql = "SELECT name, email FROM people";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
    echo "<tr><td>" . htmlspecialchars($row["name"]) . "</td><td>" . htmlspecialchars($row["email"]) . "</td></tr>";
}
echo "</table><br><a href='form.html'>Add another person</a>";

$conn->close();
?>
```
