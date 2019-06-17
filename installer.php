<?php
session_start();

$flag = 0;
$db_schema_sucess = $db_create_success = "";
if (isset($_POST['confirm'])) {
    $db_host = $_POST['db_host'];
    $db_user = $_POST['db_user'];
    $db_pass = $_POST['db_pass'];
    $db_name = $_POST['db_name'];

    setcookie("db_name", $_POST['db_name'], time() + (10 * 365 * 24 * 60 * 60));
    setcookie("db_user", $_POST['db_user'], time() + (10 * 365 * 24 * 60 * 60));
    setcookie("db_pass", $_POST['db_pass'], time() + (10 * 365 * 24 * 60 * 60));
    setcookie("db_host", $_POST['db_host'], time() + (10 * 365 * 24 * 60 * 60));
    setcookie("em_add", $_POST['email_address'], time() + (10 * 365 * 24 * 60 * 60));
    setcookie("em_pass", $_POST['email_pass'], time() + (10 * 365 * 24 * 60 * 60));

    $con = mysqli_connect($db_host, $db_user, $db_pass);
    if (!$con) {
        $db_con_error = "Failed to connect: " . mysqli_connect_error($con);
        die($db_con_error);
    } else {
        $flag = 1;
    }

    if ($flag == 1) {
        if (!mysqli_query($con, "create database " . $db_name)) {
            $db_create_error = "Failed to create the db " . mysqli_error($con);
        } else {
            $con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
            $db_create_success = "Database has been created successfully";
        }

        $sql = "CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_status` enum('Show','Hidden') DEFAULT 'Hidden'
) ;

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `comment_author` varchar(255) NOT NULL,
  `comment_content` text NOT NULL,
  `comment_image` text,
  `comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comment_post` int(11) NOT NULL
) ;

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `post_author` varchar(255) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_content` text NOT NULL,
  `post_date` date DEFAULT NULL,
  `post_views` int(11) DEFAULT '0',
  `post_image` text,
  `post_tags` text,
  `post_category` varchar(255) DEFAULT NULL,
  `post_added_by` varchar(255) DEFAULT NULL
) ;

CREATE TABLE `post_details` (
`post_id` int(11)
,`post_author` varchar(255)
,`post_title` varchar(255)
,`post_content` text
,`post_date` date
,`post_views` int(11)
,`post_image` text
,`post_tags` text
,`post_category` varchar(255)
,`post_added_by` varchar(255)
,`category_id` int(11)
,`category_name` varchar(255)
,`category_status` enum('Show','Hidden')
);

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_nickname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_image` text NOT NULL,
  `user_account_status` enum('Active','Inactive') DEFAULT NULL,
  `user_role` enum('Admin','Moderator','User') DEFAULT NULL,
  `user_session` text
) ;

INSERT INTO `users` (`user_id`, `user_nickname`, `user_email`, `user_password`, `user_image`, `user_account_status`, `user_role`, `user_session`) VALUES
(1, 'Root', 'root@gmail.com', '63a9f0ea7bb98050796b649e85481845', '../../images/profile/guest.png', 'Active', 'Admin', 'na');


DROP TABLE IF EXISTS `post_details`;

