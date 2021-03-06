<?php

include_once 'config.php';

$messageID = filter_input(INPUT_GET, "messageID");

if (!isLogged() || !isOwnerOfMessage($messageID) || (!isAdmin() && !isOwnerOfMessage($messageID))) {
    header("Location: message_show.php?messageID=$messageID");
    exit();
}

$con = connectDatabase();
$messageID = mysqli_real_escape_string($con, $messageID);
$query = "DELETE FROM `messages` WHERE messageID='$messageID'";
mysqli_query($con, $query);
mysqli_close($con);

//Here we check if there is any file connected with the message, and delete it too if so
if (hasImage($messageID)) {
    $src = getImageSrc($messageID);
    unlink($src);
}

header('Location: index.php');
exit();
