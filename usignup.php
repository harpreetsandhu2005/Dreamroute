<?php
include "db_connect.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

mysqli_report(MYSQLI_REPORT_OFF); // stop fatal error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $fullname = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (strlen($fullname) < 3 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6 || !preg_match('/[A-Z]/', $password) || !preg_match('/^[A-Za-z ]+$/', $fullname)) {
        header("Location: ../register.html");
        exit();
    }

    // Check existing user
    $check = mysqli_query($conn, "SELECT * FROM usersdata WHERE Email='$email'");

    if (mysqli_num_rows($check) > 0) {
        header("Location: ../alreadyexist.html");
        exit();
    }

    // Hash password 
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert data WITHOUT hashing
    $sql = "INSERT INTO usersdata (username, email, password)
            VALUES ('$fullname', '$email', '$hashed_password')";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../login.html");
        exit();
    } else {
        header("Location: ../alreadyexist.html");
        exit();
    }

    mysqli_close($conn);
} else {
    echo "No form submitted!";
}