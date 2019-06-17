<header class="main-header">
    <!-- Logo -->
    <a href="dashboard.php" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>C</b>P</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg" style="font-family: serif"><b>Control</b> Panel </span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav  class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li>
                    <a href="logout.php">
                        LOG OUT
                    </a>
                </li>
                <li class="user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo $loggedIn->getUserImage(); ?>" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?php echo $loggedIn->getUserNickname(); ?></span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

</header>




























