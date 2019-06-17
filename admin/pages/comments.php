<?php include './includes/head.php'; ?>

<body class="hold-transition skin-blue sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <?php include './includes/header.php'; ?>
        <!-- =============================================== -->
        <!-- Left side column. contains the sidebar -->
        <?php include './includes/side-nav.php'; ?>
        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    All Comments
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Comments</li>
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
                        <h3 class="box-title">Users Details</h3>
                    </div>
                    <!-- /.box-header -->
                    Search based on comment content: <input onkeyup="getData('<?php echo $current; ?>', 1, this.value);" type="text" />
                    <div class="box-body">
                        <table id="example1" class="table table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Author</th>
                                    <th>Content</th>
                                    <th>Date</th>
                                    <th>Post</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody id="users-table">

                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <?php
                    if (is_Admin($loggedIn->getUserNickname())) {
                        ?>
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Add/Edit Movie</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                            title="Collapse">
                                        <i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <?php
                            $comment_id = $comment_author = "";
                            if (isset($_GET['id'])) {
                                $comment_id = validation_input($_GET['id']);
                                $result = mysqli_query($con, "Select * from comments where comment_id='$comment_id'");
                                $row = mysqli_fetch_array($result);
                                $comment_author = $row['comment_author'];
                            }
                            ?>
                            <div class="box-body">
                                <div id="succForm" class="alert alert-success <?php echo ($succ == "T") ? '' : 'hide' ?>">
                                    <strong>Success!</strong> The action has performed successfully .
                                </div>
                                <form id='editCommentForm' action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Comment ID</label>
                                        <input id="com_id" type="text" class="form-control" value="<?php echo $comment_id; ?>" readonly="readonly">
                                    </div>
                                    <div class="form-group">
                                        <label>Comment Author</label>
                                        <input id="com_author" type="text" class="form-control" placeholder="Enter Author" value="<?php echo $comment_author; ?>" required="">
                                    </div>

                                    <div class="form-group">
                                        <input class="btn btn-primary" name="update_data" type="submit" class="form-control" value="Edit">
                                    </div>
                                </form>
                                <hr>
                                <h2 id="actionResult"></h2>
                            </div>
                            <script>
                                $("#editCommentForm").submit(function (evt) {
                                    evt.preventDefault();
                                    var id = document.getElementById("com_id").value;
                                    var author = document.getElementById("com_author").value;
                                    if (id.length !== 0) {
                                        $.ajax({
                                            url: 'includes/form_handler/handler.php',
                                            type: 'POST',
                                            data: {com_id: id, com_author: author},
                                            success: function (result) {
                                                getData("comments.php", 0, "");
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
                        <?php
                    }
                    ?>
            </section>
        </div>
        <!-- /.content-wrapper -->
        <?php include './includes/footer.php'; ?>
