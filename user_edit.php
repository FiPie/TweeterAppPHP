<?php
include_once 'config.php';
if (!isLogged()) {
    header('Location: index.php');
    exit();
}

$activeHref = 'user_edit.php';
$activePageIcon = '<i class="fas fa-user-edit"></i>';
$con = connectDatabase();
//$user = $_SESSION['userName'];
$userID = $_SESSION['userID'];
$query = "SELECT * FROM `users` WHERE `userID`='$userID'";
$res = mysqli_query($con, $query);
$userData = mysqli_fetch_array($res,MYSQLI_ASSOC);

$message = "";
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>user</title>
        <script src="js/script.js"></script>
    </head>
    <body class="d-flex flex-column">
        <div class="page-content">

            <div class="container">
                <div class='row justify-content-center'>
                    <h3>Edit <i><?= $_SESSION['userName'] ?></i></h3>
                </div>
            </div>
            
            
            <div class="container">
                <div class='row justify-content-center'>
                    <h3><?= $message ?></h3>
                </div>
            </div>

            <?php include './fragments/menu.php'; ?>

            <div class="container">


                <div class='row justify-content-center my-2'>

                    <form action="user_register.php" onsubmit="return passwordOK(this)" method="POST" >
                        <input type="hidden" name="userID" value="<?= $userID ?>">
                        <div class="form-group">
                            <label for="inputUserName">User Name</label>
                            <input type="text" name="userName" value="<?= $userData['userName'] ?>" required class="form-control"$_SESSION[' id="inputUserName" aria-describedby="userHelp">
                            <small id="userHelp" class="form-text text-muted">Please enter your user name.</small>
                        </div>

                        <div class="form-group">
                            <label for="password1">New Password</label>
                            <input type="password" name="password" required class="form-control" id="password1" placeholder="Enter new password">
                        </div>

                        <div class="form-group">
                            <label for="password2">Confirm password</label>
                            <input type="password" name="repassword" required class="form-control" id="password2" placeholder="Re-enter password">
                            <small id="Help" class="form-text text-muted">After update you will be required to log in again with new credentials</small>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>

                    </form>




                </div>

            </div>
        </div>
    </body>
</html>