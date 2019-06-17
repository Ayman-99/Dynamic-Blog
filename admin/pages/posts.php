<?php include './includes/head.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <?php include './includes/header.php'; ?>
        <!-- =============================================== -->
        <!-- Left side column. contains the sidebar -->
        <?php include './includes/side-nav.php'; ?>
        <!-- =============================================== -->
        <?php
        $error_array = array();
        $succ = "";
        if (isset($_POST['update_data'])) {

            $post_id = validation_input($_POST['post_id']);
            $post_author = validation_input($_POST['post_author']);
            $post_title = validation_input($_POST['post_title']);
            $post_image = "";
            if ($post_id == "") {
                $post_image = $_FILES['post_image']['name'];
                $post_image_full = "upload/$post_image";
                $post_image_temp = $_FILES['post_image']['tmp_name'];
                $error_array = valdiate_upload($post_image, $post_image_temp, "../../upload/$post_image");
            }
            $post_tags = validation_input($_POST['post_tags']);
            $post_category = validation_input($_POST['post_category']);
            $post_added_by = validation_input($_POST['post_added_by']);

            $sql = "";
            if ($post_id == "") {
                $sql = "INSERT INTO `posts`(`post_author`, `post_title`, `post_content`, `post_date`, `post_views`, `post_image`, `post_tags`, `post_category`, `post_added_by`) VALUES "
                        . "('$post_author','$post_title',' ',NOW(),0,'$post_image_full','$post_tags','$post_category','$post_added_by')";
            } else {
                $sql = "UPDATE `posts` SET `post_author`='$post_author',`post_title`='$post_title',"
                        . "`post_tags`='$post_tags',`post_category`='$post_category',`post_added_by`='$post_added_by' WHERE `post_id`=$post_id";
            }
            if (empty($error_array)) {
                confirmQuery(mysqli_multi_query($con, $sql));
                $succ = "T";
            }
        }
        ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    All Posts
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Posts</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- success action -->
                <div id="myElem" class="alert alert-success hide">
                    <strong>Success!</strong> The action has performed successfully .
                </div>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Categories Details</h3>
                    </div>
                    <!-- /.box-header -->
                    Search based on post tags: <input onkeyup="getData('<?php echo $current; ?>', 1, this.value);" type="text" /> 
                    <div class="box-body">
                        <table id="example1" class="table table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Author</th>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Views</th>
                                    <th>Tags</th>
                                    <th>Category</th>
                                    <th>Added By</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody id="users-table">

                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add/Edit Post</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <?php
                    $post_id = $post_author = $post_title = $post_content = $post_image = $post_tags = "";
                    if (isset($_GET['id'])) {
                        $post_id = validation_input($_GET['id']);
                        $result = mysqli_query($con, "Select * from post_details where post_id='$post_id'");
                        $row = mysqli_fetch_array($result);
                        $post_author = $row['post_author'];
                        $post_title = $row['post_title'];
                        $post_content = $row['post_content'];
                        $post_image = $row['post_image'];
                        $post_category = $row['post_category'];
                        $post_added_by = $row['post_added_by'];
                        $post_tags = $row['post_tags'];
                    }
                    ?>
                    <div class="box-body">
                        <div id="succForm" class="alert alert-success <?php echo ($succ == "T") ? '' : 'hide' ?>">
                            <strong>Success!</strong> The action has performed successfully .
                        </div>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Post ID</label>
                                <input name="post_id" type="text" class="form-control" value="<?php echo $post_id; ?>" readonly="readonly">
                            </div>
                            <div class="form-group">
                                <label>Post Author</label>
                                <input name="post_author" type="text" class="form-control" placeholder="Enter Author" value="<?php echo $post_author; ?>" required="">
                            </div>
                            <div class="form-group">
                                <label>Post Title</label>
                                <input name="post_title" type="text" class="form-control" placeholder="Enter Title" value="<?php echo $post_title; ?>" required="">
                            </div>
                            <?php
                            if ($post_image != "") {
                                ?>
                                <div class="form-group">
                                    <img width="100" height="100" src="../../<?php echo $post_image ?>">
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="form-group">
                                    <label>Post Image</label>
                                    <input name="post_image" type="file">
                                </div>
                                <?php echo (in_array("Sorry, only JPG, JPEG, PNG & GIF files are allowed.", $error_array)) ? "<font color='red'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</font>" : ''; ?>
                                <?php
                            }
                            ?>
                            <div class="form-group">
                                <label>Post Tags</label>
                                <input name="post_tags" type="text" class="form-control" placeholder="Enter Tags (add comma between tags)" value="<?php echo $post_tags; ?>" required="">
                            </div>
                            <div class="form-group">
                                <label>Post Category</label>
                                <select name="post_category">
                                    <?php
                                    $result = mysqli_query($con, "select category_name from categories");
                                    while ($row = mysqli_fetch_array($result)) {
                                        if ($post_category == $row['category_name']) {
                                            echo "<option value='{$row['category_name']}' selected>{$row['category_name']}</option>";
                                        } else {
                                            echo "<option value='{$row['category_name']}'>{$row['category_name']}</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Post Added by</label>
                                <select name="post_added_by">
                                    <?php
                                    $result = mysqli_query($con, "select user_nickname from users where user_role='Admin' OR user_role='Moderator'");
                                    while ($row = mysqli_fetch_array($result)) {
                                        if ($post_added_by == $row['user_nickname']) {
                                            echo "<option value='{$row['user_nickname']}' selected>{$row['user_nickname']}</option>";
                                        } else {
                                            echo "<option value='{$row['user_nickname']}'>{$row['user_nickname']}</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" name="update_data" type="submit" class="form-control" value="Add/Edit">
                            </div>
                        </form>
                        <hr>
                        <form id="editPostContent" method="POST" action="">
                            <div class="form-group">
                                <label>Post ID</label>
                                <input id="post_id" type="text" class="form-control" value="<?php echo $post_id; ?>" readonly="readonly" required="">
                            </div>
                            <div class="form-group">
                                <label>Post Content</label>
                                <textarea onkeydown="viewContent()" id='edit' style="margin-top: 30px;" placeholder="Type some text"><?php echo $post_content; ?></textarea>
                            </div>
                            <button type="submit" name="send_message" class="btn btn-primary">Update</button>
                        </form>
                        <h2 id="actionResult"></h2>
                    </div>
                    <script>
                        $("#editPostContent").submit(function (evt) {
                            evt.preventDefault();
                            var id = document.getElementById("post_id").value;
                            var content = document.getElementById("edit").value;
                            if (id.length !== 0) {
                                $.ajax({
                                    url: 'includes/form_handler/post_handler.php',
                                    type: 'POST',
                                    data: {post_id: id, post_content: content},
                                    success: function (result) {
                                        document.getElementById("actionResult").innerHTML = result;
                                    }
                                });
                            } else {
                                document.getElementById("actionResult").innerHTML = "You must choose post to edit from table above";
                            }

                        });
                    </script>
                    <!-- /.box-footer-->
                </div>
            </section>
        </div>
        <!-- /.content-wrapper -->
        <?php include './includes/footer.php'; ?>
