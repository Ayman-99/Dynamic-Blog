<?php include './includes/head.php';
?>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <?php include './includes/header.php'; ?>
        <!-- Left side column. contains the logo and sidebar -->
        <?php include './includes/side-nav.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Dashboard
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Info boxes -->
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-aqua"><i class="fa fa-film"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size: 13px;">Users</span>
                                <span class="info-box-number" id="users_count"></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-red"><i class="fa fa-user"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Categories</span>
                                <span class="info-box-number" id="categories_count"></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix visible-sm-block"></div>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-green"><i class="fa fa-comments-o"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Posts</span>
                                <span class="info-box-number" id="posts_count"></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-yellow"><i class="fa fa-star"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Comments</span>
                                <span class="info-box-number" id="comments_count"></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <div class="col-md-12">
                        <!-- /.box -->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- USERS LIST -->
                                <div class="box box-danger">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Latest Users</h3>
                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body no-padding">
                                        <ul id="dash_info" class="users-list clearfix">
                                            <?php
                                            $result = mysqli_query($con, "select user_image, user_nickname, user_email from users order by user_id DESC limit 10");
                                            while ($row = mysqli_fetch_array($result)) {
                                                ?>
                                                <li>
                                                    <img width='50' height='50' src='<?php echo $row['user_image']; ?>' alt='User Image'>
                                                    <a class='users-list-name' href='#'><?php echo $row['user_nickname']; ?></a>
                                                    <span class='users-list-date'><?php echo $row['user_email']; ?></span>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                    <div class="box-footer text-center">
                                        <a href="users.php" class="uppercase">View All Users</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TABLE: LATEST ORDERS -->
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Top Posts</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table no-margin">
                                        <thead>
                                            <tr>
                                                <th>Post author</th>
                                                <th>Post Title</th>
                                                <th>Post Date</th>
                                                <th>Post Category</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $result = mysqli_query($con, "select * from post_details order by post_views DESC limit 8");
                                            while ($row = mysqli_fetch_array($result)) {
                                                ?>
                                                <tr>
                                                    <th><?php echo $row['post_author']; ?></th>
                                                    <th><?php echo $row['post_title']; ?></th>
                                                    <th><?php echo $row['post_date']; ?></th>
                                                    <th><?php echo $row['post_category']; ?></th>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer clearfix">
                                <a href="posts.php" class="btn btn-sm btn-default btn-flat pull-right">View All Posts</a>
                            </div>
                            <!-- /.box-footer -->
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>       
        <!-- /.content-wrapper -->
        <script>
            function getMoviesCount() {
                $.get("includes/form_handler/home-handler.php" + "?getData=users", function (data) {
                    $("#users_count").html(data);
                });
            }
            function getLikes() {
                $.get("includes/form_handler/home-handler.php" + "?getData=categories", function (data) {
                    $("#categories_count").html(data);
                });
            }
            function getUsers() {
                $.get("includes/form_handler/home-handler.php" + "?getData=posts", function (data) {
                    $("#posts_count").html(data);
                });
            }
            function getComments() {
                $.get("includes/form_handler/home-handler.php" + "?getData=comments", function (data) {
                    $("#comments_count").html(data);
                });
            }
            getMoviesCount();
            getLikes();
            getUsers();
            getComments();
        </script>
        <?php include './includes/footer.php'; ?>
