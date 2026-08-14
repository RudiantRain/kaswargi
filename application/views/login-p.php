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
    <meta name="description" content="Buku Kas Warga Kita">
    <meta name="keywords" content="Pembukuan, Kas, RT, Warga, Iuran, IPL" />
    <link rel="icon" type="image/png" href="<?php echo base_url() ?>/assets-p/assets/img/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url() ?>/assets-p/assets/img/icon/192x192.png">
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets-p/assets/css/style.css">
    <link rel="manifest" href="__manifest.json">
</head>

<body>

    <!-- loader -->
    <div id="loader">
        <img src="<?php echo base_url() ?>/assets-p/assets/img/loading-icon.png" alt="icon" class="loading-icon">
    </div>
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader no-border transparent position-absolute">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle"></div>
        <div class="right">
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">

        <div class="section mt-2 mb-2 text-center">
            <h1>Kaswargi</h1>
            <h4>Masuk</h4>
            <br>
            <img src="<?php echo base_url() ?>assets-p/assets/img/Audit-amico.png" alt="image" class="imaged w-75 square text-center">

        </div>

        <div class="section mb-5 p-2">

                <?php
                echo form_open('auth/login', array('style' => 'text-align:center;'));
                ?>
                <?php 
                $error = $this->session->flashdata('message_name');
                ?>
                <p align="center" class="text-danger"><?php echo $error; ?></p>
                <div class="card">
                    <div class="card-body pb-1">
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="email1">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="username anda">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="password1">Password</label>
                                <input type="password" class="form-control" name="password" id="password" autocomplete="off"
                                    placeholder="password anda">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-links mt-2">
           <!--          <div>
                        <a href="app-register.html">Register Now</a>
                    </div> -->
                    <!-- <div><a href="#" class="text-muted">Lupa Password?</a></div> -->
                </div>

                <div class="form-button-group  transparent">
                    <button type="submit" name="submit" class="btn btn-primary btn-block btn-lg">Masuk</button>
                </div>
                <?php
                echo form_close();
                ?>

        </div>

    </div>
    <!-- * App Capsule -->



    <!-- ========= JS Files =========  -->
    <!-- Bootstrap -->
    <script src="<?php echo base_url() ?>/assets-p/assets/js/lib/bootstrap.bundle.min.js"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- Splide -->
    <script src="<?php echo base_url() ?>/assets-p/assets/js/plugins/splide/splide.min.js"></script>
    <!-- Base Js File -->
    <script src="<?php echo base_url() ?>/assets-p/assets/js/base.js"></script>


</body>

</html>