<footer class="main-footer">
    <strong>Copyright &copy; 2019 || Developed By: <a href="http://aymanblog.000webhostapp.com/" target="_blank">Ayman Hunjul</a>.</strong>
</footer>

<div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->


<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- DataTables -->
<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>

<script src="../bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll -->
<!-- ChartJS -->
<script src="../bower_components/chart.js/Chart.js"></script>
<script type="text/javascript" src="../../assets/editor/js/froala_editor.min.js"></script>
<script type="text/javascript" src="../../assets/editor/js/plugins/align.min.js"></script>
<script type="text/javascript" src="../../assets/editor/js/plugins/code_beautifier.min.js"></script>
<script type="text/javascript" src="../../assets/editor/js/plugins/code_view.min.js"></script>
<script type="text/javascript" src="../../assets/editor/js/plugins/draggable.min.js"></script>

<script type="text/javascript" src="../../assets/editor/js/plugins/image.min.js"></script>
<script type="text/javascript" src="../../assets/editor/js/plugins/image_manager.min.js"></script>
<script type="text/javascript" src="../../assets/editor/js/plugins/link.min.js"></script>
<script type="text/javascript" src="../../assets/editor/js/plugins/lists.min.js"></script>
<script type="text/javascript" src="../../assets/editor/js/plugins/paragraph_format.min.js"></script>
<script type="text/javascript" src="../../assets/editor/js/plugins/paragraph_style.min.js"></script>
<script type="text/javascript" src="../../assets/editor/js/plugins/table.min.js"></script>
<script type="text/javascript" src="../../assets/editor/js/plugins/url.min.js"></script>
<script type="text/javascript" src="../../assets/editor/js/plugins/entities.min.js"></script>
<script src="assets/js/custom.js"></script>
<script>
    //update img upload path > image.min.js - > imageUploadURL: Path
    (function () {
        const editorInstance = new FroalaEditor('#edit', {
            enter: FroalaEditor.ENTER_P,
            imageUpload: false,
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
</script>
<!-- page script -->
<script>
    $(function () {
        //  $('#example2').DataTable()
        $('#example1').DataTable({
            'paging': false,
            'lengthChange': false,
            'searching': false,
            'ordering': false,
            'info': true,
            'autoWidth': true
        });
    });
    //Tables handling
    getData("<?php echo $current; ?>", 0, "");
    function setUserChanges(action, source, id) {
        var path = "includes/form_handler/handler.php" + "?action=" + action + "&id=" + id + "&source=" + source;
        $.get(path, function (data) {
            displaySucc();
            getData(source);
        });
    }
    function getData(source, flag, key) {
        $.get("includes/form_handler/handler.php" + "?getData=" + source + "&search=" + flag + "&key=" + key, function (data) {
            $("#users-table").html(data);
        });
    }
    //add or edit category form
    $("#edit_add_category").submit(function (evt) {
        evt.preventDefault();

        var postData = $(this).serialize();
        var source = $(this).attr('action');
        var url = "includes/form_handler/handler.php";
        $.post(url, postData, function (data) {
            if (data !== "Only characters are allowed") {
                displaySucc();
                getData(source);
                $("#category_name_error").html("");
            } else {
                $("#category_name_error").html(data);
            }
        });
    });

    function displaySucc() {
        $("#myElem").removeClass("hide");
        $('#myElem').fadeIn('slow', function () {
            $('#myElem').delay(1200).fadeOut();
        });
    }
    function displaySuccForm() {
        $("#succForm").removeClass("hide");
        $('#succForm').fadeIn('slow', function () {
            $('#succForm').delay(1200).fadeOut();
        });
    }


</script>
</body>
</html>





















































































































































