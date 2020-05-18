<?php

include_once 'config.php';

if (!isLogged()) {
    header('Location: index.php');
    exit();
}

if (isAdmin() && isset($_POST["userID"])) {
    $userID = filter_input(INPUT_POST, "userID");
    $userName = getUserNameById($userID);
    deleteUserAndAllUserMessagesByUserId($userID);
    $_SESSION['message'] = "User <i>$userName</i> and all of her/his messages were deleted !";
    header('Location: admin_dashboard.php');
    exit();
} else {
    $userID = $_SESSION['userID'];
    deleteUserAndAllUserMessagesByUserId($userID);
    header('Location: logout.php');
    exit();
}


