<?php

include_once 'config.php';

$authorID = filter_input(INPUT_POST, "authorID");
$message = filter_input(INPUT_POST, "message");

$con = connectDatabase();
$authorID = mysqli_real_escape_string($con, $authorID);
$message = mysqli_real_escape_string($con, $message);



$query = "INSERT INTO messages (authorID, message) VALUES ('$authorID', '$message')";

mysqli_query($con, $query);

//We will need later the ID of this record. The following function returns 
//the auto incremented value of the last insered record
$id = mysqli_insert_id($con);

//Add the image file to the images subdirectory - this directory must be writable 
if (isset($_FILES["image"]) && $_FILES["image"]["tmp_name"] != "") {
    $source = $_FILES["image"]["tmp_name"];
    $mimeType = mime_content_type($source);
//    var_dump(strpos($mimeType, 'image'));
//    exit();
    //here we should secure against unwanted mimeTypes
    if (strpos($mimeType, 'image') === false) {
        echo "Wrong mime type";
        die();
    } else {
        $split = explode("/", $mimeType);
        $dest = "./images/img" . $id . "." . $split[1];
        $canWrite = move_uploaded_file($source, $dest);

        if (!$canWrite) {
            echo "Can not write to the images subdirectory";
            die();
        }
    }
}

header('Location: index.php');
exit();
