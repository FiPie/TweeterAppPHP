<?php
include_once 'config.php';
if (!isLogged()) {
    header('Location: index.php');
    exit();
}

$activeHref = 'message_add.php';
$activePageIcon = '<i class="far fa-comments"></i>';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>add message</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body class="d-flex flex-column">
        <div class="page-content">

            <div class="container">
                <div class='row justify-content-center'>
                    <h3><i><?= $_SESSION['userName'] ?></i>'s message panel</h3>
                </div>
            </div>

            <?php include './fragments/menu.php'; ?>

            <div class="container">
                <div class='row justify-content-center mt-3'>
                    <form action="message_save.php" method="POST">
                        <input type="hidden" name="authorID" value="<?= getUserID(); ?>">
                        <div class="form-group">
                            <label for="inputMessage">Type in your message below</label>
                            <textarea name="message" rows="10" cols="80" required class="form-control rounded-0" id="inputMessage" placeholder="What's on your mind? Tell the world now!"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Post</button>
                    </form>
                </div>
            </div>


        </div>

    </body>
</html>
