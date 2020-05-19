<?php
include_once 'config.php';
if (!isLogged()) {
    header('Location: index.php');
    exit();
}

$activeHref = 'user_edit.php';
$activePageIcon = '<i class="fas fa-user-edit"></i>';

if (isAdmin() && (isset($_POST["userID"]) || isset($_SESSION["adminData_UserId"]))) {
    if (isset($_POST["userID"])) {
        $userID = filter_input(INPUT_POST, "userID");
    } else if (isset($_SESSION["adminData_UserId"])) {
        $userID = $_SESSION["adminData_UserId"];
        unset($_SESSION["adminData_UserId"]);
    }
} else {
    $userID = getUserID();
}

$userData = getUserByUserId($userID);
$userName = $userData['userName'];

// Message displayed to a user upon error
$feedback = "";
$type = "";
if (isset($_SESSION['message'])) {
    $feedback = $_SESSION['message'];
    $type = $_SESSION['message_type'];
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>User Edit</title>
        
    </head>

    <body class="d-flex flex-column">
        <div class="page-content">

            <div class="container">
                <div class='row justify-content-center'>
                    <h3>Edit <i><?= $userName ?></i></h3>
                </div>
            </div>
            <div class="container">
                <div class='row justify-content-center <?= $type ?>'>
                    <h3><?= $feedback ?></h3>
                </div>
            </div>

            <?php include './fragments/menu.php'; ?>

            <div class="container">
                <div class='row justify-content-center my-2'>

                    <form action="user_register.php" onsubmit="return passwordOK(this)" method="POST" >
                        <input type="hidden" name="userID" value="<?= $userID ?>">

                        <div class="form-group">
                            <label for="inputUserName">User Name</label>
                            <input type="text" name="userName" value="<?= $userName ?>" required class="form-control"$_SESSION[' id="inputUserName" aria-describedby="userHelp">
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
                        <a href="#" onclick="history.back()"><button type="button" class="btn btn-secondary">Back</button></a>
                    
                    </form>

                </div>
            </div>
        </div>
    </body>
</html>