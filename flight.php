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
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');

// FROM
$from_address = trim($_POST['address'] ?? '');
$from_city = trim($_POST['city'] ?? '');
$from_state = trim($_POST['state'] ?? '');
$from_pincode = trim($_POST['pincode'] ?? '');
$from_country = trim($_POST['country'] ?? '');

// TO
$to_address = trim($_POST['address1'] ?? '');
$to_city = trim($_POST['city1'] ?? '');
$to_state = trim($_POST['state1'] ?? '');
$to_pincode = trim($_POST['pincode1'] ?? '');
$to_country = trim($_POST['country1'] ?? '');

// Other details
$check_in = $_POST['check_in'] ?? '';
$flight_type = $_POST['flight_type'] ?? '';
$payment_method = $_POST['payment_method'] ?? '';

if (
    strlen($full_name) < 2 ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    !preg_match('/^[6-9][0-9]{9}$/', $phone) ||
    !preg_match('/^[0-9]{6}$/', $from_pincode) ||
    !preg_match('/^[0-9]{6}$/', $to_pincode) ||
    empty($check_in)
) {
    header("Location: ../flight-from.html");
    exit();
}

// Insert query
$sql = "INSERT INTO flight_booking (
    full_name, email, phone,
    from_address, from_city, from_state, from_pincode, from_country,
    to_address, to_city, to_state, to_pincode, to_country,
    check_in, flight_type, payment_method
) VALUES (
    '$full_name', '$email', '$phone',
    '$from_address', '$from_city', '$from_state', '$from_pincode', '$from_country',
    '$to_address', '$to_city', '$to_state', '$to_pincode', '$to_country',
    '$check_in', '$flight_type', '$payment_method'
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