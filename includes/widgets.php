<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
    <div class="sidebar">
        <div class="widget">
            <h2 class="widget-title">Categories</h2>
            <div class="trend-videos">
                <div class="blog-box">
                    <div class="blog-meta">
                        <ul class="list-group">
                            <?php
                            $sql = "select * from categories where category_status != 'Hidden'";
                            $query = mysqli_query($con, $sql);
                            confirmQuery($query);
                            if (mysqli_num_rows($query) > 0) {
                                while ($row = mysqli_fetch_array($query)) {
                                    echo "<li class='list-group-item'><h4><a href='categories.php?cat={$row['category_name']}" . "'>{$row['category_name']}</a></h4></li>";
                                }
                            } else {
                                echo "<h5 class='mb-1'>No Categories</h5>";
                            }
                            ?>
                        </ul> 
                    </div><!-- end meta -->
                </div><!-- end blog-box -->
                <hr class="invis">
            </div>
        </div><!-- end widget -->

        <div class="widget">
            <h2 class="widget-title">Popular Posts</h2>
            <div class="blog-list-widget">
                <div class="list-group">
                    <?php
                    $sql = "select * from posts inner join categories on posts.post_category=categories.category_name "
                            . "where categories.category_status != 'Hidden' order by post_views DESC limit 6";
                    $query = mysqli_query($con, $sql);
                    confirmQuery($query);
                    if (mysqli_num_rows($query) > 0) {
                        while ($row = mysqli_fetch_array($query)) {
                            ?>

                            <a href="post.php?id=<?php echo $row['post_id']; ?>" class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="w-100 justify-content-between">
                                    <img src="<?php echo $row['post_image']; ?>" width="600" height="500" alt="" class="img-fluid float-left">
                                    <h5 class="mb-1"><?php echo substr($row['post_title'], 0, 20) . ".."; ?></h5>
                                    <small><?php echo $row['post_date']; ?></small>
                                </div>
                            </a>
                            <hr>
                            <?php
                        }
                    } else {
                        echo "<h5 class='mb-1'>No Popular Posts</h5>";
                    }
                    ?>
                </div>
            </div><!-- end blog-list -->
        </div><!-- end widget -->

        <div class="widget">
            <h2 class="widget-title">Recent Comments</h2>
            <div class="blog-list-widget">
                <div class="list-group">
                    <?php
                    $sql = "select comment_content, comment_post from comments order by comment_id DESC limit 5";
                    $query = mysqli_query($con, $sql);
                    confirmQuery($query);
                    if (mysqli_num_rows($query) > 0) {
                        while ($row = mysqli_fetch_array($query)) {
                            ?>
                            <a href="post.php?id=<?php echo $row['comment_post']; ?>" class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="w-100 justify-content-between">
                                    <h5 class="mb-1"><?php echo $row['comment_content']; ?></h5>
                                </div>
                            </a>
                            <hr>
                            <?php
                        }
                    } else {
                        echo "<h5 class='mb-1'>No Comments</h5>";
                    }
                    ?>
                </div>
            </div><!-- end blog-list -->
        </div><!-- end widget -->

        <!--        <div class="widget">
                    <h2 class="widget-title">Follow Me</h2>
        
                    <div class="row text-center">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                            <a href="#" class="social-button facebook-button">
                                <i class="fa fa-facebook"></i>
                                <p>27k</p>
                            </a>
                        </div>
        
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                            <a href="#" class="social-button twitter-button">
                                <i class="fa fa-twitter"></i>
                                <p>98k</p>
                            </a>
                        </div>
        
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                            <a href="#" class="social-button google-button">
                                <i class="fa fa-google-plus"></i>
                                <p>17k</p>
                            </a>
                        </div>
        
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                            <a href="#" class="social-button youtube-button">
                                <i class="fa fa-youtube"></i>
                                <p>22k</p>
                            </a>
                        </div>
                    </div>
                </div>   -->
    </div><!-- end sidebar -->
</div><!-- end col -->
