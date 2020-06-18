<?php

include_once 'config.php';

$authorID = filter_input(INPUT_POST, "authorID");
$message = filter_input(INPUT_POST, "message");
$messageID = filter_input(INPUT_POST, "messageID");

$con = connectDatabase();

$messageID = mysqli_real_escape_string($con, $messageID);
$message = mysqli_real_escape_string($con, $message);

$query = "UPDATE messages SET authorID='$authorID', message='$message' WHERE messageID='$messageID'";
mysqli_query($con, $query);

mysqli_close($con);

$oldFile = filter_input(INPUT_POST, "oldfile");

//Add the image file to the images subdirectory - this directory must be writable 
if (isset($_FILES["image"]) && $_FILES["image"]["name"] != "") {
    $source = $_FILES["image"]["tmp_name"];
    $mimeType = mime_content_type($source);
    //here we should secure against unwanted mimeTypes
    $split = explode("/", $mimeType);
    $dest = "./images/img" . $messageID . "." . $split[1];

    //Here we check if there is any file connected with the message, and delete it if so
    if (hasImage($messageID)) {
        $src = getImageSrc($messageID);
        unlink($src);
    }

    $canWrite = move_uploaded_file($source, $dest);

    if (!$canWrite) {
        echo "Can not write to the images subdirectory";
        die();
    }
}

if (isAdmin()) {
    header("Location: user_messages.php?userID=$authorID");
} else {
    header('Location: index.php');
}