<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
    content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>Kaswargi</title>
    <meta name="description" content="Buku kas warga kita.">
    <meta name="keywords"
    content="Buku, Kas, Warga, RT, RW, Iuran, IPL, Pembukuan, Akuntansi" />
    <link rel="icon" type="image/png" href="<?php echo base_url() ?>/assets-p/assets/img/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url() ?>/assets-p/assets/img/icon/192x192.png">
    <script src="<?php echo base_url() ?>assets-fi/js/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets-p/assets/css/style.css">
    <link rel="manifest" href="<?php echo base_url() ?>/assets-p/__manifest.json">


    <script src="<?php echo base_url() ?>/assets-p/assets/js/plugins/apexcharts/apexcharts.min.js"></script>
<!-- Base Js File -->
<script src="<?php echo base_url() ?>/assets-p/assets/js/base.js"></script>
</head>
<?php
    $hk = 'hidden';
    if (isset($_SESSION['username'])) {
       $hk = "";
    }
?>
<body>

    <!-- loader -->
<!--     <div id="loader">
        <img src="<?php echo base_url() ?>/assets-p/assets/img/loading-icon.png" alt="icon" class="loading-icon">
    </div> -->
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="#" class="headerButton" data-bs-toggle="modal" data-bs-target="#sidebarPanel" <?= $hk ?>
            >
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle" data-bs-toggle="modal" data-bs-target="#DialogIconedSuccess">
            Kaswargi
            <!-- <img src="assets/img/logo.png" alt="logo" class="logo"> -->
        </div>
        <div class="right">
            <a href="#" onclick="copyLink()" class="headerButton" <?= $hk ?>>
                <ion-icon class="icon" name="copy"></ion-icon>
            </a>
            <a href="#" class="headerButton" hidden>
                <img src="<?php echo base_url() ?>/assets-p/assets/img/sample/avatar/avatar1.jpg" alt="image" class="imaged w32">
                <span class="badge badge-danger"></span>
            </a>
        </div>
    </div>
        <div class="modal fade dialogbox" id="DialogIconedSuccess" data-bs-backdrop="static" tabindex="-1"
            role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-icon text-success">
                        <ion-icon name="checkmark-circle"></ion-icon>
                    </div>
                    <div class="modal-header">
                        <h5 class="modal-title">Kaswargi.</h5>
                    </div>
                    <div class="modal-body">
                        v1.0.0 | GPR_E8/11
                    </div>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <a href="#" class="btn" data-bs-dismiss="modal">OK</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- * App Header -->


    <!-- App Capsule -->
    <div id="appCapsule">


        <?php echo $contents ?>
        <div class="modal fade panelbox panelbox-left" id="sidebarPanel" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <!-- profile box -->
                        <div class="profileBox pt-2 pb-2">
                            <div class="image-wrapper">
                                <img src="<?php echo base_url() ?>/assets-p/assets/img/sample/avatar/105.png" alt="image" class="imaged  w36">

                            </div>
                            <div class="in">
                                <strong><?= $_SESSION['username'] ?></strong>
                                <div class="text-muted"><?= $_SESSION['org_code'] ?></div>
                            </div>
                            <a href="#" class="btn btn-link btn-icon sidebar-close" data-bs-dismiss="modal">
                                <ion-icon name="close-outline"></ion-icon>
                            </a>
                        </div>
                        <!-- * profile box -->
                        <!-- balance -->
<!--                     <div class="sidebar-balance">
                        <div class="listview-title">Balance</div>
                        <div class="in">
                            <h1 class="amount">$ 2,562.50</h1>
                        </div>
                    </div> -->
                    <!-- * balance -->

                    <!-- action group -->
                    <div class="action-group">
<!--                         <a href="<?php echo base_url() ?>Buku/create" class="action-button">
                            <div class="in">
                                <div class="iconbox">
                                    <ion-icon name="add-outline"></ion-icon>
                                </div>
                                Input
                            </div>
                        </a> -->
<!--                         <a href="index.html" class="action-button">
                            <div class="in">
                                <div class="iconbox">
                                    <ion-icon name="arrow-down-outline"></ion-icon>
                                </div>
                                Withdraw
                            </div>
                        </a>
                        <a href="index.html" class="action-button">
                            <div class="in">
                                <div class="iconbox">
                                    <ion-icon name="arrow-forward-outline"></ion-icon>
                                </div>
                                Send
                            </div>
                        </a>
                        <a href="app-cards.html" class="action-button">
                            <div class="in">
                                <div class="iconbox">
                                    <ion-icon name="card-outline"></ion-icon>
                                </div>
                                My Cards
                            </div>
                        </a> -->
                    </div>
                    <!-- * action group -->

                    <!-- menu -->
                    <div class="listview-title mt-1">Menu</div>
                    <ul class="listview flush transparent no-line image-listview">
                        <li>
                            <a href="<?php echo base_url() ?>Apps" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="pie-chart-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Beranda
                                    <!-- <span class="badge badge-primary">10</span> -->
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() ?>Buku" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="document-text-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Pembukuan
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() ?>Warga" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="people-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Warga
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() ?>Iuran" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="card-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    E-iuran
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() ?>Komponen" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="apps"></ion-icon>
                                </div>
                                <div class="in">
                                    Komp. Iuran
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() ?>News" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="images"></ion-icon>
                                </div>
                                <div class="in">
                                    Galeri Kabar
                                </div>
                            </a>
                        </li>
