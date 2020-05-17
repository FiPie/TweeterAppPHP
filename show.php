<?php
include_once 'config.php';

$messageID = filter_input(INPUT_GET, "messageID");
$con = connectDatabase();
$messageID = mysqli_real_escape_string($con, $messageID);

$activeHref = "show.php?messageID=$messageID";
$activePageIcon = '<i class="far fa-comment"></i>';

$query = "SELECT * FROM messages WHERE messageID='$messageID'";
$result = mysqli_query($con, $query);
//var_dump($result);
$rowMessage = mysqli_fetch_array($result);
$authorName = getUserNameById($rowMessage["authorID"]);

mysqli_close($con);
?>
<!DOCTYPE html>

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
                        <h5 class="card-title"><a href='show.php?messageID=<?= $messageID ?>'><?= $authorName ?></a>
                            <small class="card-subtitle text-muted">at <?= $rowMessage["date"] ?></small></h5>

                        <p class="card-text"><?= nl2br(htmlspecialchars($rowMessage["message"])) ?></p>
                        <?php if ((isOwnerOfMessage($messageID)) || $isAdmin): ?>
                            <a href='delete.php?messageID=<?= $messageID ?>' onclick="return confirmation()" class="card-link">delete</a>
                        <?php endif; ?>
                        <?php if ((isOwnerOfMessage($messageID)) || $isAdmin): ?>
                            <a href='edit.php?messageID=<?= $messageID ?>' class="card-link">edit</a>
                        <?php endif; ?>
                        <a href='index.php' class="card-link">back</a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
</body>
</html>
