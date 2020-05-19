<?php
include_once 'config.php';
$activeHref = 'user_messages.php';
$activePageIcon = '<i class="fas fa-comments"></i>';

$userID = filter_input(INPUT_GET, "userID");
$userMessagesArray = getAllMessagesByUserId($userID);
$authorName = getUserNameById($userID);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?= $authorName ?>'s messages</title>
        
    </head>

    <body class="d-flex flex-column">
        <div class="page-content">

            <div class="container">
                <div class='row justify-content-center'>
                    <h3>All of <i><?= $authorName ?></i>'s messages</h3>
                </div>
            </div>

            <?php include './fragments/menu.php'; ?>

            <div class="container">
                <div class='row justify-content-center'>
                    <h3><?= count($userMessagesArray) == 0 ?"It looks that <i>$authorName</i> has not yet written anything <a href='#' onclick='history.back()'>back</a>":"" ?></h3>
                </div>
            </div>
            
            <div class="container">
                <?php
                foreach ($userMessagesArray as $row) {
                    $messageID = $row['messageID'];
                    $authorID = $row['authorID'];
                    $authorName = getUserNameById($row["authorID"]);
                    $date = $row["date"];
                    $message = nl2br(htmlspecialchars($row["message"]));
                    ?>
                    <div class='row justify-content-center my-2'>
                        <div class="card" style="width: 36rem;">
                            <div class="card-body">
                                <h5 class="card-title"><a href='user_messages.php?userID=<?= $authorID ?>'><?= $authorName ?></a>
                                    <small class="card-subtitle text-muted">at <?= $date ?></small>
                                </h5>
                                <p class="card-text"><a class="show-link" href='message_show.php?messageID=<?= $messageID ?>' title="preview" data-toggle="popover" data-trigger="hover" data-content="<?= $message ?>"><?= ellipsis($message) ?></a></p>
                                <?php if ((isOwnerOfMessage($messageID)) || $isAdmin): ?>
                                <a href='message_delete.php?messageID=<?= $messageID ?>' onclick="return confirmation()" class="card-link">delete</a>
                                <?php endif; ?>
                                <?php if ((isOwnerOfMessage($messageID)) || $isAdmin): ?>
                                    <a href='message_edit.php?messageID=<?= $messageID ?>' class="card-link">edit</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>

        
    </body>
</html>
