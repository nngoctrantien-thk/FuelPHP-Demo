<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title><?= isset($title) ? $title : 'Admin Panel'; ?></title>

    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/css/lineicons.css" />
    <link rel="stylesheet" href="/assets/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="/assets/css/fullcalendar.css" />
    <link rel="stylesheet" href="/assets/css/main.css" />
    <link href="/assets/css/custom.css" rel="stylesheet">
</head>

<body>

    <!-- ======== sidebar-nav start =========== -->
    <aside class="sidebar-nav-wrapper">

        <div class="navbar-logo">
            <a href="/admin">
                <?= Asset::img('logo/logo.svg', ['alt' => 'logo']); ?>
            </a>
        </div>

        <nav class="sidebar-nav">

            <ul>

                <li class="nav-item">
                    <a href="/admin">
                        <span class="icon">
                            <i class="lni lni-dashboard"></i>
                        </span>

                        <span class="text">
                            Dashboard
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/admin/books">
                        <span class="icon">
                            <i class="lni lni-book"></i>
                        </span>

                        <span class="text">
                            Books
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/admin/authors">
                        <span class="icon">
                            <i class="lni lni-pencil-alt"></i>
                        </span>

                        <span class="text">
                            Authors
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/admin/categories">
                        <span class="icon">
                            <i class="lni lni-grid-alt"></i>
                        </span>

                        <span class="text">
                            Categories
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/admin/borrows">
                        <span class="icon">
                            <i class="lni lni-agenda"></i>
                        </span>

                        <span class="text">
                            Borrows
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a onclick="window.location.href='<?php echo Uri::create('auth/logout'); ?>'">
                        <span class="icon">
                            <i class="lni lni-exit"></i>
                        </span>

                        <span class="text">
                            Logout
                        </span>
                    </a>
                </li>

            </ul>

        </nav>

    </aside>

    <div class="overlay"></div>
    <!-- ======== sidebar-nav end =========== -->

    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">

        <!-- ======== header start ======== -->
        <header class="header">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-lg-6">
                        <div class="header-left">

                            <div class="menu-toggle-btn mr-15">
                                <button id="menu-toggle" class="main-btn primary-btn btn-hover">
                                    <i class="lni lni-chevron-left me-2"></i> Menu
                                </button>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-6">

                        <div class="header-right">

                            <div class="profile-box ml-15">

                                <div class="profile-info">

                                    <div class="info">

                                        <div>
                                            <h6 class="fw-500">
                                                <?= \Auth::get_screen_name(); ?>
                                            </h6>

                                            <p>Admin</p>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </header>
        <!-- ======== header end ======== -->

        <!-- ======== content start ======== -->

        <section class="section">

            <div class="container-fluid">

                <?= $content; ?>

            </div>

        </section>

        <!-- ======== content end ======== -->

    </main>

    <!-- JS -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/main.js"></script>

</body>

</html>