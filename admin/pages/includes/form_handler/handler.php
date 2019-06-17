<?php
/*
 * This handler for control panel pages, to get details from db and to update records      TABLE HANDLER
 */
include '../../config/db.php';
include '../../function.php';


/* for searching */
if (isset($_GET['getData']) && isset($_GET['search']) && isset($_GET['key'])) {
    $source = validation_input($_GET['getData']);
    $search = validation_input($_GET['search']);
    $key = validation_input($_GET['key']);
    switch ($source) {
        case "users.php":
            $sql = "";
            if ($search == 1) {
                $sql = "Select * from users where user_nickname LIKE '%$key%' && user_role != 'Admin'";
            } else {
                $sql = "Select * from users where user_role != 'Admin'";
            }
            $result = mysqli_query($con, $sql);
            confirmQuery($result);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <th><?php echo $row['user_id']; ?></th>
                    <th><?php echo $row['user_nickname']; ?></th>
                    <th><?php echo $row['user_email']; ?></th>
                    <th><img src="<?php echo $row['user_image']; ?>" width="100" height="100"></th>
                    <th><?php echo $row['user_account_status']; ?></th>
                    <th><?php echo $row['user_role']; ?></th>
                    <th>
                        <a onclick="setUserChanges('active', '<?php echo $source; ?>', '<?php echo $row['user_id']; ?>')">Active</a><br>
                        <a onclick="setUserChanges('inactive', '<?php echo $source; ?>', '<?php echo $row['user_id']; ?>')">Inactive</a>
                    </th>
                    <th>
                        <a onclick="setUserChanges('admin', '<?php echo $source; ?>', '<?php echo $row['user_id']; ?>')">Admin</a><br>
                        <a onclick="setUserChanges('moderator', '<?php echo $source; ?>', '<?php echo $row['user_id']; ?>')">Moderator</a><br>
                        <a onclick="setUserChanges('user', '<?php echo $source; ?>', '<?php echo $row['user_id']; ?>')">User</a>
                    </th>
                    <th>
                        <a href="<?php echo "users.php?id={$row['user_id']}" ?>">Edit</a><br>
                    </th>
                    <th>
                        <a onclick="setUserChanges('delete', '<?php echo $source; ?>', '<?php echo $row['user_id']; ?>')">Delete</a><br>
                    </th>
                </tr>
                <?php
            }
            break;
        case "posts.php":
            $sql = "";
            if ($search == 1) {
                $sql = "select * from post_details where post_tags like '%{$key}%'";
            } else {
                $sql = "Select * from post_details";
            }
            $result = mysqli_query($con, $sql);
            confirmQuery($result);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td><a href="../../post.php?id=<?php echo $row['post_id']; ?>" target="_blank"><?php echo $row['post_id']; ?></a></td>
                    <td><?php echo $row['post_author']; ?></td>
                    <td><?php echo substr($row['post_title'], 0, 120); ?> </td>
                    <td><?php echo $row['post_date']; ?> </td>
                    <td><?php echo $row['post_views']; ?> </td>
                    <td><?php echo $row['post_tags']; ?> </td>
                    <td><?php echo $row['post_category']; ?> </td>
                    <td><?php echo $row['post_added_by']; ?> </td>
                    <td><a href="posts.php?id=<?php echo $row['post_id']; ?>">Edit</a></td>
                    <th><a onclick="setUserChanges('delete', '<?php echo $source; ?>', '<?php echo $row['post_id']; ?>')">Delete</a></th>
                </tr>
                <?php
            }
            break;

        case "categories.php":
            $sql = "";
            if ($search == 1) {
                $sql = "select * from categories where category_name like '%{$key}%'";
            } else {
                $sql = "Select * from categories";
            }
            $result = mysqli_query($con, $sql);
            confirmQuery($result);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <th><?php echo $row['category_id']; ?></th>
                    <th><?php echo $row['category_name']; ?></th>
                    <th><?php echo $row['category_status']; ?></th>
                    <th>
                        <a onclick="setUserChanges('show', '<?php echo $source; ?>', '<?php echo $row['category_id']; ?>')">Show</a><br>
                        <a onclick="setUserChanges('hide', '<?php echo $source; ?>', '<?php echo $row['category_id']; ?>')">Hidden</a><br>
                    </th>
                    <th><a href="<?php echo $source . "?id={$row['category_id']}&name={$row['category_name']}"; ?>">Edit</a></th>
                    <th><a onclick="setUserChanges('delete', '<?php echo $source; ?>', '<?php echo $row['category_id']; ?>')">Delete</a></th>
                </tr>
                <?php
            }
            break;

        case "comments.php":
            $sql = "";
            if ($search == 1) {
                $sql = "select * from comments where comment_content like '%{$key}%'";
            } else {
                $sql = "Select * from comments";
            }
            $result = mysqli_query($con, $sql);
            confirmQuery($result);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <th><?php echo $row['comment_id']; ?></th>
                    <th><?php echo $row['comment_author']; ?></th>
                    <th><?php echo $row['comment_content']; ?></th>
                    <th><?php echo $row['comment_date']; ?></th>
                    <th><a href='../../post.php?id=<?php echo $row['comment_post']; ?>' target="_blank"><?php echo $row['comment_post']; ?></a></th>
                    <th><a href='comments.php?id=<?php echo $row['comment_id']; ?>'>Edit</a></th>
                    <th><a onclick="setUserChanges('delete', '<?php echo $source; ?>', '<?php echo $row['comment_id']; ?>')">Delete</a></th>
                </tr>
                <?php
            }
            break;
    }
}

