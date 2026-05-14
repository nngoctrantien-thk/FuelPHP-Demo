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
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
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
                            <?php if (\Auth::check()): ?>

                                <li class="nav-item">

                                    <a class="nav-link"
                                        href="/user/borrows">

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

    <footer class="bg-white py-5 border-top border-dark border-3 mt-5">
        <div class="container">
            <div class="row g-4">

                <div class="col-lg-4 col-md-6">
                    <h3 class="fw-bold text-black mb-3">LIBRARY MS.</h3>
                    <p class="text-black fw-bold pe-lg-5">
                        A modern library management system built for speed, efficiency, and ease of use. Explore thousands of titles and manage your borrows in one place.
                    </p>
                    <div class="d-flex gap-2 mt-4">
                        <a href="#" class="social-box">FB</a>
                        <a href="#" class="social-box">IG</a>
                        <a href="#" class="social-box">TW</a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h5 class="fw-bold text-black mb-3">Quick Links</h5>
                    <ul class="list-unstyled fw-bold text-black footer-links">
                        <li class="mb-2"><a href="/user/books">Catalog</a></li>
                        <li class="mb-2"><a href="/user/borrowed">My Borrows</a></li>
                        <li class="mb-2"><a href="#">Profile</a></li>
                        <li class="mb-2"><a href="#">Terms & Conditions</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="fw-bold text-black mb-3">Support</h5>
                    <ul class="list-unstyled fw-bold text-black">
                        <li class="mb-2">
                            <i class="lni lni-map-marker me-2"></i>123 Library Street, Hanoi
                        </li>
                        <li class="mb-2">
                            <i class="lni lni-envelope me-2"></i>support@library.com
                        </li>
                        <li class="mb-2">
                            <i class="lni lni-phone me-2"></i>+84 987 654 321
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="border-dark border-2 my-5">

            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 text-black fw-bold fs-5">
                        © <?= date('Y'); ?> LIBRARY MANAGEMENT SYSTEM. ALL RIGHTS RESERVED.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <span class="text-black fw-bold">POWERED BY FUELPHP & BOOTSTRAP</span>
                </div>
            </div>
        </div>
    </footer>

    <style>
        footer a {
            color: #000 !important;
            text-decoration: none;
            transition: all 0.2s;
        }

        footer a:hover {
            text-decoration: underline;
            color: #333 !important;
        }

        .social-box {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #000;
            background: #fff;
            font-weight: 900;
            transition: all 0.1s;
        }

        .social-box:hover {
            background: #000;
            color: #fff !important;
            transform: translate(-3px, -3px);
            box-shadow: 4px 4px 0px #000;
            text-decoration: none !important;
        }

        footer .form-control:focus {
            box-shadow: none;
            background-color: #f8f9fa;
        }

        footer .form-control::placeholder {
            color: #000;
            font-weight: bold;
        }

        .text-black {
            color: #000 !important;
        }

        .fw-bold {
            font-weight: 700 !important;
        }
    </style>

    <!-- ================= JS ================= -->
    <script src="/assets/js/jquery-1.11.0.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/plugins.js"></script>
    <script src="/assets/js/script.js"></script>
</body>

</html>