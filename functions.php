<?php

function confirmQuery($query) {
    global $con;
    if (!$query) {
        die("QUERY FAILED" . " " . mysqli_error($con));
    }
}

function validation_input($data) {
    global $con;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = strip_tags($data); //Remove html tags
    $data = mysqli_real_escape_string($con, $data);
    return $data;
}

function is_Admin($username) {
    global $con;
    if (!$con) {
        include 'config/db.php';
    }
    $query = "SELECT user_role FROM users WHERE user_nickname ='$username'";
    $result = mysqli_query($con, $query);
    confirmQuery($result);
    $row = mysqli_fetch_array($result);
    if ($row['user_role'] == 'Admin') {
        return true;
    } else {
        return false;
    }
}

function is_Moderator($username) {
    global $con;
    if (!$con) {
        include 'config/db.php';
    }
    $query = "SELECT user_role FROM users WHERE user_nickname ='$username'";
    $result = mysqli_query($con, $query);
    confirmQuery($result);
    $row = mysqli_fetch_array($result);
    if ($row['user_role'] == 'Moderator') {
        return true;
    } else {
        return false;
    }
}

