<?php
include_once 'config.php';

$activeHref = 'login.php';
$activePageIcon = '<i class="fas fa-sign-in-alt"></i>';

if (isLogged()) {
    header('Location: index.php');
    exit();
}
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
        <title>login</title>
    </head>
    <body class="d-flex flex-column">
        <div class="page-content">

            <div class="container">
                <div class='row justify-content-center'>
                    <h3>Login</h3>
                </div>
            </div>
            
            <div class="container">
                <div class='row justify-content-center'>
                    <h3><?= $message ?></h3>
                </div>
            </div>

            <?php include './fragments/menu.php'; ?>

            <script src="js/script.js"></script>
            <div class="container">
                <div class='row justify-content-center mt-3'>

                    <form action="login_check.php" method="POST" >

                        <div class="form-group">
                            <label for="exampleInputEmail1">User Name</label>
                            <input type="text" name="username" required class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                            <small id="emailHelp" class="form-text text-muted">Please enter your user name.</small>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" name="password" required class="form-control" id="exampleInputPassword1" placeholder="Password">
                        </div>

                        <button type="submit" class="btn btn-primary">Login</button>

                    </form>

                </div>
            </div>
        </div>
    </body>
</html>
