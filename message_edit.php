<?php
include_once 'config.php';

$messageID = filter_input(INPUT_GET, "messageID");

if (!isLogged()) {
    header("Location: message_show.php?messageID=$messageID");
    exit();
}

$con = connectDatabase();
$messageID = mysqli_real_escape_string($con, $messageID);

$activeHref = "message_edit.php?messageID=$messageID";
$activePageIcon = '<i class="far fa-comment-dots"></i>';

$query = "SELECT * FROM messages WHERE messageID='$messageID'";
$res = mysqli_query($con, $query);
$row = mysqli_fetch_array($res);

$userIsOwner = isOwnerOfMessage($messageID);
$isAdmin = isAdmin();

if (!$userIsOwner && !$isAdmin) {
    header("Location: message_show.php?id=$messageID");
    exit();
}

$author = getUserNameById($row['authorID']);
$authorID = getAuthorIDByMessageID($messageID);
$message = $row['message'];
$source = null;
if (glob("./images/img$messageID.*") != null) {
    $list = glob("./images/img$messageID.*");
    $source = $list[0];
}

mysqli_close($con);
?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <title>edit message</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="d-flex flex-column">
    <div class="page-content">

        <div class="container">
            <div class='row justify-content-center'>
                <h3>Edit <i><?= $author ?></i>'s message</h3>
            </div>
        </div>

        <?php include './fragments/menu.php'; ?>

        <div class="container">
            <div class='row justify-content-center my-3'>
                <div class="col-3"></div>
                <div class="col-6">
                    <form action="message_update.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="messageID" value="<?= $messageID ?>">
                        <input type="hidden" name="authorID" value="<?= $authorID ?>"">

                        <?php if ($source) : ?>
<!--                            <img class="card-img pt-2 mt-2" src="<?= $source ?>" alt="Card image cap">-->
                            <input type="hidden" name="oldfile" value="<?= $source ?>">
                            <img class="card-img-top" src="serveImage.php?id=<?= $messageID ?>" alt="served image cap">
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="inputMessage">Edit your message below</label>
                            <textarea name="message" rows="10" cols="80" required class="form-control rounded-0" id="inputMessage" placeholder="What's on your mind? Tell the world now!"><?= $message ?></textarea>
                        </div>

                        <input type="hidden" name="MAX_FILE_SIZE" value="10000000">
                        <input type="file" name="image" accept="image/*">

                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="#" onclick="history.back()"><button type="button" class="btn btn-secondary">Back</button></a>
                    </form>
                </div>    
                <div class="col-3"></div>
            </div>
        </div>

    </div>

</body>
</html>