<?php

include '../../config/db.php';
include '../../function.php';

if (isset($_POST['post_id']) && isset($_POST['post_content'])) {
    $post_id = validation_input($_POST['post_id']);
    $post_content = ($_POST['post_content']);
    $post_content = substr($post_content, 0, - 229);
    confirmQuery(mysqli_query($con, "update posts SET post_content='$post_content' where post_id=$post_id"));
    echo "Post has been updated";
}
