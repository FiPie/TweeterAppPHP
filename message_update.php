<?php
include_once 'config.php';

$authorID = filter_input(INPUT_POST, "authorID");
$message = filter_input(INPUT_POST, "message");
$messageID = filter_input(INPUT_POST, "messageID");

$con = connectDatabase();

$messageID = mysqli_real_escape_string($con, $messageID);
$author = mysqli_real_escape_string($con, $author);
$message = mysqli_real_escape_string($con, $message);

$query = "UPDATE messages SET authorID='$authorID', message='$message' WHERE messageID='$messageID'";
mysqli_query($con, $query);

mysqli_close($con);

header('Location: index.php');