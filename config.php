<?php

//TweeterAppPHP
session_start();

define("HOST", "localhost");
define("USER_NAME", "filip");
define("PASSWORD", "filip");
define("DB_NAME", "lllctest");
define("PORT", "3308");
define("PAGE_SIZE", 5);

function connectDatabase() {
    $con = mysqli_connect(HOST, USER_NAME, PASSWORD, DB_NAME, PORT);
    mysqli_set_charset($con, "utf8");
    return $con;
}

function getUserID() {
    if (isset($_SESSION['userID'])) {
        $id = $_SESSION['userID'];
    } else {
        $id = false;
    }
    return $id;
}

function isAdmin() {
    if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {
        return true;
    } else {
        return false;
    }
}

function isLogged() {
    if (isset($_SESSION['userID'])) {
        return true;
    } else {
        return false;
    }
}

function getUserNameById($userID) {
    $con = connectDatabase();
    $userID = mysqli_real_escape_string($con, $userID);
    $query = "SELECT * FROM users WHERE userID = $userID";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($con);
    return $row['userName'];
}

function getAuthorIDByMessageID($messageID) {
    $con = connectDatabase();
    $query = "SELECT * FROM messages WHERE messageID = $messageID";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($con);
    return $row['authorID'];
}

function getUserIdByUserName($userName) {
    $con = connectDatabase();
    $query = "SELECT * FROM users WHERE userName = $userName";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($con);
    return $row['userID'];
}

function userExists($userName) {
    $con = connectDatabase();
    $userName = mysqli_real_escape_string($con, $userName);
    $query = "SELECT * FROM users WHERE userName = '$userName'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($con);
    if ($row) {
        return true;
    } else {
        return false;
    }
}

function getSearchResult($search, $current_page, $page_size) {
    $first_page_to_show = $current_page * $page_size;
    $con = connectDatabase();
    //Below SQL line is quite evidently a 'grubymi nicmi' stitched Frankenstein's Monster but it IS my baby;) I have a JOIN overdose problem
    $query = "SELECT messages.* FROM users RIGHT JOIN messages ON users.userID = messages.authorID WHERE messages.message LIKE '%$search%' OR users.userName LIKE '%$search%' ORDER BY `date` DESC LIMIT $first_page_to_show, $page_size";
    $result = mysqli_query($con, $query);
    $resultsArray = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $resultsArray;
}

function isUserNameOwner($userName) {
    $con = connectDatabase();
    $userName = mysqli_real_escape_string($con, $userName);
    $query = "SELECT * FROM users WHERE userName = '$userName'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($con);
    $userID = $row['userID'];
    if (isset($_SESSION['userID']) && $_SESSION['userID'] == $userID) {
        return true;
    } else {
        return false;
    }
}

function isOwnerOfMessage($messageID) {
    $con = connectDatabase();
    $query = "SELECT * FROM messages WHERE messageID = '$messageID'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($con);
    $authorID = $row['authorID'];
    if (isset($_SESSION['userID']) && $_SESSION['userID'] == $authorID) {
        return true;
    } else {
        return false;
    }
}

function getMessageByMessageId($messageID) {
    $con = connectDatabase();
    $messageID = mysqli_real_escape_string($con, $messageID);
    $query = "SELECT * FROM messages WHERE messageID = '$messageID'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($con);
    return $row;
}

function getAllMessagesByUserId($userID) {
    $con = connectDatabase();
    $userID = mysqli_real_escape_string($con, $userID);
    $query = "SELECT * FROM messages WHERE authorID = '$userID'";
    $result = mysqli_query($con, $query);
    $resultsArray = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_close($con);
    return $resultsArray;
}

function getAllUsers() {
    $con = connectDatabase();
    $query = "SELECT userID,userName,isAdmin FROM users";
    $result = mysqli_query($con, $query);
    $resultsArray = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_close($con);
    return $resultsArray;
}

function getUserByUserId($userID) {
    $con = connectDatabase();
    $userID = mysqli_real_escape_string($con, $userID);
    $query = "SELECT * FROM users WHERE userID = '$userID'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($con);
    return $row;
}

function deleteUserAndAllUserMessagesByUserId($userID) {
    $con = connectDatabase();
    $userID = mysqli_real_escape_string($con, $userID);
    $query = "DELETE FROM users WHERE userID='$userID'";
    mysqli_query($con, $query);
    $query = "DELETE FROM messages WHERE authorID='$userID'";
    mysqli_query($con, $query);
    mysqli_close($con);
}

function ellipsis($string) {
    return strlen($string) > 50 ? substr($string, 0, 70) . "..." : $string;
}

function hasImage($messageID) {
    if (glob("./images/img$messageID.*") != null) {
        return true;
    } else {
        return false;
    }
}

function getImageSrc($messageID) {
    if (hasImage($messageID)) {
        $list = glob("./images/img$messageID.*");
        $src = $list[0];
        return $src;
    } else {
        return "";
    }
}