CREATE VIEW `post_details`  AS  select `posts`.`post_id` AS `post_id`,`posts`.`post_author` AS `post_author`,`posts`.`post_title` AS `post_title`,`posts`.`post_content` AS `post_content`,`posts`.`post_date` AS `post_date`,`posts`.`post_views` AS `post_views`,`posts`.`post_image` AS `post_image`,`posts`.`post_tags` AS `post_tags`,`posts`.`post_category` AS `post_category`,`posts`.`post_added_by` AS `post_added_by`,`categories`.`category_id` AS `category_id`,`categories`.`category_name` AS `category_name`,`categories`.`category_status` AS `category_status` from (`posts` join `categories` on((`posts`.`post_category` = `categories`.`category_name`))) ;

ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment_post` (`comment_post`);

ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `post_category` (`post_category`),
  ADD KEY `post_added_by` (`post_added_by`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_nickname` (`user_nickname`),
  ADD UNIQUE KEY `user_email` (`user_email`);

ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`comment_post`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`post_category`) REFERENCES `categories` (`category_name`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`post_added_by`) REFERENCES `users` (`user_nickname`) ON DELETE SET NULL ON UPDATE CASCADE;
";
        if (!mysqli_multi_query($con, $sql)) {
            $db_schema_error = "Database objects have not been created successfully , " . mysqli_error($con);
        } else {
            $db_schema_sucess = "Database schema has been created successfully";
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>SkyFall</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <style>
            body{ 
                margin-top:40px; 
            }

            .stepwizard-step p {
                margin-top: 10px;
            }

            .stepwizard-row {
                display: table-row;
            }

            .stepwizard {
                display: table;
                width: 100%;
                position: relative;
            }

            .stepwizard-step button[disabled] {
                opacity: 1 !important;
                filter: alpha(opacity=100) !important;
            }

            .stepwizard-row:before {
                top: 14px;
                bottom: 0;
                position: absolute;
                content: " ";
                width: 100%;
                height: 1px;
                background-color: #ccc;
                z-order: 0;

            }

            .stepwizard-step {
                display: table-cell;
                text-align: center;
                position: relative;
            }

            .btn-circle {
                width: 30px;
                height: 30px;
                text-align: center;
                padding: 6px 0;
                font-size: 12px;
                line-height: 1.428571429;
                border-radius: 15px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="stepwizard">
                <div class="stepwizard-row setup-panel">
                    <div class="stepwizard-step">
                        <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
                        <p>Step 1</p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                        <p>Step 2</p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                        <p>Step 3</p>
                    </div>
                </div>
            </div>
            <form method="POST" action="installer.php">
                <div class="row setup-content" id="step-1">
                    <div class="col-xs-12">
                        <div class="col-md-12">
                            <h3> Step 1 (Database information)</h3>
                            <div class="form-group">
                                <label class="control-label">Database Host</label>
                                <input id="db_host" name='db_host'  maxlength="100" type="text" required="required" class="form-control" placeholder="Enter DB Host"  />
                            </div>
                            <div class="form-group">
                                <label class="control-label">Database Username</label>
                                <input id="db_user" name='db_user' maxlength="100" type="text" required="required" class="form-control" placeholder="Enter DB username" />
                            </div>
                            <div class="form-group">
                                <label class="control-label">Database Password</label>
                                <input id="db_pass" name='db_pass' maxlength="100" type="text" class="form-control" placeholder="Enter DB password (leave blank if username don't have password)" />
                            </div>
                            <div class="form-group">
                                <label class="control-label">Database Name</label>
                                <input id="db_name" name='db_name' maxlength="100" type="text" required="required" class="form-control" placeholder="Enter DB name" />
                            </div>
                            <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                        </div>
                    </div>
                </div>
                <div class="row setup-content" id="step-2">
                    <div class="col-xs-12">
                        <div class="col-md-12">
                            <h3> Step 2 (Email information `OPTIONAL`)</h3>
                            <h6>Gmail emails used by default. This email can be used to send emails to clients and help them in recovery their password<br>
                                you can add it later on by editing "contact.php"</h6>
                            <div class="form-group">
                                <label class="control-label">Email address</label>
                                <input id="em_address" name='email_address' maxlength="200" type="email" class="form-control" placeholder="Enter Email" />
                            </div>
                            <div class="form-group">
                                <label class="control-label">Email password</label>
                                <input id="em_pass" name='email_pass' maxlength="200" type="password" class="form-control" placeholder="Enter Password"  />
                            </div>
                            <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                        </div>
                    </div>
                </div>
                <div class="row setup-content" id="step-3">
                    <div class="col-xs-12">
                        <div class="col-md-12">
                            <h3> Step 3 (Confirmation)</h3>
                            <input name='confirm' class="btn-success btn-lg pull-left" type="submit" value='Finish!'>
                        </div>
                    </div>
                </div>
            </form>
            <?php
            if ($flag == 1) {
                ?>
                <div class="col-md-12">
                    <h3> Notes</h3>
                    <ul>
                        <?php echo isset($db_con_error) ? "<li style='color: red'>$db_con_error</li>" : ""; ?>
                        <?php echo isset($db_create_error) ? "<li style='color: red'>$db_create_error</li>" : ""; ?>
                        <?php echo isset($db_schema_error) ? "<li style='color: red'>$db_schema_error</li>" : ""; ?>
                        <li style="color: green"><?php echo $db_create_success; ?></li>
                        <li style="color: green"><?php echo $db_schema_sucess; ?></li>
                        <li>Default account details:<br> Email : root@gmail.com  <br> password : root</li>
                        <br>
                        <li>If you want to change database connection, check db.php files. By default the data you entered are stored in cookies... <a id="home-page" href="index.php">Website home page</a></li>
                    </ul>

                </div>
                <?php
            }
            ?>
        </div>
    </body>
</html>
<script>
    $(document).ready(function () {

        $('#home-page').click(function (e) {
            $.get("installer.php?remove=1", function (data) {
                //Do something
            });
        });

        var navListItems = $('div.setup-panel div a'),
                allWells = $('.setup-content'),
                allNextBtn = $('.nextBtn');

        allWells.hide();

        navListItems.click(function (e) {
            e.preventDefault();
            var $target = $($(this).attr('href')),
                    $item = $(this);

            if (!$item.hasClass('disabled')) {
                navListItems.removeClass('btn-primary').addClass('btn-default');
                $item.addClass('btn-primary');
                allWells.hide();
                $target.show();
                $target.find('input:eq(0)').focus();
            }
        });

        allNextBtn.click(function () {
            var curStep = $(this).closest(".setup-content"),
                    curStepBtn = curStep.attr("id"),
                    nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                    curInputs = curStep.find("input[type='text'],input[type='url']"),
                    isValid = true;

            $(".form-group").removeClass("has-error");
            for (var i = 0; i < curInputs.length; i++) {
                if (!curInputs[i].validity.valid) {
                    isValid = false;
                    $(curInputs[i]).closest(".form-group").addClass("has-error");
                }
            }

            if (isValid)
                nextStepWizard.removeAttr('disabled').trigger('click');
        });

        $('div.setup-panel div a.btn-primary').trigger('click');
    });
</script>
<?php
if (isset($_GET['remove'])) {
    unlink("installer.php");
}
?>
