<?php
include_once 'config.php';

$messageID = filter_input(INPUT_GET, "messageID");
$row = getMessageByMessageId($messageID);
$messageID = $row['messageID'];
$authorID = $row['authorID'];
$authorName = getUserNameById($row["authorID"]);
$date = $row["date"];
$message = nl2br(htmlspecialchars($row["message"]));

$activeHref = "message_show.php?messageID=$messageID";
$activePageIcon = '<i class="far fa-comment"></i>';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Show</title>
    </head>
    
    <body class="d-flex flex-column">
        <div class="page-content">

            <div class="container">
                <div class='row justify-content-center'>
                    <h3><i><?= $authorName ?></i>'s message</h3>
                </div>
            </div>

            <?php include './fragments/menu.php'; ?>

            <div class="container">
                <div class='row justify-content-center my-5'>
                    <div class="card" style="width: 50rem;">
                        <div class="card-body">
                            <h5 class="card-title"><a href='user_messages.php?userID=<?= $authorID ?>'><?= $authorName ?></a>
                                <small class="card-subtitle text-muted">at <?= $date ?></small>
                            </h5>
                            <p class="card-text"><a class="show-link" href='message_show.php?messageID=<?= $messageID ?>' ><?= $message ?></a></p>
                            <?php if ((isOwnerOfMessage($messageID)) || $isAdmin): ?>
                                <a href='message_delete.php?messageID=<?= $messageID ?>' onclick="return confirmation()" class="card-link">delete</a>
                            <?php endif; ?>
                            <?php if ((isOwnerOfMessage($messageID)) || $isAdmin): ?>
                                <a href='message_edit.php?messageID=<?= $messageID ?>' class="card-link">edit</a>
                            <?php endif; ?>
                                <a href='#' onclick="history.back()" class="card-link">back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>