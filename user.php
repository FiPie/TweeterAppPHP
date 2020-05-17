<?php
include_once 'config.php';
if (!isLogged()) {
    header('Location: index.php');
    exit();
}

$activeHref = 'user.php';
$activePageIcon = '<i class="fas fa-user-circle"></i>';
$con = connectDatabase();
$authorID = getUserID();

$query = "SELECT * FROM `messages` WHERE `authorID`='$authorID' ORDER BY `date` DESC";
$res = mysqli_query($con, $query);
$userPosts = mysqli_fetch_all($res, MYSQLI_ASSOC);
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
                    <h3>User <i><?= $_SESSION['userName'] ?></i>'s dashboard</h3>
                </div>
            </div>

            <?php include './fragments/menu.php'; ?>

            <div class="container">
                <div class='row justify-content-center mt-5'>

                    <div class="card text-center" style="width: 36rem;">
                        <div class="card-header">
                            <?= $_SESSION['userName'] ?>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Actions</h5>
                            <p class="card-text">Here you can edit or delete your user account</p>
                        </div>
                        <div class="card-footer text-muted">
                            <a href='deleteUser.php' onclick="return confirmation()" class="card-link">delete</a>
                            <a href='editUser.php' class="card-link">edit</a>
                        </div>
                    </div>

                </div>
                <?php
                foreach ($userPosts as $row) {
                    $messageID = $row['messageID'];
                    $authorName = getUserNameById($row["authorID"]);
                    $date = $row["date"];
                    $message = $row["message"];
                    ?>
                    <div class='row justify-content-center my-2'>
                        <div class="card" style="width: 36rem;">
                            <div class="card-body">
                                <h5 class="card-title"><a href='show.php?messageID=<?= $messageID ?>'><?= $authorName ?></a>
                                    <small class="card-subtitle text-muted">at <?= $date ?></small></h5>

                                <p class="card-text"><?= $message ?></p>
                                <a href='delete.php?messageID=<?= $messageID ?>' onclick="return confirmation()" class="card-link">delete</a>
                                <a href='edit.php?messageID=<?= $messageID ?>' class="card-link">edit</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </body>
</html>
