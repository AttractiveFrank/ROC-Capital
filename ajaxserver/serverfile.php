<?php
// Set the header response to JSON
header('Content-type: application/json');

// Enable error reporting for debugging (remove or comment out in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$response = array();

/*
 * Handle Message Form
 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_message'])) {
    $email = trim($_POST['email']);
    $name = trim($_POST['name']);
    $message = trim($_POST['message']);
    
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $name = htmlentities($name);
    $message = htmlentities($message);

    // Validate data first
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 50) {
        http_response_code(403);
        $response['error']['email'] = "A valid email is required";
    }
    if (empty($name)) {
        http_response_code(403);
        $response['error']['name'] = 'Name is required ';
    }
    if (empty($message)) {
        http_response_code(403);
        $response['error']['message'] = 'Empty message is not allowed';
    }

    // Process to emailing if forms are correct
    if (!isset($response['error']) || $response['error'] === '') {
        // Email recipient
        $to = "ronan@ronanocoigligh.com"; // Replace with your email address
        
        // Email subject
        $subject = "New message from your website";
        
        // Email content
        $body = "Name: " . $name . "\r\nEmail: " . $email . "\r\nMessage: " . $message;
        
        // Email headers
        $headers = "From: " . $email;

        // Send email
        if (mail($to, $subject, $body, $headers)) {
            // Set a 200 (OK) response code.
            http_response_code(200);
            $response['success'] = 'Thank You! Your message has been sent';

            // Write message into a file as a backup
            file_put_contents("message.txt", $body . "\r\n---------\r\n", FILE_APPEND | LOCK_EX);
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            $response['error'] = 'There was an error sending your message. Please try again later.';
        }
    }

    echo json_encode($response);
    exit;
}

// Handle email subscription form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_email'])) {
    $email = filter_var(@$_POST['email'], FILTER_SANITIZE_EMAIL);

    // Form validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 50) {
        $response['error']['email'] = "A valid email is required";
    }

    if (!isset($response['error']) || $response['error'] === '') {
        // Example: storing emails in a text file
        $email = str_replace(array('<','>'),array('&lt;','&gt;'),$email);

        // Set a 200 (OK) response code.
        http_response_code(200);
        $response['success'] = "Thank You! You will be notified.";

        // Save email list to a file as a backup
        file_put_contents("email.txt", $email . " \r\n", FILE_APPEND | LOCK_EX);
    }

    echo json_encode($response);
    exit;
}

// If neither form is submitted, return an error
http_response_code(400);
$response['error'] = "Invalid request";
echo json_encode($response);
exit;
?>