/*
 * perform actions on the source page could be users.php or movies.php etc    TABLE HANDLER
 */
if (isset($_GET['action'])) {
    $source = validation_input($_GET['source']);
    switch ($source) {
        case "users.php":
            switch ($_GET['action']) {
                case "active":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "Update users set user_account_status='Active' where user_id={$id}"));
                    break;

                case "inactive":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "Update users set user_account_status='Inactive' where user_id={$id}"));
                    break;

                case "admin":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "Update users set user_role='Admin' where user_id={$id}"));
                    break;

                case "moderator":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "Update users set user_role='Moderator' where user_id={$id}"));
                    break;

                case "user":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "Update users set user_role='User' where user_id={$id}"));
                    break;

                case "delete":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "delete from users where user_id={$id}"));
                    break;
            }
            break;


        case "categories.php":
            switch ($_GET['action']) {
                case "show":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "Update categories SET category_status='Show' where category_id={$id}"));
                    break;
                case "hide":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "Update categories SET category_status='Hidden' where category_id={$id}"));
                    break;
                case "delete":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "delete from categories where category_id={$id}"));
                    break;
            }
            break;

        case "posts.php":
            switch ($_GET['action']) {
                case "delete":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "delete from posts where post_id={$id}"));
                    break;
            }
            break;

        case "comments.php":
            switch ($_GET['action']) {
                case "delete":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "delete from comments where comment_id={$id}"));
                    break;
            }
            break;
    }
}

/*
 * FORM HANDLER
 */
if (isset($_POST['cat_name'])) {
    $id = validation_input($_POST['cat_id']);
    $name = validation_input($_POST['cat_name']);
    $sql = "";
    if ($id == "") {
        $sql = "insert into categories values (null, '$name','Hidden')";
    } else {
        $sql = "update categories set category_name='$name' where category_id='$id'";
    }
    if (ctype_alpha($name)) {
        confirmQuery(mysqli_query($con, $sql));
    } else {
        echo "Only characters are allowed";
    }
}

if (isset($_POST['com_id']) && isset($_POST['com_author'])) {
    $id = validation_input($_POST['com_id']);
    $name = validation_input($_POST['com_author']);
    $sql = "update comments set comment_author='$name' where comment_id='$id'";
    confirmQuery(mysqli_query($con, $sql));
    echo "Comment updated!";
}
