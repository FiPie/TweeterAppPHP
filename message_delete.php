<?php
include_once 'config.php';

$messageID = filter_input(INPUT_GET, "messageID");

if (!isLogged() || !isOwnerOfMessage($messageID) || !isAdmin()) {
    header("Location: show.php?messageID=$messageID");
    exit();
}

$con = connectDatabase();
$messageID = mysqli_real_escape_string($con, $messageID);
$query = "DELETE FROM `messages` WHERE messageID='$messageID'";
mysqli_query($con, $query);
mysqli_close($con);
header('Location: index.php');
exit();
