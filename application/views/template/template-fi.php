<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>CusPOS</title>

    <!-- manifest meta -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="manifest" href="manifest.json" />

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="<?php echo base_url() ?>/assets-fi/img/favicon180.png" sizes="180x180">
    <link rel="icon" href="<?php echo base_url() ?>/assets-fi/img/favicon32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="<?php echo base_url() ?>/assets-fi/img/favicon16.png" sizes="16x16" type="image/png">

    <!-- Google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- swiper carousel css -->
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets-fi/vendor/swiperjs-6.6.2/swiper-bundle.min.css">

    <!-- style css for this template -->
    <link href="<?php echo base_url() ?>/assets-fi/css/style.css" rel="stylesheet" id="style">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/bower_components/select2/dist/css/select2.min.css">
</head>
<?php
if($this->session->userdata['username'] == NULL ){
    redirect('auth/login');
}

?>
<body class="body-scroll" data-page="index">

    <!-- loader section -->
    <div class="container-fluid loader-wrap">
        <div class="row h-100">
            <div class="col-10 col-md-6 col-lg-5 col-xl-3 mx-auto text-center align-self-center">
                <div class="loader-cube-wrap loader-cube-animate mx-auto">
                    <img src="<?php echo base_url() ?>/assets-fi/img/logo.png" alt="Logo">
                </div>
                <p class="mt-4">It's time for track budget<br><strong>Please wait...</strong></p>
            </div>
        </div>
    </div>

    <!-- loader section ends -->

    <!-- Sidebar main menu -->
    <div class="sidebar-wrap  sidebar-pushcontent">
        <!-- Add overlay or fullmenu instead overlay -->
        <div class="closemenu text-muted">Close Menu</div>
        <div class="sidebar dark-bg">
            <!-- user information -->
            <div class="row my-3">
                <div class="col-12 ">
                    <div class="card shadow-sm bg-opac text-white border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <figure class="avatar avatar-44 rounded-15">
                                        <img src="<?php echo base_url() ?>/assets-fi/img/user1.jpg" alt="">
                                    </figure>
                                </div>
                                <div class="col px-0 align-self-center">
                                    <p class="mb-1"><?php echo $this->session->userdata['username']; ?></p>
                                    <p class="text-muted size-12">Manager</p>
                                </div>
                                <div class="col-auto">
                                    <!-- <button class="btn btn-44 btn-light">
                                        <i class="bi bi-box-arrow-right"></i>
                                    </button> -->
                                </div>
                            </div>
                        </div>
                        <div class="card bg-opac text-white border-0">
                            <div class="card-body">
                                <!-- <div class="row">
                                    <div class="col-12">
                                        <h1 class="display-4">100.00</h1>
                                    </div>
                                    <div class="col-auto">
                                        <p class="text-muted">Wallet Balance</p>
                                    </div>
                                    <div class="col text-end">
                                        <p class="text-muted"><a href="addmoney.html" >+ Top up</a>
                                        </p>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- user emnu navigation -->
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?php echo base_url() ?>index.php/Apps">
                                <div class="avatar avatar-40 rounded icon"><i class="bi bi-house-door"></i></div>
                                <div class="col">Halaman</div>
                                <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                            </a>
                        </li>

