<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="widget">
                    <div class="footer-text text-left">
                        <a href="index.html"><img src="images/version/tech-footer-logo.png" alt="" class="img-fluid"></a>
                        <p>Ayman Blog</p>
                        <div class="social">
                            <a href="https://www.facebook.com/ayman.hunjul.77" data-toggle="tooltip" data-placement="bottom" title="Facebook"><i class="fa fa-facebook"></i></a>              
                        </div>
                    </div><!-- end footer-text -->
                </div><!-- end widget -->
            </div><!-- end col -->

            <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                <div class="widget">
                    <h2 class="widget-title">Categories</h2>
                    <div class="link-widget">
                        <?php
                        $sql = "select * from categories where category_status != 'Hidden' order by category_id DESC limit 5";
                        $query = mysqli_query($con, $sql);
                        confirmQuery($query);
                        ?>
                        <ul>
                            <?php
                            while ($row = mysqli_fetch_array($query)) {
                                ?>
                                <li><a href="categories.php?cat=<?php echo $row['category_name']; ?>"><?php echo $row['category_name']; ?></a> <span>(<?php echo mysqli_num_rows(mysqli_query($con, "select post_id from posts where post_category='{$row['category_name']}'")) ?>)</span></a></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div><!-- end link-widget -->
                </div><!-- end widget -->
            </div><!-- end col -->

            <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                <div class="widget">
                    <h2 class="widget-title">Copyrights</h2>
                    <div class="link-widget">
                        <ul>
                            <li><a href="http://aymanblog.000webhostapp.com/">About me</a></li>
                        </ul>
                    </div><!-- end link-widget -->
                </div><!-- end widget -->
            </div><!-- end col -->
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                <br>
                <div class="copyright">&copy; Developed by: <a href="http://aymanblog.000webhostapp.com/">Ayman Hunjul</a>.</div>
            </div>
        </div>
    </div><!-- end container -->
</footer><!-- end footer -->

</div><!-- end wrapper -->

<!-- Core JavaScript
================================================== -->
<script src="assets/js/tether.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script type="text/javascript"
src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
<script type="text/javascript"
src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>
<script type="text/javascript" src="assets/editor/js/froala_editor.min.js"></script>
<script type="text/javascript" src="assets/editor/js/plugins/align.min.js"></script>
<script type="text/javascript" src="assets/editor/js/plugins/code_beautifier.min.js"></script>
<script type="text/javascript" src="assets/editor/js/plugins/code_view.min.js"></script>
<script type="text/javascript" src="assets/editor/js/plugins/draggable.min.js"></script>
<script type="text/javascript" src="assets/editor/js/plugins/image.min.js"></script>
<script type="text/javascript" src="assets/editor/js/plugins/image_manager.min.js"></script>
<script type="text/javascript" src="assets/editor/js/plugins/link.min.js"></script>
<script type="text/javascript" src="assets/editor/js/plugins/lists.min.js"></script>
<script type="text/javascript" src="assets/editor/js/plugins/paragraph_format.min.js"></script>
<script type="text/javascript" src="assets/editor/js/plugins/paragraph_style.min.js"></script>
<script type="text/javascript" src="assets/editor/js/plugins/table.min.js"></script>
<script type="text/javascript" src="assets/editor/js/plugins/video.min.js"></script>
<script type="text/javascript" src="assets/editor/js/plugins/url.min.js"></script>
<script type="text/javascript" src="assets/editor/js/plugins/entities.min.js"></script>
<script src="assets/js/custom.js"></script>
<script>
    (function () {
        const editorInstance = new FroalaEditor('#edit', {
            enter: FroalaEditor.ENTER_P,
            placeholderText: null,
            events: {
                initialized: function () {
                    const editor = this
                    this.el.closest('form').addEventListener('submit', function (e) {
                        console.log(editor.$oel.val())
                        e.preventDefault()
                    })
                }
            }
        })
    })()
    function displaySucc() {
        $("#myElem").removeAttr("style");
        $('#myElem').fadeIn('slow', function () {
            $('#myElem').delay(1200).fadeOut();
        });
    }
</script>
</body>
</html>
