<?php

// Database connection
$servername = "localhost";
$username = "root";       // change if needed
$password = "";           // your mysql password
$dbname = "tour_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$full_name = trim($_POST['full_name'] ?? '');
$email     = trim($_POST['email'] ?? '');
$phone     = trim($_POST['phone'] ?? '');

// Address (Pickup)
$address  = trim($_POST['address'] ?? '');
$city     = trim($_POST['city'] ?? '');
$state    = trim($_POST['state'] ?? '');
$pincode  = trim($_POST['pincode'] ?? '');
$country  = trim($_POST['country'] ?? '');

// Destination
$address1 = trim($_POST['address1'] ?? '');

// Other details
$car             = $_POST['car'] ?? '';
$check_in        = $_POST['check_in'] ?? '';
$check_out       = $_POST['check_out'] ?? '';
$payment_method  = $_POST['payment_method'] ?? '';

if (
    strlen($full_name) < 2 ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    !preg_match('/^[6-9][0-9]{9}$/', $phone) ||
    !preg_match('/^[0-9]{6}$/', $pincode) ||
    empty($check_in) || empty($check_out) ||
    strtotime($check_out) <= strtotime($check_in)
) {
    header("Location: ../taxi-form.html");
    exit();
}

// Insert query
$sql = "INSERT INTO taxi_booking (
    full_name, email, phone,
    address, city, state, pincode, country,
    address1, car, check_in, check_out, payment_method
) VALUES (
    '$full_name', '$email', '$phone',
    '$address', '$city', '$state', '$pincode', '$country',
    '$address1', '$car', '$check_in', '$check_out', '$payment_method'
)";

// Execute query
if ($conn->query($sql) === TRUE) {
        $payment = $_POST['payment_method'];
        if ($payment === 'Credit Card') header("Location: ../credit.html");
        elseif ($payment === 'Debit Card') header("Location: ../debit.html");
        elseif ($payment === 'UPI') header("Location: ../upi.html");
        else header("Location: ../success.html");
        exit();
} else {
        header("Location: ../error.html");
}

$conn->close();

?>