<!--                         <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                                aria-expanded="false">
                                <div class="avatar avatar-40 rounded icon"><i class="bi bi-person"></i></div>
                                <div class="col">Account</div>
                                <div class="arrow"><i class="bi bi-plus plus"></i> <i class="bi bi-dash minus"></i>
                                </div>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item nav-link" href="profile.html">
                                        <div class="avatar avatar-40 rounded icon"><i class="bi bi-calendar2"></i></div>
                                        <div class="col">Profile</div>
                                        <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                                    </a></li>
                                <li><a class="dropdown-item nav-link" href="settings.html">
                                        <div class="avatar avatar-40 rounded icon"><i class="bi bi-calendar-check"></i>
                                        </div>
                                        <div class="col">Settings</div>
                                        <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                                    </a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="chat.html" tabindex="-1">
                                <div class="avatar avatar-40 rounded icon"><i class="bi bi-chat-text"></i></div>
                                <div class="col">Messages</div>
                                <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="notifications.html" tabindex="-1">
                                <div class="avatar avatar-40 rounded icon"><i class="bi bi-bell"></i></div>
                                <div class="col">Notification</div>
                                <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="blog.html" tabindex="-1">
                                <div class="avatar avatar-40 rounded icon"><i class="bi bi-newspaper"></i></div>
                                <div class="col">Blogs</div>
                                <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="style.html" tabindex="-1">
                                <div class="avatar avatar-40 rounded icon"><i class="bi bi-palette"></i></div>
                                <div class="col">Style <i class="bi bi-star-fill text-warning small"></i></div>
                                <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="pages.html" tabindex="-1">
                                <div class="avatar avatar-40 rounded icon"><i class="bi bi-file-earmark-text"></i></div>
                                <div class="col">Pages <span class="badge bg-info fw-light">new</span></div>
                                <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                            </a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url() ?>index.php/apps/lihat_customer" tabindex="-1">
                                <div class="avatar avatar-40 rounded icon"><i class="bi bi-people"></i></div>
                                <div class="col">Customer</div>
                                <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                            </a>
                        </li> 
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url() ?>index.php/apps/index_stok" tabindex="-1">
                                <div class="avatar avatar-40 rounded icon"><i class="bi bi-archive"></i></div>
                                <div class="col">Stok</div>
                                <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                            </a>
                        </li>                       
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url() ?>index.php/apps/index_transaksi" tabindex="-1">
                                <div class="avatar avatar-40 rounded icon"><i class="bi bi-receipt"></i></div>
                                <div class="col">Transaksi</div>
                                <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url() ?>index.php/auth/logout" tabindex="-1">
                                <div class="avatar avatar-40 rounded icon"><i class="bi bi-box-arrow-right"></i></div>
                                <div class="col">Logout</div>
                                <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Sidebar main menu ends -->

    <!-- Begin page -->
    <main class="h-100">

        <!-- Header -->
        <header class="header position-fixed">
            <div class="row">
                <div class="col-auto">
                    <a href="javascript:void(0)" target="_self" class="btn btn-light btn-44 menu-btn">
                        <i class="bi bi-list"></i>
                    </a>
                </div>
                <div class="col align-self-center text-center">
                    <div class="logo-small">
                        <img src="assets/img/logo.png" alt="">
                        <h5>CusPos</h5>
                    </div>
                </div>
                <div class="col-auto">
                    <!-- <a href="notifications.html" target="_self" class="btn btn-light btn-44">
                        <i class="bi bi-bell"></i>
                        <span class="count-indicator"></span>
                    </a> -->
                </div>
            </div>
        </header>
        <!-- Header ends -->

        <!-- main page content -->
        <div class="main-container container">
            <!-- welcome user -->
            <?php echo $contents ?>

        </div>
        <!-- main page content ends -->


    </main>
    <!-- Page ends-->

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <ul class="nav nav-pills nav-justified">
<!--                 <li class="nav-item">
                    <a class="nav-link active" href="index.html">
                        <span>
                            <i class="nav-icon bi bi-house"></i>
                            <span class="nav-text">Home</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="stats.html">
                        <span>
                            <i class="nav-icon bi bi-laptop"></i>
                            <span class="nav-text">Statistics</span>
                        </span>
                    </a>
                </li> -->
                <li class="nav-item centerbutton">
                    <div class="nav-link">
                        <span class="theme-radial-gradient">
                            <i class="close bi bi-x"></i>
                            <img src="<?php echo base_url() ?>/assets-fi/img/centerbutton.svg" class="nav-icon" alt="" />
                        </span>
                        <div class="nav-menu-popover justify-content-between">
                            <a href="<?php echo base_url() ?>index.php/apps/post_customer" class="btn btn-lg btn-icon-text">
                                <i class="bi bi-person-plus-fill size-32"></i><span>Customer Baru</span>
                            </a>
                            <a href="<?php echo base_url() ?>index.php/apps/penjualan_stok" class="btn btn-lg btn-icon-text">
                                <i class="bi bi-receipt size-32"></i><span>Penjualan</span>
                            </a>
<!-- 
                            <a href="<?php echo base_url() ?>index.php/apps/post_penjualan" class="btn btn-lg btn-icon-text">
                                <i class="bi bi-receipt size-32"></i><span>Penjualan</span>
                            </a> -->
                        </div>
                    </div>
                </li>
<!--                 <li class="nav-item">
                    <a class="nav-link" href="rewards.html">
                        <span>
                            <i class="nav-icon bi bi-gift"></i>
                            <span class="nav-text">Rewards</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="wallet.html">
                        <span>
                            <i class="nav-icon bi bi-wallet2"></i>
                            <span class="nav-text">Wallet</span>
                        </span>
                    </a>
                </li> -->
            </ul>
        </div>
    </footer>
    <!-- Footer ends-->

    <!-- PWA app install toast message -->
<!--     <div class="position-fixed bottom-0 start-50 translate-middle-x  z-index-10">
        <div class="toast mb-3" role="alert" aria-live="assertive" aria-atomic="true" id="toastinstall"
            data-bs-animation="true">
            <div class="toast-header">
                <img src="assets/img/favicon32.png" class="rounded me-2" alt="...">
                <strong class="me-auto">Install PWA App</strong>
                <small>now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <div class="row">
                    <div class="col">
                        Click "Install" to install PWA app & experience indepedent.
                    </div>
                    <div class="col-auto align-self-center ps-0">
                        <button class="btn-default btn btn-sm" id="addtohome">Install</button>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Required jquery and libraries -->
    <script src="<?php echo base_url() ?>assets-fi/js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo base_url() ?>assets-fi/js/popper.min.js"></script>
    <script src="<?php echo base_url() ?>assets-fi/vendor/bootstrap-5/js/bootstrap.bundle.min.js"></script>

    <!-- cookie js -->
    <script src="<?php echo base_url() ?>assets-fi/js/jquery.cookie.js"></script>

    <!-- Customized jquery file  -->
    <script src="<?php echo base_url() ?>assets-fi/js/main.js"></script>
    <script src="<?php echo base_url() ?>assets-fi/js/color-scheme.js"></script>

    <!-- PWA app service registration and works -->
    <script src="<?php echo base_url() ?>assets-fi/js/pwa-services.js"></script>

    <!-- Chart js script -->
    <script src="<?php echo base_url() ?>assets-fi/vendor/chart-js-3.3.1/chart.min.js"></script>

    <!-- Progress circle js script -->
    <script src="<?php echo base_url() ?>assets-fi/vendor/progressbar-js/progressbar.min.js"></script>

    <!-- swiper js script -->
    <script src="<?php echo base_url() ?>assets-fi/vendor/swiperjs-6.6.2/swiper-bundle.min.js"></script>

    <!-- page level custom script -->
    <script src="<?php echo base_url() ?>assets-fi/js/app.js"></script>
    <script src="<?php echo base_url() ?>assets/bower_components/select2/dist/js/select2.min.js"></script>
    <script>
         base_domain = '<?= site_url(); ?>';
        $(document).ready(function() {
            $(".select22").select2({
                placeholder: "Please Select"
            });
        });
    </script>

</body>

</html>