<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        <?= isset($title) ? $title : 'Library Management'; ?>
    </title>

    <!-- ================= CSS ================= -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet"
        href="/assets/css/bootstrap.min.css">

    <link rel="stylesheet"
        href="/assets/css/style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
</head>

<body>

    <!-- ================= HEADER ================= -->

    <header id="header-wrap">

        <!-- TOP HEADER -->

        <div class="top-content border-bottom py-2">

            <div class="container">

                <div class="row align-items-center">

                    <!-- SOCIAL -->

                    <div class="col-md-6">

                        <div class="social-links">

                            <ul class="list-inline mb-0">

                                <li class="list-inline-item">

          

                                </li>

                                <li class="list-inline-item">


                                </li>

                            </ul>

                        </div>

                    </div>

                    <!-- USER MENU -->

                    <div class="col-md-6 text-end">

                        <?php if (\Auth::check()): ?>

                            <span class="me-3">

                                Welcome,
                                <strong>
                                    <?= \Auth::get_screen_name(); ?>
                                </strong>

                            </span>

                            <a 
                                class="btn btn-sm btn-dark" onclick="window.location.href='<?php echo Uri::create('auth/logout'); ?>';">

                                Logout

                            </a>

                        <?php else: ?>

                            <a href="/auth/login"
                                class="btn btn-sm btn-outline-dark">

                                Login

                            </a>

                            <a href="/auth/register"
                                class="btn btn-sm btn-dark ms-2">

                                Register

                            </a>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>

        <!-- ================= NAVBAR ================= -->

        <div class="main-header py-3">

            <div class="container">

                <div class="d-flex
                        justify-content-between
                        align-items-center">

                    <!-- LOGO -->

                    <div class="logo">

                        <a href="/user">

                            <?= Asset::img(
                                'main-logo.png',
                                array(
                                    'alt'   => 'Library Logo',
                                    'style' => 'height:60px'
                                )
                            ); ?>

                        </a>

                    </div>

                    <!-- MENU -->

                    <nav>

                        <ul class="nav">

                            <li class="nav-item">

                                <a class="nav-link"
                                    href="/user">

                                    Home

                                </a>

                            </li>

                            <li class="nav-item">

                                <a class="nav-link"
                                    href="/user/books">

                                    Books

                                </a>

                            </li>

                            <li class="nav-item">

                                <a class="nav-link"
                                    href="/user/categories">

                                    Categories

                                </a>

                            </li>

                            <?php if (\Auth::check()): ?>

                                <li class="nav-item">

                                    <a class="nav-link"
                                        href="/user/borrow-history">

                                        Borrow History

                                    </a>

                                </li>

                            <?php endif; ?>

                        </ul>

                    </nav>

                </div>

            </div>

        </div>

    </header>

    <!-- ================= FLASH MESSAGE ================= -->

    <div class="container mt-3">

        <?php if (\Session::get_flash('success')): ?>

            <div class="alert alert-success">

                <?= \Session::get_flash('success'); ?>

            </div>

        <?php endif; ?>

        <?php if (\Session::get_flash('error')): ?>

            <div class="alert alert-danger">

                <?= \Session::get_flash('error'); ?>

            </div>

        <?php endif; ?>

    </div>

    <!-- ================= MAIN CONTENT ================= -->

    <main>

        <?= $content; ?>

    </main>

    <!-- ================= FOOTER ================= -->

    <footer class="bg-light py-4 mt-5">

        <div class="container text-center">

            <p class="mb-0">

                © <?= date('Y'); ?>
                Library Management System

            </p>

        </div>

    </footer>

    <!-- ================= JS ================= -->
    <script src="/assets/js/jquery-1.11.0.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/plugins.js"></script>
    <script src="/assets/js/script.js"></script>

</body>

</html>