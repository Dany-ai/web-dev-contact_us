<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $recipient = "youremail@example.com"; // <-- CHANGE THIS
    $visitor_name = filter_input(INPUT_POST, "visitor_name", FILTER_SANITIZE_STRING);
    $visitor_email = filter_input(INPUT_POST, "visitor_email", FILTER_SANITIZE_EMAIL);
    $visitor_number = filter_input(INPUT_POST, "visitor_number", FILTER_SANITIZE_NUMBER_INT);
    $visitor_address = filter_input(INPUT_POST, "visitor_address", FILTER_SANITIZE_STRING);
    $visitor_message = htmlspecialchars($_POST["visitor_message"]);

    if (!$visitor_email || !filter_var($visitor_email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    $subject = "New Contact Form Submission";
    $email_body = "
        <h2>Contact Form Submission</h2>
        <p><strong>Name:</strong> {$visitor_name}</p>
        <p><strong>Email:</strong> {$visitor_email}</p>
        <p><strong>Phone:</strong> {$visitor_number}</p>
        <p><strong>Address:</strong> {$visitor_address}</p>
        <p><strong>Message:</strong><br>" . nl2br($visitor_message) . "</p>
    ";

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
    $headers .= "From: {$visitor_name} <{$visitor_email}>\r\n";

    if (mail($recipient, $subject, $email_body, $headers)) {
        echo "<p>Thank you for contacting us, {$visitor_name}. You’ll receive a reply within 24 hours.</p>";
    } else {
        echo "<p>Sorry, something went wrong. Please try again later.</p>";
    }
} else {
    echo "Invalid request.";
}
?>