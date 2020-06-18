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
                    <h3><?= count($userMessagesArray) == 0 ? "It looks that <i>$authorName</i> has not yet written anything <a href='#' onclick='history.back()'>back</a>" : "" ?></h3>
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
                    $source = null;
                    if ( glob("./images/img$messageID.*") != null ){
                        $list = glob("./images/img$messageID.*");
                        $source = $list[0];
                    }
                    ?>
                    <div class='row justify-content-center my-2'>
                        <div class="card" style="width: 36rem;">
                            <div class="card-body pb-0 mb-0">
                                <h5 class="card-title"><a href='user_messages.php?userID=<?= $authorID ?>'><?= $authorName ?></a>
                                    <small class="card-subtitle text-muted"> on <?= $date ?></small>
                                </h5>
                            </div>    
                            <?php if ($source) : ?>
<!--                                <img class="card-img-top" src="<?= $source ?>" alt="Card image cap">-->
                                <img class="card-img-top" src="serveImage.php?id=<?= $messageID ?>" alt="served image cap">
                            <?php endif; ?>

                            <div class="card-body pt-0 mt-0"> 
                                <p class="card-text pt-2 mt-2"><a class="show-link" href='message_show.php?messageID=<?= $messageID ?>' title="preview" data-toggle="popover" data-trigger="hover" data-content="<?= $message ?>"><?= ellipsis($message) ?></a></p>
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
