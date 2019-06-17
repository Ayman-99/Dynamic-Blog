<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <?php
        $current = basename($_SERVER['PHP_SELF']);
        ?>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="active treeview menu-open">
            <li>
                <a href="../../index.php">
                    <i class="fa fa-dashboard"></i> <span>Back to website</span>
                </a>
            </li>
            <li class="<?php echo ($current == "dashboard.php") ? 'active' : '' ?>">
                <a href="dashboard.php">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <?php
            if (is_Admin($loggedIn->getUserNickname())) {
                ?>
                <li class="<?php echo ($current == "users.php") ? 'active' : '' ?>">
                    <a href="users.php">
                        <i class="fa fa-circle-o"></i> <span>Users</span>
                    </a>
                </li>
                <?php
            }
            ?>
            <li class="<?php echo ($current == "categories.php") ? 'active' : '' ?>">
                <a href="categories.php">
                    <i class="fa fa-circle-o"></i> <span>Categories</span>
                </a>
            </li>
            <li class="<?php echo ($current == "posts.php") ? 'active' : '' ?>">
                <a href="posts.php">
                    <i class="fa fa-circle-o"></i> <span>Posts</span>
                </a>
            </li>
            <li class="<?php echo ($current == "comments.php") ? 'active' : '' ?>">
                <a href="comments.php">
                    <i class="fa fa-circle-o"></i> <span>Comments</span>
                </a>
            </li>
            <li class="<?php echo ($current == "profile.php") ? 'active' : '' ?>">
                <a href="profile.php">
                    <i class="fa fa-circle-o"></i> <span>Profile</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
