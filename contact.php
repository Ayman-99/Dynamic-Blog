<?php
include './includes/head.php';

if (isset($_POST['send_message'])) {
    $name = validation_input($_POST['name']);
    $email = validation_input($_POST['email']); //Last name
    $subject = isset($_POST['subject']) ? validation_input($_POST['subject']) : "NONE";
    $user_message = validation_input($_POST['message']);


    $transport = new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls');
    $transport->setUsername(isset($_COOKIE['em_add']) ? $_COOKIE['em_add'] : "");
    $transport->setPassword(isset($_COOKIE['em_pass']) ? $_COOKIE['em_pass'] : "");

    $mailer = new Swift_Mailer($transport);

    $message = new Swift_Message('Communication request!');
    $message->setFrom(['work000test@gmail.com' => 'Ayman Blog']);
    $message->setContentType("text/html");
    $message->setTo("aymanhun@gmail.com"); //change to localhost
    $message->setBody("Hello, I want you to contact me details:<br>"
            . "Name: $name<br>"
            . "Email: $email<br>"
            . "Subject: $subject<br>"
            . "Message: $user_message"
    );

    if ($mailer->send($message)) {
        ?>
        <script>alert("Message has been sent!");</script>
        <?php
    } else {
        ?>
        <script>alert("Error!");</script>
        <?php
    }
}
?>

<body>

    <div id="wrapper">

        <?php include './includes/header.php'; ?>

        <div class="page-title lb single-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <h2><i class="fa fa-envelope-open-o bg-orange"></i> Contact us <small class="hidden-xs-down hidden-sm-down">Interested to write and publish your articles here? contact me!</small></h2>
                    </div><!-- end col -->
                    <div class="col-lg-4 col-md-4 col-sm-12 hidden-xs-down hidden-sm-down">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Contact</li>
                        </ol>
                    </div><!-- end col -->                    
                </div><!-- end row -->
            </div><!-- end container -->
        </div><!-- end page-title -->

        <section class="section wb">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-wrapper">
                            <div class="row">
                                <div class="col-lg-5">
                                    <h4>About blog</h4>
                                    <p>This blog is a personal blog for technology, education and anything related to science.</p>

                                    <h4>How we help?</h4>
                                    <p>Publishing interesting articles and increasing users knowledge.</p>

                                    <h4>Want to join us?</h4>
                                    <p>Anyone can join me and start writing or adding his favorite articles.</p>
                                </div>
                                <div class="col-lg-7">
                                    <div id="myElem" class="alert alert-success" style="display: none;">
                                        <strong>Success!</strong> Message has been sent .
                                    </div>
                                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="form-wrapper">
                                        <input name="name" type="text" class="form-control" placeholder="Your name" required="">
                                        <input name="email" type="email" class="form-control" placeholder="Email address" required="">
                                        <input name="subject" type="text" class="form-control" placeholder="Subject">
                                        <textarea name="message" class="form-control" placeholder="Your message" required=""></textarea>
                                        <button type="submit" name="send_message" class="btn btn-primary">Send <i class="fa fa-envelope-open-o"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div><!-- end page-wrapper -->
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end container -->
        </section>

        <?php include './includes/footer.php'; ?>
