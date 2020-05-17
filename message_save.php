<?php
include_once 'config.php';

$authorID = filter_input(INPUT_POST, "authorID");
$message = filter_input(INPUT_POST, "message");

$con = connectDatabase();
$authorID = mysqli_real_escape_string($con, $authorID);
$message = mysqli_real_escape_string($con, $message);

$query = "INSERT INTO messages (authorID, message) VALUES ('$authorID', '$message')";
mysqli_query($con, $query);

header('Location: index.php');
exit();
