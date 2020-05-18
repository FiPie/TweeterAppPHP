<?php
include_once 'config.php';
if (!isLogged() || !isAdmin()) {
    header('Location: index.php');
    exit();
}

$activeHref = 'admin_dashboard.php';
$activePageIcon = '<i class="fas fa-users-cog"></i>';

$userID = getUserID();
$adminName = getUserNameById($userID);
$userList = getAllUsers();

// Message displayed to a user upon error
$feedback = "";
if (isset($_SESSION['message'])) {
    $feedback = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin Dashboard</title>
        <script src="js/script.js"></script>
    </head>
    <body class="d-flex flex-column">
        <div class="page-content">

            <div class="container">
                <div class='row justify-content-center'>
                    <h3>Admin <i><?= $adminName ?></i>'s dashboard</h3>
                </div>
            </div>
            <div class="container">
                <div class='row justify-content-center'>
                    <h3><?=$feedback?></h3>
                </div>
            </div>

            <?php include './fragments/menu.php'; ?>

            <div class="container">
                <div class='row justify-content-center mt-5'>

                    <div class="card text-center" style="width: 36rem;">
                        <div class="card-header">
                            <?= $adminName ?>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Actions</h5>
                            <p class="card-text">Here you can edit or delete yours and other's accounts</p>
                        </div>
                        <div class="card-footer text-muted">
                            <a href='user_delete.php' onclick="return userDeleteConfirmation('<?= $adminName ?>')" class="card-link">delete</a>
                            <a href='user_edit.php' class="card-link">edit</a>
                        </div>
                    </div>

                </div>
                <?php
                foreach ($userList as $row) {
                    $userID = $row['userID'];
                    $userName = $row['userName'];
                    $isAdmin = $row['isAdmin'];
                    ?>
                    <div class='row justify-content-center my-2'>
                        <div class="card" style="width: 36rem;">
                            <div class="card-body">
                                <h5 class="card-title"><?= $userName ?> 
                                    <small class="card-subtitle text-muted"> ( has<?= $isAdmin == 1 ? " got " : "n't got "; ?>Admin privileges )</small>
                                </h5>
                                <p class="card-text"> ... </p>
                                
                                <a href='user_messages.php?userID=<?= $userID ?>' class="card-link">messages</a>
                                <a href='admin_edit.php?userID=<?= $userID ?>' class="card-link">edit</a>

                                <form action="user_delete.php" method="POST" style="display: inline" onsubmit="return userDeleteConfirmation('<?= $userName ?>')">
                                    <input type="hidden" name="userID" value="<?= $userID ?>">
                                    <button class="btn btn-link card-link ml-1" style="margin-bottom: 5px" type="submit">delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </body>
</html>
