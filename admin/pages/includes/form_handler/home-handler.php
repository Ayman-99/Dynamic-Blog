<?php
include '../../config/db.php';
include '../../function.php';

if (isset($_GET['getData'])) {
    switch ($_GET['getData']) {
        case 'users':
            $result = mysqli_query($con, "select count(user_id) as result from users;");
            $row = mysqli_fetch_array($result);
            echo $row['result'];
            break;
        case 'categories':
            $row = mysqli_fetch_array(mysqli_query($con, "select count(category_id) as result from categories;"));
            echo $row['result'];
            break;
        case 'posts':
            $row = mysqli_fetch_array(mysqli_query($con, "select count(post_id) as result from posts;"));
            echo $row['result'];
            break;
        case 'comments':
            $row = mysqli_fetch_array(mysqli_query($con, " select count(comment_id) as result from comments;"));
            echo $row['result'];
            break;
        default : echo 0;
    }
}
