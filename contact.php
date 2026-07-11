<?php
include "db_connect.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (strlen($name) < 2 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($subject) < 3 || strlen($message) < 10) {
        header("Location: ../contact-us.html");
        exit();
    }

    // Prepared statement (secure)
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    if ($stmt->execute()) {
        header("Location: ../success1.html");
        exit();
    } else {
        header("Location: ../error.html");
        exit();
    }

    $stmt->close();
    $conn->close();

} else {
    echo "No form submitted!";
}
?>