<!--                         <li>
                            <a href="app-components.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="apps-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Components
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="app-cards.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="card-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    My Cards
                                </div>
                            </a>
                        </li> -->
                    </ul>
                    <!-- * menu -->

                    <!-- others -->
                    <div class="listview-title mt-1">Lainnya</div>
                    <ul class="listview flush transparent no-line image-listview">
<!--                         <li>
                            <a href="app-settings.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="settings-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Settings
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="component-messages.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="chatbubble-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Support
                                </div>
                            </a>
                        </li> -->
                        <li>
                            <a href="<?php echo base_url() ?>Operator/pass_form" class="item">
                                <div class="icon-box bg-warning">
                                    <ion-icon name="key-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Ganti Password
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() ?>Auth/logout" class="item">
                                <div class="icon-box bg-danger">
                                    <ion-icon name="log-out-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Keluar
                                </div>
                            </a>
                        </li>


                    </ul>
                    <!-- * others -->

                    <!-- send money -->
<!--                     <div class="listview-title mt-1">Send Money</div>
                    <ul class="listview image-listview flush transparent no-line">
                        <li>
                            <a href="#" class="item">
                                <img src="assets/img/sample/avatar/avatar2.jpg" alt="image" class="image">
                                <div class="in">
                                    <div>Artem Sazonov</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="item">
                                <img src="assets/img/sample/avatar/avatar4.jpg" alt="image" class="image">
                                <div class="in">
                                    <div>Sophie Asveld</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="item">
                                <img src="assets/img/sample/avatar/avatar3.jpg" alt="image" class="image">
                                <div class="in">
                                    <div>Kobus van de Vegte</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                -->                    <!-- * send money -->

            </div>
        </div>
    </div>
</div>
<!-- * App Sidebar -->

</div>
<!-- * App Capsule -->


