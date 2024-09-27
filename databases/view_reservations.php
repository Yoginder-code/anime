<?php
// Database connection
$servername = "localhost";
$username = "root"; // default username for XAMPP
$password = ""; // default password for XAMPP is empty
$dbname = "anime_cafe"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the 'reservations' table
$sql = "SELECT first_name, surname, email, mobile, dob, time, no_of_people, message FROM reservations";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reservations</title>
    <style>
        body {
            background-color: #000000; /* Black background */
            color: #ffffff; /* White text */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #FFD700; /* Gold text */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #333; /* Dark grey table background */
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd; /* Light grey borders */
        }
        th {
            background-color: #444; /* Darker grey for header */
            color: #FFD700; /* Gold text for header */
        }
        tr:hover {
            background-color: #555; /* Light grey on hover */
        }
    </style>
</head>
<body>

<h1>Reservations List</h1>

<?php
if ($result->num_rows > 0) {
    // Display data in an HTML table
    echo "<table>";
    echo "<tr><th>First Name</th><th>Surname</th><th>Email</th><th>Mobile</th><th>Date of Birth</th><th>Time</th><th>Number of People</th><th>Message</th></tr>";

    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['first_name']) . "</td>
                <td>" . htmlspecialchars($row['surname']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>" . htmlspecialchars($row['mobile']) . "</td>
                <td>" . htmlspecialchars($row['dob']) . "</td>
                <td>" . htmlspecialchars($row['time']) . "</td>
                <td>" . htmlspecialchars($row['no_of_people']) . "</td>
                <td>" . htmlspecialchars($row['message']) . "</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No reservations found.</p>";
}

// Close connection
$conn->close();
?>

</body>
</html>
