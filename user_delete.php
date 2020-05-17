<?php

session_start();
if ((isset($_SESSION['logged']) == FALSE) || ($_SESSION['logged'] == FALSE)) {
    header('Location: index.php');
    exit();
}
include_once 'config.php';
$con = connectDatabase();
$id = $_SESSION['userID'];
$author = $_SESSION['userName'];

$query1 = "DELETE FROM users WHERE userID='$id'";
mysqli_query($con, $query1);
$query1 = "DELETE FROM messages WHERE author='$author'";
mysqli_query($con, $query1);

header('Location: logout.php');
