<?php
include_once 'config.php';
if (!isLogged()) {
    header('Location: index.php');
    exit();
}

$activeHref = 'user_dashboard.php';
$activePageIcon = '<i class="fas fa-user-circle"></i>';

$userID = getUserID();
$userName = getUserNameById($userID);
$userPosts = getAllMessagesByUserId($userID);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>User Dashboard</title>
        
    </head>
    <body class="d-flex flex-column">
        <div class="page-content">

            <div class="container">
                <div class='row justify-content-center'>
                    <h3>User <i><?= $userName ?></i>'s dashboard</h3>
                </div>
            </div>

            <?php include './fragments/menu.php'; ?>

            <div class="container">
                <div class='row justify-content-center mt-5'>

                    <div class="card text-center" style="width: 36rem;">
                        <div class="card-header">
                            <?= $userName ?>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Actions</h5>
                            <p class="card-text">Here you can edit or delete your user account</p>
                        </div>
                        <div class="card-footer text-muted">
                            <a href='user_delete.php' onclick="return confirmation()" class="card-link">delete</a>
                            <a href='user_edit.php' class="card-link">edit</a>
                        </div>
                    </div>

                </div>
                <?php
                foreach ($userPosts as $row) {
                    $messageID = $row['messageID'];
                    $authorID = $row['authorID'];
                    $authorName = getUserNameById($row["authorID"]);
                    $date = $row["date"];
                    $message = $row["message"];
                    ?>
                    <div class='row justify-content-center my-2'>
                        <div class="card" style="width: 36rem;">
                            <div class="card-body">
                                <h5 class="card-title"><a href='user_messages.php?userID=<?= $authorID ?>'><?= $authorName ?></a>
                                    <small class="card-subtitle text-muted">at <?= $date ?></small>
                                </h5>
                                <p class="card-text"><a class="show-link" href='message_show.php?messageID=<?= $messageID ?>' title="Tip" data-toggle="popover" data-trigger="hover" data-content="Click to see the whole message"><?= $message ?></a></p>
                                <a href='message_delete.php?messageID=<?= $messageID ?>' onclick="return confirmation()" class="card-link">delete</a>
                                <a href='message_edit.php?messageID=<?= $messageID ?>' class="card-link">edit</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </body>
</html>
