<!DOCTYPE html>
<html>
<head>
    <title>Oracle Data Manager</title>
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $dbHost = $_POST["dbHost"];
        $dbPort = $_POST["dbPort"];
        $dbName = $_POST["dbName"];
        $dbSchema = $_POST["dbSchema"];
        $dbUser = $_POST["dbUser"];
        $dbPassword = $_POST["dbPassword"];

        try {
            $db = new PDO("oci:dbname=(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=$dbHost)(PORT=$dbPort))(CONNECT_DATA=(SERVICE_NAME=$dbName)));charset=UTF8", $dbUser, $dbPassword);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Fetch data from the 'demodata' table
            $query = "SELECT * FROM $dbSchema.demodata";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Display the retrieved data
            echo "<h2>Data from 'demodata' table:</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Username</th><th>Password</th><th>Active</th><th>Expiry Date</th><th>Full Name</th><th>Email</th><th>Mobile</th></tr>";
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>" . $row['USERNAME'] . "</td>";
                echo "<td>" . $row['PASSWORD'] . "</td>";
                echo "<td>" . $row['ACTIVE'] . "</td>";
                echo "<td>" . $row['EXPIRYDATE'] . "</td>";
                echo "<td>" . $row['FULLNAME'] . "</td>";
                echo "<td>" . $row['EMAIL'] . "</td>";
                echo "<td>" . $row['MOBILE'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";

            // Close the database connection
            $db = null;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    ?>
</body>
</html>
