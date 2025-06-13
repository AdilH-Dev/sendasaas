<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['namec']));
    $phone = htmlspecialchars(trim($_POST['phonec']));
    $email = filter_var(trim($_POST['emailc']), FILTER_VALIDATE_EMAIL);
    $company = htmlspecialchars(trim($_POST['businessc']));

    if (!$email) {
        echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
        exit;
    }

    $to = "helpdesk@senda.ventures"; // your email
    $subject = "From website";

    $message = "You have received a new contact form submission:\n\n";
    $message .= "Name: $name\n";
    $message .= "Best Contact: $phone\n";
    $message .= "Email: $email\n";
    $message .= "Company: $company\n";

    $headers = "From: From website\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=utf-8\r\n";

    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(['success' => true, 'message' => "Thank you, $name. Your message has been sent."]);
    } else {
        echo json_encode(['success' => false, 'message' => "Sorry, there was a problem sending your message."]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
