<?php
include "db_connect.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

mysqli_report(MYSQLI_REPORT_OFF); // stop fatal error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $full_name = trim($_POST['full_name'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $phone     = trim($_POST['phone'] ?? '');

    $address   = trim($_POST['address'] ?? '');
    $city      = trim($_POST['city'] ?? '');
    $state     = trim($_POST['state'] ?? '');
    $pincode   = trim($_POST['pincode'] ?? '');
    $country   = trim($_POST['country'] ?? '');

    $check_in  = $_POST['check_in'] ?? '';
    $check_out = $_POST['check_out'] ?? '';

    $persons   = intval($_POST['persons'] ?? 0);

    $male      = $_POST['male'] ?? '0';
    $female    = $_POST['female'] ?? '0';
    $kids      = $_POST['kids'] ?? '0';

    $room_type      = $_POST['room_type'] ?? '';
    $payment_method = $_POST['payment_method'] ?? '';
    $tour_location  = $_POST['tour_location'] ?? '';

    if (
        strlen($full_name) < 2 ||
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        !preg_match('/^[6-9][0-9]{9}$/', $phone) ||
        !preg_match('/^[0-9]{6}$/', $pincode) ||
        $persons < 1 ||
        $tour_location === 'select the place' ||
        empty($check_in) || empty($check_out) ||
        strtotime($check_out) <= strtotime($check_in)
    ) {
        header("Location: ../book form.html");
        exit();
    }

    // INSERT QUERY
    $sql = "INSERT INTO bookings 
    (full_name, email, phone, address, city, state, pincode, country, check_in, check_out, persons, male, female, kids, room_type, payment_method, tour_location) 
    VALUES 
    ('$full_name', '$email', '$phone', '$address', '$city', '$state', '$pincode', '$country', '$check_in', '$check_out', '$persons', '$male', '$female', '$kids', '$room_type', '$payment_method', '$tour_location')";

    if (mysqli_query($conn, $sql)) {
        $payment = $_POST['payment_method'];
        if ($payment === 'Credit Card') header("Location: ../credit.html");
        elseif ($payment === 'Debit Card') header("Location: ../debit.html");
        elseif ($payment === 'PayPal') header("Location: ../upi.html");
        else header("Location: ../success.html");
        exit();
    } else {
        header("Location: ../error.html");
        exit();
    }

    mysqli_close($conn);

} else {
    echo "No form submitted!";
}
?>