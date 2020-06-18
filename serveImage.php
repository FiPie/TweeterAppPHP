<?php

include_once 'config.php';

//Get the file name
if (isset($_GET['id'])) {
    $messageID = filter_input(INPUT_GET, "id");
} else {
    die();
}

$file = getImageSrc($messageID);
$mimeType = image_type_to_mime_type(exif_imagetype($file));
header("Content-type: ". $mimeType);

readfile($file);