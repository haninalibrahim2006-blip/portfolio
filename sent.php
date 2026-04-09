<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Message Sent</title>
        <link rel='stylesheet' href='css/style.css'>
    </head>
    <body>
        <section class='page-section'>
            <div class='card'>
                <h1>Thank you!</h1>
                <p>Your message has been sent.</p>
                <p><strong>Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Message:</strong> $message</p>
                <a href='contact.php' class='btn'>Back to Contact</a>
            </div>
        </section>
    </body>
    </html>";
}
?>