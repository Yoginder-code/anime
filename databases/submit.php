<?php
// Database connection
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "anime_cafe"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO reservations (first_name, surname, email, mobile, dob, time, no_of_people, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssiss", $first_name, $surname, $email, $mobile, $dob, $time, $no_of_people, $message);

// Set parameters and execute
$first_name = $_POST['first_name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$dob = $_POST['dob'];
$time = $_POST['time'];
$no_of_people = $_POST['no_of_people'];
$message = $_POST['message'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Status</title>
    <style>
        body {
            background-color: #000000; /* Black background */
            color: #ffffff; /* White text */
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            text-align: center;
            background-color: #333; /* Dark grey container */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(255, 255, 255, 0.2); /* Light shadow */
        }
        h1 {
            color: #00FF00; /* Bright green for success */
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        p {
            font-size: 1.2em;
        }
        .back-link {
            margin-top: 20px;
            text-decoration: none;
            font-size: 1.1em;
            color: #FFD700; /* Golden color */
        }
        .back-link:hover {
            color: #FFA500; /* Orange color on hover */
        }
    </style>
</head>
<body>

<div class="container">
    <?php
    if ($stmt->execute()) {
        // Email sending functionality
        $to = $email;
        $subject = "Reservation Confirmation";
        $body = "Hello $first_name,\n\n"
              . "Thank you for your reservation at Anime Cafe!\n"
              . "Here are your reservation details:\n"
              . "Name: $first_name $surname\n"
              . "Email: $email\n"
              . "Mobile: $mobile\n"
              . "Date of Birth: $dob\n"
              . "Time: $time\n"
              . "Number of People: $no_of_people\n"
              . "Message: $message\n\n"
              . "We look forward to seeing you!\n\n"
              . "Best Regards,\nAnime Cafe Team";
        $headers = "From: no-reply@animecafe.com"; // Replace with your email address

        // Send email
        if (mail($to, $subject, $body, $headers)) {
            echo "<h1>Success!</h1>";
            echo "<p>Your reservation has been successfully submitted. A confirmation email has been sent to you.</p>";
        } else {
            echo "<h1>Success!</h1>";
            echo "<p>Your reservation has been successfully submitted, but we could not send a confirmation email.</p>";
        }
    } else {
        echo "<h1>Error</h1>";
        echo "<p>Something went wrong: " . $stmt->error . "</p>";
    }
    ?>
    <a href="index.html" class="back-link">Go back to the homepage</a>
</div>

</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
