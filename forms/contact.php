<?php
error_reporting(E_ALL);
ini_set('display_errors', 1); // Show all errors for debugging

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check required fields
    if (
        isset($_POST["name"]) &&
        isset($_POST["email"]) &&
        isset($_POST["subject"]) &&
        isset($_POST["message"])
    ) {
        $name = strip_tags(trim($_POST["name"]));
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $subject = trim($_POST["subject"]);
        $message = trim($_POST["message"]);

        $to = "amnanadeem6589@gmail.com";

        $email_subject = "New message from contact form: $subject";
        $email_body = "You have received a new message.\n\n" .
                      "Name: $name\n" .
                      "Email: $email\n\n" .
                      "Message:\n$message\n";

        $headers = "From: $name <$email>";

        if (mail($to, $email_subject, $email_body, $headers)) {
            http_response_code(200);
            echo json_encode(["message" => "Your message has been sent. Thank you!"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Mail function failed. Check your server mail configuration."]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Missing form fields."]);
    }
} else {
    http_response_code(403);
    echo json_encode(["message" => "Invalid request method."]);
}
?>
