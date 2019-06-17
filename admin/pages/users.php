<?php
include './includes/head.php';
if (!is_Admin($loggedIn->getUserNickname())) {
    header("Location: dashboard.php");
}

$user_id = $user_nickname = $user_email = $user_pass = $user_image = "";
$success = "";
//no check if email exists validation. Can make function in the db, Pass need to be encrypted
$error_array = array();
if (isset($_POST['save_user_data'])) {
    if (empty($_POST['id'])) {
        $user_nickname = validation_input($_POST['nickname']);
        if (nicknameExists($user_nickname)) {
            array_push($error_array, "Error Nickname already exists");
        }

        $user_email = validation_input($_POST['email']);
        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            array_push($error_array, "Error your email is invalid");
        }
        if (emailExists($user_email)) {
            array_push($error_array, "Error email already registered");
            print_r($error_array);
        }

        $user_pass = validation_input($_POST['pass']);
        if (strlen($user_pass) < 8) {
            array_push($error_array, "Error password must be between 8 and 22");
        } else {
            $pass = validation_input($_POST['pass']);
            $user_pass = md5($pass);
        }

        if ($_FILES['image']['error'] !== 4) {
            $user_image = $_FILES['image']['name'];
            $user_image_temp = $_FILES['image']['tmp_name'];
            $error_array2 = valdiate_upload($user_image, $user_image_temp, "../../images/profile/$user_image");
            $user_image = "../../images/profile/$user_image";
        } else {
             $user_image = "../../images/profile/guest.png";
        }
        if (empty($error_array) && empty($error_array2)) {
            $sql = "insert into users values (null, '$user_nickname','$user_email','$user_pass','$user_image', 'Inactive', 'User','')";
            confirmQuery(mysqli_query($con, $sql));
            //as new info updated we update current object if its mod or dev we make new moderator class else Person
            echo "<meta http-equiv='refresh' content='0'>";
        }
    } else {
        $flag1 = $flag2 = false; //$flag2 one for pass, flag 1 for img
        $sql = "";
        $user_nickname = validation_input($_POST['nickname']);
        $user_email = validation_input($_POST['email']);
        $user_id = validation_input($_POST['id']);

        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            array_push($error_array, "Error your email is invalid");
        } else {
            if ($_SESSION['edit_email'] === 0) {
                $sql = "UPDATE `users` SET `user_email`='$user_email', ";
            } else {
                $sql = "UPDATE `users` SET ";
            }
        }
        if ($_FILES['image']['error'] !== 4) {
            $user_image = $_FILES['image']['name'];
            $profile_image_temp = $_FILES['image']['tmp_name'];
            $error_array = valdiate_upload($user_image, $user_image_temp, "../../images/profile/$user_image");
            $user_image = "../../images/profile/$user_image";
            $flag1 = true;
        }
        if (strlen($_POST['pass']) < 8) {
            array_push($error_array, "Error password must greater than 8 characters");
        } else {
            $pass = validation_input($_POST['pass']);
            $user_pass = md5($pass);
            $flag2 = true;
        }
        if ($flag1 && $flag2) {
            $sql .= "`user_image`='$user_image',`user_password`='$user_pass', user_nickname='$user_nickname' WHERE user_id='$user_id'";
        } else if ($flag1) {
            $sql .= "`user_image`='$profile_img',user_nickname='$user_nickname' WHERE user_id='$user_id'";
        } else if ($flag2) {
            $sql .= "`user_password`='$user_pass', user_nickname='$user_nickname' WHERE user_id='$user_id'";
        } else {
            $sql .= "user_nickname='$user_nickname' WHERE user_id='$user_id'";
        }

        if (empty($error_array)) {
            confirmQuery(mysqli_query($con, $sql));
            //as new info updated we update current object if its mod or dev we make new moderator class else Person
            echo "<meta http-equiv='refresh' content='0'>";
        }
    }
}
?>
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
                    All Users
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Users</li>
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
                    Search based on Nickname: <input onkeyup="getData('<?php echo $current; ?>', 1, this.value);" type="text" /> 
                    <div class="box-body">
                        <table id="example1" class="table table-hover table-bordered table-striped">
                            <thead>
                                <tr><!-- onkeyup="searchData('<?php // echo $current;                                        ?>', this.value)"-->
                                    <th>ID</th>
                                    <th>Nickname</th>
                                    <th>Email</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Role</th>
                                    <th>Set Status</th>
                                    <th>Set Role</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody id="users-table">

                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add/Edit User</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                        title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <?php
                        if (isset($_GET['id'])) {
                            $user_id = validation_input($_GET['id']);
                            $result = mysqli_query($con, "Select user_nickname,user_password,user_email,user_image from users where user_id='$user_id'");
                            $row = mysqli_fetch_array($result);
                            $user_nickname = $row['user_nickname'];
                            $user_email = $row['user_email'];
                            $user_image = $row['user_image'];
                            $user_password = $row['user_password'];
                        }
                        ?>
                        <div class="box-body">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>User ID</label>
                                    <input name='id' type="text" class="form-control" id="userName" placeholder="Enter Id" value="<?php echo $user_id; ?>" readonly="">
                                </div>
                                <div class="form-group">
                                    <label>User Nickname</label>
                                    <input name='nickname' type="text" class="form-control" id="userName" placeholder="Enter Nickname" value="<?php echo $user_nickname; ?>" required="">
                                    <div class="marginLeft  <?php echo (in_array("Error Nickname already exists", $error_array)) ? "" : "hidden"; ?>">
                                        <?php
                                        echo "Error Nickname already exists";
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>User Password</label>
                                    <input name='pass' type="password" class="form-control" id="passWord" placeholder="Enter Password" value="<?php echo $user_password; ?>" required="">
                                    <div class="marginLeft  <?php echo (in_array("Error password must be between 8 and 22", $error_array)) ? "" : "hidden"; ?>">
                                        <?php
                                        if (in_array("Error password must be between 8 and 22", $error_array)) {
                                            echo "Error password must be between 8 and 22";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>User Email</label>
                                    <?php
                                    if (isset($_GET['id'])) {
                                        $_SESSION['edit_email'] = 0;
                                        ?>
                                        <input name='email' type="email" class="form-control" id="email" placeholder="Enter Email" value="<?php echo $user_email; ?>" required="" readonly="">
                                        <?php
                                    } else {
                                        $_SESSION['edit_email'] = 1;
                                        ?>
                                        <input name='email' type="email" class="form-control" id="email" placeholder="Enter Email" value="<?php echo $user_email; ?>" required="">
                                        <?php
                                    }
                                    ?>
                                    <div class="marginLeft  <?php echo (in_array("Error email already registered", $error_array) || in_array("Error your email is invalid", $error_array)) ? "" : "hidden"; ?>">
                                        <?php
                                        if (in_array("Error email already registered", $error_array)) {
                                            echo "Error email already registered";
                                        } else if (in_array("Error your email is invalid", $error_array)) {
                                            echo "Error your email is invalid";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>User Image</label>
                                    <input style="display: inline; padding-left: 3px;" type="file" name="image">
                                    <?php echo (in_array("Sorry, only JPG, JPEG, PNG & GIF files are allowed.", $error_array)) ? "<font color='red'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</font>" : ''; ?>                                </div>

                                <div class="form-group">
                                    <input name="save_user_data" type="submit" class="btn btn-primary" value="Save Data">
                                </div>
                            </form>
                            <hr>
                        </div>
                        <!-- /.box-footer-->
                    </div>
            </section>
        </div>
        <!-- /.content-wrapper -->
        <?php include './includes/footer.php'; ?>
