<?php
include_once 'config.php';

$activeHref = 'register.php';
$activePageIcon = '<i class="fas fa-user-plus"></i>';

if (isLogged()) {
    header("Location: message_show.php?messageID=$messageID");
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>registration</title>
    </head>
    <body class="d-flex flex-column">
        <div class="page-content">

            <div class="container">
                <div class='row justify-content-center'>
                    <h3>Register</h3>
                </div>
            </div>


            <?php include './fragments/menu.php'; ?>

<!--            <script src="js/script.js"></script>-->
            <div class="container">
                <div class='row justify-content-center mt-3'>

                    <form action="user_register.php" onsubmit="return passwordOK(this)" method="POST" >

                        <div class="form-group">
                            <label for="inputUserName">User Name</label>
                            <input type="text" name="userName" required class="form-control" id="inputUserName" aria-describedby="userHelp" placeholder="Enter user name">
                            <small id="userHelp" class="form-text text-muted">Please enter your user name.</small>
                        </div>

                        <div class="form-group">
                            <label for="password1">Password</label>
                            <input type="password" name="password" required class="form-control" id="password1" placeholder="Enter assword">
                        </div>

                        <div class="form-group">
                            <label for="password2">Confirm password</label>
                            <input type="password" name="repassword" required class="form-control" id="password2" placeholder="Re-enter password">
                        </div>

                        <button type="submit" class="btn btn-primary">Register</button>

                    </form>

                </div>
            </div>
        </div>   
    </body>
</html>