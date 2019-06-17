<?php
include_once '../../config/db.php';
include_once '../../functions.php';

if (isset($_POST['target']) && isset($_POST['com_author']) && isset($_POST['com_data'])) {
    $id = validation_input($_POST['target']);
    $author = validation_input($_POST['com_author']);
    $data = validation_input($_POST['com_data']);

    confirmQuery(mysqli_query($con, "insert into comments values (null, '$author','$data','images/others/guest.png',NOW(),$id);"));
}

if (isset($_GET['post_id'])) {
    $sql = "select * from comments where comment_post=" . validation_input($_GET['post_id']) . " order by comment_id DESC";
    $query = mysqli_query($con, $sql);
    confirmQuery($query);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            ?>
            <div class = "media">
                <a class = "media-left" href = "#">
                    <img src = "<?php echo $row['comment_image']; ?>" alt = "" class = "rounded-circle">
                </a>
                <div class = "media-body">
                    <?php
                    if (isset($_SESSION['username']) && (is_Admin($_SESSION['username']) || is_Moderator($_SESSION['username']))) {
                        ?>
                        <span class="pull-right">
                            <button onclick="deleteComment('<?php echo $row['comment_id']; ?>')" style="background: inherit;" type="submit">
                                <i class="fa fa-trash" aria-hidden="true" style="color: red;"></i>
                            </button>
                        </span>
                        <?php
                    }
                    ?>
                    <h4 class = "media-heading user_name"><?php echo $row['comment_author'] ?> <small><?php echo $row['comment_date']; ?></small></h4>
                    <p><?php echo $row['comment_content']; ?></p>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<h3>No comments to display</h3>";
    }
}

if (isset($_GET['p_id']) && isset($_GET['count'])) {
    $sql = "select * from comments where comment_post=" . validation_input($_GET['p_id']) . " order by comment_id DESC";
    $query = mysqli_query($con, $sql);
    confirmQuery($query);
    echo mysqli_num_rows($query);
}

if (isset($_GET['comment_id'])) {
    $id = validation_input($_GET['comment_id']);
    $sql = "delete from comments where comment_id='$id'";
    $query = mysqli_query($con, $sql);
    confirmQuery($query);
}





