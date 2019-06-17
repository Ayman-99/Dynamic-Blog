<?php
include './includes/head.php';
?>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <?php include './includes/header.php'; ?>
        <?php
        include './includes/side-nav.php';
        $user_id = $user_nickname = $user_email = $user_pass = $user_account_status = $user_role = "";
        $success = "";
        //no check if email exists validation. Can make function in the db, Pass need to be encrypted
        $error_array = array();
        if (isset($_POST['save_user_data'])) {
            $flag1 = $flag2 = false; //$flag2 one for pass, flag 1 for img
            $sql = "";
            $user_nickname = validation_input($_POST['nickname']);
            $user_email = validation_input($_POST['email']);
            $user_id = validation_input($_POST['id']);

            if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
                array_push($error_array, "Error your email is invalid");
            } else if ($loggedIn->getUserEmail() !== $user_email) {
                //Check if email is for the acc owner or not
                if (emailExists($user_email)) {
                    array_push($error_array, "Error email already registered");
                }
            }
            if ($_FILES['image']['error'] !== 4) {
                $profile_img = $_FILES['image']['name'];
                $profile_image_temp = $_FILES['image']['tmp_name'];
                $error_array = valdiate_upload($profile_img, $profile_image_temp, "../../images/profile/$profile_img");
                $profile_img = "../../images/profile/$profile_img";
                $flag1 = true;
            }
            if ($loggedIn->getUserPassowrd() !== $_POST['pass']) {
                if (strlen($_POST['pass']) < 8 || strlen($_POST['pass']) > 22) {
                    array_push($error_array, "Error password must be between 8 and 22");
                } else {
                    $pass = validation_input($_POST['pass']);
                    $user_pass = md5($pass);
                    $flag2 = true;
                }
            }
            if ($flag1 && $flag2) {
                $sql = "UPDATE `users` SET `user_image`='$profile_img',`user_password`='$user_pass',`user_email`='$user_email', user_nickname='$user_nickname' WHERE user_id='$user_id'";
            } else if ($flag1) {
                $sql = "UPDATE `users` SET `user_image`='$profile_img',`user_email`='$user_email',user_nickname='$user_nickname' WHERE user_id='$user_id'";
            } else if ($flag2) {
                $sql = "UPDATE `users` SET `user_password`='$user_pass',`user_email`='$user_email', user_nickname='$user_nickname' WHERE user_id='$user_id'";
            } else {
                $sql = "UPDATE `users` SET `user_email`='$user_email', user_nickname='$user_nickname' WHERE user_id='$user_id'";
            }

            if (empty($error_array)) {
                confirmQuery(mysqli_query($con, $sql));
                //as new info updated we update current object if its mod or dev we make new moderator class else Person
                $_SESSION['username'] = $user_nickname;
                echo "<meta http-equiv='refresh' content='0'>";
                $success = "Updated";
            }
        }
        ?>
        <style>
            .marginLeft{
                margin-left: 18%;
                color: red;
            }
        </style>
        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    User Profile
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Profile</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-3">

                        <!-- Profile Image -->
                        <div class="box box-primary">
                            <div class="box-body box-profile">
                                <img class="profile-user-img img-responsive img-circle" src="<?php echo $loggedIn->getUserImage(); ?>" alt="Profile">

                                <h3 class="profile-username text-center"><?php echo $loggedIn->getUserNickname(); ?></h3>

                                <p class="text-muted text-center"><?php echo $loggedIn->getUserRole(); ?></p>

                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li><a href="#settings" data-toggle="tab">Settings</a></li>
                            </ul>
                            <div class="tab-pane" id="settings">
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="form-horizontal" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">ID</label>
                                        <div class="col-sm-10">
                                            <input name='id' type="text" class="form-control" id="userName" placeholder="Enter Nickname" value="<?php echo $loggedIn->getUserId(); ?>" readonly="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Nickname</label>
                                        <div class="col-sm-10">
                                            <input name='nickname' type="text" class="form-control" id="userName" placeholder="Enter Nickname" value="<?php echo $loggedIn->getUserNickname(); ?>" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Password</label>
                                        <div class="col-sm-10">
                                            <input name='pass' type="password" class="form-control" id="passWord" placeholder="Enter Password" value="<?php echo $loggedIn->getUserPassowrd(); ?>" required="">
                                        </div>
                                        <div class="marginLeft  <?php echo (in_array("Error password must be between 8 and 22", $error_array)) ? "" : "hidden"; ?>">
                                            <?php
                                            if (in_array("Error password must be between 8 and 22", $error_array)) {
                                                echo "Error password must be between 8 and 22";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Email</label>
                                        <div class="col-sm-10">
                                            <input name='email' type="email" class="form-control" id="email" placeholder="Enter Email" value="<?php echo $loggedIn->getUserEmail(); ?>" required="">
                                        </div>
                                        <div class="marginLeft  <?php echo (in_array("Error email already registered", $error_array) || in_array("Error your email is invalid", $error_array)) ? "" : "hidden"; ?>">
                                            <?php
                                            if (in_array("Error email already registered", $error_array)) {
                                                echo "Error email already registered";
                                            } else if (in_array("Error your email is invalid")) {
                                                echo "Error your email is invalid";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-left: 10%;">
                                        <label>Profile Picture</label>
                                        <input style="display: inline; padding-left: 3px;" type="file" name="image">
                                        <?php echo (in_array("Sorry, only JPG, JPEG, PNG & GIF files are allowed.", $error_array)) ? "<font color='red'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</font>" : ''; ?>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-10" style="margin-left: 17%;">
                                            <input name="save_user_data" type="submit" class="btn btn-primary" value="Save Data">
                                        </div>
                                    </div>
                                    <p class='marginLeft'><?php echo $success; ?></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <?php
        include './includes/footer.php';
        ?>













































































































































































































































