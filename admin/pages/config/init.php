<?php

include 'config/db.php';
include 'function.php'; //includes helpful functions
include_once 'includes/classes/User.php';

if (!isset($_SESSION['username'])) {
    header("Location: lockscreen.php");
}
$loggedIn = new User($con, $_SESSION['username']); //global variable which holds online user





























