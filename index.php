<?php
include_once 'config.php';
$activeHref = 'index.php';
$activePageIcon = '<i class="fas fa-home"></i>';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Index</title>
        
    </head>

    <body class="d-flex flex-column">
        <div class="page-content">

            <div class="container">
                <div class='row justify-content-center'>
                    <h3>Newest messages</h3>
                </div>
            </div>

            <?php include './fragments/menu.php'; ?>

            <div class="container">
                <div class='row justify-content-center mt-3'>

                    <ul class="pagination pagination-sm">
                        <li class="page-item">
                            <form method="POST" action="index.php">
                                <input type="hidden" name="page" value="<?= $current_page - 1 ?>">
                                <input type="hidden" name="search" value="<?= $search ?>">
                                <button class="page-link" type="submit"><i class="fas fa-step-backward"></i></button>
                            </form>
                        </li>
                        <li class="page-item disabled">
                            <a class="page-link" href="#" ><?= $current_page + 1 ?></a>
                        </li>
                        <li class="page-item">
                            <form method="POST" action="index.php">
                                <input type="hidden" name="page" value="<?= $current_page + 1 ?>">
                                <input type="hidden" name="search" value="<?= $search ?>">
                                <button class="page-link" type="submit"><i class="fas fa-step-forward"></i></button>
                            </form>
                        </li>
                    </ul>

                </div>

                <?php
                foreach ($resultsArray as $row) {
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
                                <p class="card-text"><a class="show-link" href='show.php?messageID=<?= $messageID ?>' ><?= $message ?></a></p>
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

        <script src="js/script.js"></script>
    </body>
</html>
