<?php
include_once 'config.php';

$userName = filter_input(INPUT_POST, "userName");

$password = filter_input(INPUT_POST, "password");
$repassword = filter_input(INPUT_POST, "repassword");


if ((!isset($_POST['password']) && (!isset($_POST['repassword']))) && isAdmin()) {
    $passwordsMismatch = FALSE;
} else {
    $passwordsMismatch = ($password != $repassword) ? TRUE : FALSE;
}

$salt_temp = str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ");
$salt = '$2a$10$' . substr($salt_temp, 0, 22);

$encrypted_pass = crypt($password, $salt);

$con = connectDatabase();
$userName = mysqli_real_escape_string($con, $userName);


if ((userExists($userName) && !isUserNameOwner($userName)) && (!isAdmin() )) {
    mysqli_close($con);
    if (isAdmin() && isUserNameOwner($userName)) {
        $_SESSION['message'] = "The user name: <i>$userName</i> is already in use. Try another name.";
        $_SESSION['message_type'] = "text-danger";
        $userID = filter_input(INPUT_POST, "userID");
        $_SESSION['adminData_UserId'] = "$userID";
        header('Location: user_edit.php');
        exit();
    } elseif (!isAdmin() && isUserNameOwner($userName)) {
        $message1 = "Sorry but the user name <i>$userName</i> is already taken!";
        $message2 = "Try again with another user name." . '<a href="register.php"> Sign up</a>';
    }
} else {
    if (isset($_POST['userID'])) {
        if ($passwordsMismatch) {
            $_SESSION['message'] = "The passwords you provided do not seem to match one another. Try again.";
            $_SESSION['message_type'] = "text-danger";
            header('Location: user_edit.php');
        } else {
            $userID = filter_input(INPUT_POST, "userID");
            $oldName = $_SESSION['userName'];
            $query1 = "UPDATE users SET userName= '$userName', password= '$encrypted_pass' WHERE userID= '$userID'";
            mysqli_query($con, $query1);
            $query2 = "UPDATE messages SET authorID= '$userName' WHERE messages.authorID= '$oldName'";
            mysqli_query($con, $query2);
            $_SESSION['redirect'] = TRUE;

            if (isset($_POST['admin'])) {
                $isAdmin = (filter_input(INPUT_POST, "admin") == 'on' ? 1 : 0);
//                var_dump($isAdmin);
//                exit();
                $query3 = "UPDATE users SET isAdmin= '$isAdmin' WHERE userID= '$userID'";
                mysqli_query($con, $query3);
                mysqli_close($con);
                header('Location: admin_dashboard.php');
            }
            if(isAdmin()){
                mysqli_close($con);
                header('Location: admin_dashboard.php');
            }
            mysqli_close($con);
            header('Location: logout.php');
        }
    } else {
        if ($passwordsMismatch) {
            mysqli_close($con);
            $message1 = "The passwords you provided do not seem to match one another.";
            $message2 = "Try again." . '<a href="register.php"> Sign up</a>';
        } else {
            $query = "INSERT INTO users (userName, password) VALUES ('$userName','$encrypted_pass')";
            mysqli_query($con, $query);
            $message1 = "Success!";
            $message2 = "Hello <i>$userName</i> welcome in our community";
            mysqli_close($con);
        }
    }
}

$activeHref = 'register.php';
$activePageIcon = '<i class="fas fa-user-plus"></i>';
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Register Feedback</title>
    </head>
    <body class="d-flex flex-column">
        <div class="page-content">

            <div class="container">
                <div class='row justify-content-center'>
                    <h3><?= $message1 ?></h3>
                </div>
            </div>

            <?php include './fragments/menu.php'; ?>

            <div class="container">
                <div class='row justify-content-center mt-3'>
                    <h3><?= $message2 ?> </h3>
                </div>
            </div

        </div>
    </body>
</html>
