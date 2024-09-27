<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the selected food types
    $foodType = $_POST['food_type'];
    $selectedFoods = isset($_POST['food']) ? $_POST['food'] : [];

    // Display the message
    echo "<!doctype html>
    <html lang='en'>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
        <title>Order Confirmation</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH' crossorigin='anonymous'>
        <style>
            body {
                background-color: #202020;
                color: white;
            }
            .confirmation {
                background-color: rgba(29, 25, 25, 0.7);
                padding: 20px;
                border-radius: 10px;
                margin: 50px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class='confirmation'>
            <h1>Thanks for Your Order!</h1>
            <p>You have selected the following:</p>
            <p><strong>Food Type:</strong> " . htmlspecialchars($foodType) . "</p>
            <p><strong>Selected Foods:</strong> " . (empty($selectedFoods) ? 'None' : implode(', ', array_map('htmlspecialchars', $selectedFoods))) . "</p>
            <a href='index.html' class='btn btn-outline-info mt-3'>Go Back to Home</a>
        </div>
    </body>
    </html>";
} else {
    // Redirect back to the form if accessed directly
    header("Location: index.html");
    exit();
}
?>
