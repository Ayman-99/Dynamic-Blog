<?php include './includes/head.php'; ?>

<body>
    <div id="wrapper">
        <?php include './includes/header.php'; ?>

        <div class="page-title lb single-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <h2><i class="fa fa-star bg-orange"></i> Categories</h2>
                    </div><!-- end col -->
                    <div class="col-lg-4 col-md-4 col-sm-12 hidden-xs-down hidden-sm-down">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Categories</li>
                        </ol>
                    </div><!-- end col -->                    
                </div><!-- end row -->
            </div><!-- end container -->
        </div><!-- end page-title -->

        <section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                        <div class="page-wrapper">
                            <div class="blog-list clearfix">
                                <?php
                                $per_page = 5;
                                if (isset($_GET['page'])) {
                                    $page = $_GET['page'];
                                } else {
                                    $page = '';
                                }

                                if ($page == "" || $page == 1) {
                                    $page_1 = 0;
                                } else {
                                    $page_1 = ($page * $per_page) - $per_page;
                                }

                                $sql = "select * from post_details where category_status != 'Hidden' ORDER BY post_id DESC ";
                                if (isset($_GET['cat'])) {
                                    $cat = validation_input($_GET['cat']);
                                    $sql = "select * from post_details where category_status != 'Hidden' AND category_name='$cat' ORDER BY post_id DESC ";
                                }
                                $posts_count_result = mysqli_query($con, $sql);
                                confirmQuery($posts_count_result);

                                $count = mysqli_num_rows($posts_count_result);

                                if ($count > 0) {
                                    $count = ceil($count / $per_page);
                                    $sql .= "LIMIT $page_1,$per_page";
                                    $query = mysqli_query($con, $sql);
                                    confirmQuery($query);
                                    while ($row = mysqli_fetch_array($query)) {
                                        ?>
                                        <div class="blog-box row">
                                            <div class="col-md-4">
                                                <div class="post-media">
                                                    <a href="post.php?id=<?php echo $row['post_id']; ?>" title="">
                                                        <img src="<?php echo $row['post_image']; ?>" alt="NO IMAGE" class="img-fluid">
                                                        <div class="hovereffect"></div>
                                                    </a>
                                                </div><!-- end media -->
                                            </div><!-- end col -->

                                            <div class="blog-meta big-meta col-md-8">
                                                <h4><a href="post.php?id=<?php echo $row['post_id']; ?>" title=""><?php echo substr($row['post_title'], 0, 50); ?></a></h4>
                                                <p><?php echo substr(strip_tags($row['post_content']), 0, 150) . " . . ." ?></p>
                                                <small class="firstsmall"><a class="bg-orange" title=""><?php echo $row['post_category']; ?></a></small>
                                                <small><a href="post.php?id=<?php echo $row['post_id']; ?>" title=""><?php echo $row['post_date']; ?></a></small>
                                                <small><a href="post.php?id=<?php echo $row['post_id']; ?>" title="">Added by <?php echo $row['post_added_by']; ?></a></small>
                                                <small><a href="post.php?id=<?php echo $row['post_id']; ?>" title=""><i class="fa fa-eye"></i> <?php echo $row['post_views']; ?></a></small>
                                            </div><!-- end meta -->
                                        </div><!-- end blog-box -->
                                        <hr class="invis">
                                        <?php
                                    }
                                } else {
                                    echo "<h3>No Posts to display</h3>";
                                }
                                ?>
                            </div><!-- end blog-list -->
                        </div><!-- end page-wrapper -->

                        <hr class="invis">

                        <div class="row">
                            <div class="col-md-12">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-start">
                                        <?php
                                        for ($i = 1; $i <= $count; $i++) {
                                            if (isset($_GET['cat'])) {
                                                if ($i == $page) {
                                                    echo "<li class='page-item active'><a class='page-link' href='categories.php?cat=" . validation_input($_GET['cat']) . "&page={$i}'>$i</a></li>";
                                                } else {
                                                    echo "<li class='page-item'><a class='page-link' href='categories.php?cat=" . validation_input($_GET['cat']) . "&page={$i}'>$i</a></li>";
                                                }
                                            } else {
                                                if ($i == $page) {
                                                    echo "<li class='page-item active'><a class='page-link' href='categories.php?page={$i}'>$i</a></li>";
                                                } else {
                                                    echo "<li class='page-item'><a class='page-link' href='categories.php?page={$i}'>$i</a></li>";
                                                }
                                            }
                                        }
                                        ?>
                                    </ul>
                                </nav>
                            </div><!-- end col -->
                        </div><!-- end row -->
                    </div><!-- end col -->
                    <?php include_once './includes/widgets.php'; ?>
                </div><!-- end row -->
            </div><!-- end container -->
        </section>

        <?php include './includes/footer.php'; ?>
