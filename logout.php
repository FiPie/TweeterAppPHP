<?php
session_start();

unset($_SESSION['userID']);
unset($_SESSION['userName']);
unset($_SESSION['isAdmin']);

if (isset($_SESSION['redirect']) && $_SESSION['redirect'] == TRUE) {
    unset($_SESSION['redirect']);
    $_SESSION['message'] = "Your account was successfully updated. Please log in with your new credentials";
    header('Location: login.php');
    exit();
}
header('Location: index.php');