<!-- App Bottom Menu -->
<!--     <div class="appBottomMenu">
        <a href="Apps" class="item active">
            <div class="col">
                <ion-icon name="pie-chart-outline"></ion-icon>
                <strong>Beranda</strong>
            </div>
        </a>
        <a href="app-pages.html" class="item">
            <div class="col">
                <ion-icon name="document-text-outline"></ion-icon>
                <strong>Pages</strong>
            </div>
        </a>
        <a href="app-components.html" class="item">
            <div class="col">
                <ion-icon name="apps-outline"></ion-icon>
                <strong>Components</strong>
            </div>
        </a>
        <a href="app-cards.html" class="item">
            <div class="col">
                <ion-icon name="card-outline"></ion-icon>
                <strong>My Cards</strong>
            </div>
        </a>
        <a href="app-settings.html" class="item">
            <div class="col">
                <ion-icon name="settings-outline"></ion-icon>
                <strong>Settings</strong>
            </div>
        </a>
    </div> -->
    <!-- * App Bottom Menu -->

    <!-- App Sidebar -->
    <div class="modal fade panelbox panelbox-left" id="sidebarPanel" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <!-- profile box -->
                    <div class="profileBox pt-2 pb-2">
                        <div class="image-wrapper">
                            <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="imaged  w36">
                        </div>
                        <div class="in">
                            <strong>Sebastian Doe</strong>
                            <div class="text-muted">4029209</div>
                        </div>
                        <a href="#" class="btn btn-link btn-icon sidebar-close" data-bs-dismiss="modal">
                            <ion-icon name="close-outline"></ion-icon>
                        </a>
                    </div>
                    <!-- * profile box -->
                    <!-- balance -->
                    <div class="sidebar-balance">
                        <div class="listview-title">Balance</div>
                        <div class="in">
                            <h1 class="amount">$ 2,562.50</h1>
                        </div>
                    </div>
                    <!-- * balance -->

                    <!-- action group -->
                    <div class="action-group">
                        <a href="index.html" class="action-button">
                            <div class="in">
                                <div class="iconbox">
                                    <ion-icon name="add-outline"></ion-icon>
                                </div>
                                Deposit
                            </div>
                        </a>
                        <a href="index.html" class="action-button">
                            <div class="in">
                                <div class="iconbox">
                                    <ion-icon name="arrow-down-outline"></ion-icon>
                                </div>
                                Withdraw
                            </div>
                        </a>
                        <a href="index.html" class="action-button">
                            <div class="in">
                                <div class="iconbox">
                                    <ion-icon name="arrow-forward-outline"></ion-icon>
                                </div>
                                Send
                            </div>
                        </a>
                        <a href="app-cards.html" class="action-button">
                            <div class="in">
                                <div class="iconbox">
                                    <ion-icon name="card-outline"></ion-icon>
                                </div>
                                My Cards
                            </div>
                        </a>
                    </div>
                    <!-- * action group -->

                    <!-- menu -->
                    <div class="listview-title mt-1">Menu</div>
                    <ul class="listview flush transparent no-line image-listview">
                        <li>
                            <a href="index.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="pie-chart-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Overview
                                    <span class="badge badge-primary">10</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="app-pages.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="document-text-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Pages
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="app-components.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="apps-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Components
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="app-cards.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="card-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    My Cards
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- * menu -->

                    <!-- others -->
                    <div class="listview-title mt-1">Others</div>
                    <ul class="listview flush transparent no-line image-listview">
                        <li>
                            <a href="app-settings.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="settings-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Settings
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="component-messages.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="chatbubble-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Support
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="app-login.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="log-out-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Log out
                                </div>
                            </a>
                        </li>


                    </ul>
                    <!-- * others -->

                    <!-- send money -->
                    <div class="listview-title mt-1">Send Money</div>
                    <ul class="listview image-listview flush transparent no-line">
                        <li>
                            <a href="#" class="item">
                                <img src="assets/img/sample/avatar/avatar2.jpg" alt="image" class="image">
                                <div class="in">
                                    <div>Artem Sazonov</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="item">
                                <img src="assets/img/sample/avatar/avatar4.jpg" alt="image" class="image">
                                <div class="in">
                                    <div>Sophie Asveld</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="item">
                                <img src="assets/img/sample/avatar/avatar3.jpg" alt="image" class="image">
                                <div class="in">
                                    <div>Kobus van de Vegte</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- * send money -->

                </div>
            </div>
        </div>
    </div>
    <!-- * App Sidebar -->



    <!-- iOS Add to Home Action Sheet -->
    <div class="modal inset fade action-sheet ios-add-to-home" id="ios-add-to-home-screen" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add to Home Screen</h5>
                    <a href="#" class="close-button" data-bs-dismiss="modal">
                        <ion-icon name="close"></ion-icon>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="action-sheet-content text-center">
                        <div class="mb-1"><img src="assets/img/icon/192x192.png" alt="image" class="imaged w64 mb-2">
                        </div>
                        <div>
                            Install <strong>Kaswargi</strong> on your iPhone's home screen.
                        </div>
                        <div>
                            Tap <ion-icon name="share-outline"></ion-icon> and Add to homescreen.
                        </div>
                        <div class="mt-2">
                            <button class="btn btn-primary btn-block" data-bs-dismiss="modal">CLOSE</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- * iOS Add to Home Action Sheet -->


    <!-- Android Add to Home Action Sheet -->
    <div class="modal inset fade action-sheet android-add-to-home" id="android-add-to-home-screen" tabindex="-1"
    role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add to Home Screen</h5>
                <a href="#" class="close-button" data-bs-dismiss="modal">
                    <ion-icon name="close"></ion-icon>
                </a>
            </div>
            <div class="modal-body">
                <div class="action-sheet-content text-center">
                    <div class="mb-1">
                        <img src="assets/img/icon/192x192.png" alt="image" class="imaged w64 mb-2">
                    </div>
                    <div>
                        Install <strong>Kaswargi</strong> on your Android's home screen.
                    </div>
                    <div>
                        Tap <ion-icon name="ellipsis-vertical"></ion-icon> and Add to homescreen.
                    </div>
                    <div class="mt-2">
                        <button class="btn btn-primary btn-block" data-bs-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- * Android Add to Home Action Sheet -->



<div id="cookiesbox" class="offcanvas offcanvas-bottom cookies-box" tabindex="-1" data-bs-scroll="true"
data-bs-backdrop="false">
<div class="offcanvas-header">
    <h5 class="offcanvas-title">We use cookies</h5>
</div>
<div class="offcanvas-body">
    <div>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla non lacinia quam. Nulla facilisi.
        <a href="#" class="text-secondary"><u>Learn more</u></a>
    </div>
    <div class="buttons">
        <a href="#" class="btn btn-primary btn-block" data-bs-dismiss="offcanvas">I understand</a>
    </div>
</div>
</div>

<!-- ========= JS Files =========  -->

<!-- Bootstrap -->
<script src="<?php echo base_url() ?>/assets-p/assets/js/lib/bootstrap.bundle.min.js"></script>
<!-- Ionicons -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<!-- Splide -->
<script src="<?php echo base_url() ?>/assets-p/assets/js/plugins/splide/splide.min.js"></script>


<script>
        // Add to Home with 2 seconds delay.
        AddtoHome("2000", "once");

        function copyLink(){
              navigator.clipboard.writeText("<?= base_url() ?>Review/only/<?= $_SESSION['org_code']?>");
            alert("Siap di Share: " + "<?= base_url() ?>Review/only/<?= $_SESSION['org_code']?>");
        }
</script>

</body>

</html>