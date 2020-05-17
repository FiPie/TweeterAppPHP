<?php

include_once 'config.php';

if (isLogged()) {
    header('Location: index.php');
    exit();
}

$activeHref = 'login.php';
$activePageIcon = '<i class="fas fa-sign-in-alt"></i>';

$username = $_POST["username"];
$password = $_POST["password"];

$con = connectDatabase();
$username = mysqli_real_escape_string($con, $username);
$query = "SELECT * FROM users WHERE userName='$username'";

$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
mysqli_close($con);

if (!$row) {
    $logged = false;
} else {
    $hash = $row["password"];
    if ($hash == crypt($password, $hash)) {
        $logged = true;
    } else {
        $logged = false;
    }
}

if ($logged) {
    $_SESSION["userID"] = $row["userID"];
    $_SESSION["userName"] = $row["userName"];
    $_SESSION["isAdmin"] = $row["isAdmin"];
}

?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body class="d-flex flex-column">
        <div class="page-content">

            <div class="container">
                <div class='row justify-content-center'>
                    <h3>Login result</h3>
                </div>
            </div>


            <?php include './fragments/menu.php'; ?>

            <div class="container">
                <div class='row justify-content-center mt-3'>
                    <h3><?php
                        if ($logged) {
                            echo "You have successfully logged in as <i>".$_SESSION["userName"]."</i>";
                        } else {
                            echo "Failed to log in as <i>$username</i><br><small><a href='login.php'>Back</a></small>";
                        }
                        ?> </h3>
                </div>
            </div
        </div>

    </body>
</html>
