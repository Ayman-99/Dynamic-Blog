<?php include './includes/head.php'; ?>

<?php
if (!isset($_GET['id'])) {
    header("Location: index.php");
}
$post = new Post($con, isset($_GET['id']) ? validation_input($_GET['id']) : "");

if ($post->getPostCategoryStatus() == "Hidden") {
    header("Location: index.php");
}
$post->increasePostViews();
?>

<body>
    <div id="wrapper">
        <?php include './includes/header.php'; ?>
        <section class="section single-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                        <div class="page-wrapper">
                            <div class="blog-title-area text-center">
                                <ol class="breadcrumb hidden-xs-down">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active"><?php echo $post->getPostTitle(); ?></li>
                                </ol>

                                <span class="color-orange"><?php echo $post->getPostCategory(); ?></span>

                                <h3><?php echo $post->getPostTitle(); ?></h3>

                                <div class="blog-meta big-meta">
                                    <small><a href="#" title=""><?php echo $post->getPostDate(); ?></a></small>
                                    <small><a href="#" title="">Author <?php echo $post->getPostAuthor(); ?></a></small>
                                    <small><a href="#" title=""><i class="fa fa-eye"></i> <?php echo $post->getPostViews(); ?></a></small>
                                </div><!-- end meta -->

                                <div class="post-sharing">
                                    <ul class="list-inline">
                                        <li>
                                            <span class="down-mobile">
                                                <div class="fb-share-button" 
                                                     data-href="https://www.your-domain.com/your-page.html" 
                                                     data-layout="button"
                                                     data-size='large'>
                                                </div>
                                            </span>
                                        </li>
                                        <!-- Load Facebook SDK for JavaScript -->
<!--                                        <script>(function (d, s, id) {
                                                var js, fjs = d.getElementsByTagName(s)[0];
                                                if (d.getElementById(id))
                                                    return;
                                                js = d.createElement(s);
                                                js.id = id;
                                                js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
                                                fjs.parentNode.insertBefore(js, fjs);
                                            }(document, 'script', 'facebook-jssdk'));
                                        </script>-->
                                    </ul>
                                </div>
                            </div><!-- end title -->

                            <div class="single-post-media">
                                <img src="<?php echo $post->getPostImages(); ?>" alt="Post Image" class="img-fluid">
                            </div><!-- end media -->

                            <div class="blog-content">  
                                <?php echo $post->getPostContent(); ?>
                            </div><!-- end content -->

                            <div class="blog-title-area">
                                <div class="tag-cloud-single">
                                    <span>Tags</span>
                                    <?php echo $post->getPostTags(); ?>
                                </div><!-- end meta -->
                            </div><!-- end title -->

                            <hr class="invis1">

                            <div class="custombox clearfix">
                                <h4 class="small-title">You may also like</h4>
                                <div class="row">
                                    <?php
                                    $sql = "select * from posts where post_category LIKE '%{$post->getPostCategory()}%' AND post_id != {$post->getPostId()} order by post_id DESC limit 2";
                                    $query = mysqli_query($con, $sql);
                                    confirmQuery($query);
                                    if (mysqli_num_rows($query) > 0) {
                                        while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                            <div class="col-lg-6">
                                                <div class="blog-box">
                                                    <div class="post-media">
                                                        <a href="post.php?id=<?php echo $row['post_id']; ?>" title="">
                                                            <img src="<?php echo $row['post_image'] ?>" alt="NO IMAGE" class="img-fluid">
                                                            <div class="hovereffect">
                                                                <span class=""></span>
                                                            </div><!-- end hover -->
                                                        </a>
                                                    </div><!-- end media -->
                                                    <div class="blog-meta">
                                                        <h4><a href="post.php?id=<?php echo $row['post_id']; ?>" title=""><?php echo $row['post_title'] ?></a></h4>
                                                        <small><a href="post.php?id=<?php echo $row['post_id']; ?>" title=""><?php echo $row['post_category'] ?></a></small>
                                                        <small><a href="post.php?id=<?php echo $row['post_id']; ?>" title=""><?php echo $row['post_date'] ?></a></small>
                                                    </div><!-- end meta -->
                                                </div><!-- end blog-box -->
                                            </div><!-- end col -->
                                            <?php
                                        }
                                    } else {
                                        echo "<h2>No related posts</h2>";
                                    }
                                    ?>
                                </div><!-- end row -->
                            </div><!-- end custom-box -->

                            <hr class="invis1">

                            <div class="custombox clearfix">
                                <h4 class="small-title"><span id="commentCount"></span> Comments</h4>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div id="commentBox" class="comments-list">
                                        </div>
                                    </div><!--end col -->
                                </div><!--end row -->
                            </div><!--end custom-box -->

                            <hr class = "invis1">

                            <div class = "custombox clearfix">
                                <h4 class = "small-title">Leave a Comment</h4>
                                <div id="myElem" class="alert alert-success" style="display: none;">
                                    <strong>Success!</strong> The action has performed successfully .
                                </div>
                                <div class = "row">
                                    <div class = "col-lg-12">
                                        <form id = 'submitComment' class = "form-wrapper">
                                            <input id="comment_author" type = "text" class = "form-control" placeholder = "Your name" required="">
                                            <textarea id="comment_content" class = "form-control" placeholder = "Your comment" required=""></textarea>
                                            <input id="commentSubmit" type = "submit" class = "btn btn-primary" value="submit">
                                        </form>
                                    </div>
                                    <div id="resultMessage"></div>
                                </div>
                            </div>
                            <!-- handling comment submit using ajax -->
                            <script>
                                $('form#submitComment').submit(function (evt) {
                                    evt.preventDefault();
                                    var author = $("input#comment_author").val();
                                    var content = document.getElementById("comment_content").value;
                                    var url = "includes/handlers/comment-handler.php";
                                    $.ajax({
                                        url: url,
                                        type: 'POST',
                                        data: {target: "<?php echo validation_input($_GET['id']); ?>", com_author: author,
                                            com_data: content},
                                        success: function (show_messages) {
                                            if (!show_messages.error) {
                                                displaySucc();
                                                getCommentsCount();
                                                getComments();
                                            }
                                        }
                                    });
                                });
                                function deleteComment(id) {
                                    $.get("includes/handlers/comment-handler.php?comment_id=" + id, function (data) {
                                        getCommentsCount();
                                        getComments();
                                    });
                                }
                                function getComments() {
                                    $.get("includes/handlers/comment-handler.php?post_id=" +<?php echo (isset($_GET['id'])) ? validation_input($_GET['id']) : 0 ?>, function (data) {
                                        $("#commentBox").html(data);
                                    });
                                }
                                function getCommentsCount() {
                                    $.get("includes/handlers/comment-handler.php?count=1&p_id=" +<?php echo (isset($_GET['id'])) ? validation_input($_GET['id']) : 0 ?>, function (data) {
                                        $("#commentCount").html(data);
                                    });
                                }
                                getCommentsCount();
                                getComments();
                            </script>
                        </div><!--end page-wrapper -->
                    </div><!--end col -->

                    <?php include_once './includes/widgets.php';
                    ?>
                </div><!-- end row -->
            </div><!-- end container -->
        </section>
        <?php include './includes/footer.php'; ?>
