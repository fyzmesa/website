# WEBSITE
## How to make a dynamic website using: HTML, CSS, PHP, MySQL and Apache2

### 1. Install softwares and dependencies
```bash
sudo apt install apache2
sudo apt install mariadb-server mariadb-client php
sudo apt install php-mysql php-xml php-curl php-mbstring
sudo apt install libapache2-mod-php
```

### 2. Create the database and user
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

### 3. Create the HTML form (form.html)
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
    <a href="list.html">Show list</a>
</body>
</html>
```

### 4. Create the CSS file (style.css)
```css
body {
    background: #f5f8fa;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.table-page {
    width: 500px;
    margin: 60px auto;
    background: #fff;
    padding: 30px 40px 20px 40px;
    border-radius: 14px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.11);
    text-align: center;
}

h2 {
    margin-bottom: 22px;
}

.center-table {
    margin-left: auto;
    margin-right: auto;
    width: 100%;
    border-collapse: collapse;
}

.center-table th, .center-table td {
    padding: 12px 14px;
    text-align: center;
    border-bottom: 1px solid #ececec;
}

.center-table th {
    color: #fff;
    background: #007bff;
}

.center-table tr:nth-child(even) {
    background: #f1f6fc;
}

.center-table tr:last-child td {
    border-bottom: none;
}

a {
    display: block;
    margin-top: 22px;
    color: #007bff;
    text-decoration: none;
    font-size: 1em;
}

a:hover {
    text-decoration: underline;
}

```

### 5. Create the PHP file to handle form submission (add.php)
```php
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
    echo "New record added successfully. <a href='list.php'>See all people</a>";
} else {
    echo "Error: " . $stmt->error;
}
$stmt->close();
$conn->close();
?>
```

### 6. Create the PHP file to display records (list.php) 
```php
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
```

### 7. Create the HTML that calls list.php (list.html)
```xml
<!DOCTYPE html>
<html>
<head>
    <title>People List</title>
    <link rel="stylesheet" href="style.css">
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch('list.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('table-container').innerHTML = data;
            });
    });
    </script>
</head>
<body>
    <div class="table-page">
        <div id="table-container"></div>
        <a href="form.html">Add another person</a>
    </div>
</body>
</html>

```
