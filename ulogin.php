<?php
session_start();
include "db_connect.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
        header("Location: ../login.html");
        exit();
    }

    // Check user in database
    $sql = "SELECT * FROM usersdata WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {

        $user = mysqli_fetch_assoc($result);

        // Verify password
        if (password_verify($password, $user['password'])) {

            // Create session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];

            // Redirect after login
            header("Location: ../book-now.html");
            exit();

        } else {
            $_SESSION['login_error'] = "Wrong password!";
            header("Location: ../login_error.html");
            exit();
        }

    } else {
        $_SESSION['login_error'] = "User not found!";
        header("Location: ../login.html");
        exit();
    }

    mysqli_close($conn);

} else {
    header("Location: ../login.html");
    exit();
}
?>