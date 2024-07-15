<?= $this->include('layout/navbar'); ?>
<?= $this->renderSection('content'); ?>



<!-- footer -->
<footer>
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <ul class="sociel">
                        <li><a href="https://www.facebook.com/KemenkopmkRI"><i class="fa fa-facebook-f"></i></a></li>
                        <li><a href="https://x.com/kemenkopmk"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="https://www.instagram.com/kemenko_pmk"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="https://www.youtube.com/channel/UCS_4jzQs7bywNQrJ-AmoWVg/channels"><i class="fa fa-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                    <div class="contact">
                        <h3>conatct us</h3>
                        <span>123 Second Street Fifth Avenue,<br>
                            Manhattan, New York<br>
                            +987 654 3210</span>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                    <div class="contact">
                        <h3>ADDITIONAL LINKS</h3>
                        <ul class="lik">
                            <li><a href="#">About us</a></li>
                            <li><a href="#">Terms and conditions</a></li>
                            <li><a href="#">Privacy policy</a></li>
                            <li><a href="#">News</a></li>
                            <li><a href="#">Contact us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                    <div class="contact">
                        <h3>service</h3>
                        <ul class="lik">
                            <li><a href="#"> Data recovery</a></li>
                            <li><a href="#">Computer repair</a></li>
                            <li><a href="#">Mobile service</a></li>
                            <li><a href="#">Network solutions</a></li>
                            <li><a href="#">Technical support</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                    <div class="contact">
                        <h3>About lighten</h3>
                        <span>Tincidunt elit magnis nulla facilisis. Dolor Sapien nunc amet ultrices,</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright">
            <p>Copyright 2019 All Right Reserved By <a href="https://html.design/">Free html Templates</a> Distributed By <a href="https://themewagon.com">ThemeWagon</a></p>
        </div>
    </div>
</footer>
<!-- end footer -->
<!-- Javascript files-->
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery-3.0.0.min.js"></script>
<script src="js/plugin.js"></script>
<script src="js/popup.js"></script>
<!-- sidebar -->
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="js/custom.js"></script>
<script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
<script>
    $(document).ready(function() {
        $(".fancybox").fancybox({
            openEffect: "none",
            closeEffect: "none"
        });

        $(".zoom").hover(function() {
            $(this).addClass('transition');
        }, function() {
            $(this).removeClass('transition');
        });
    });
</script>
</body>

</html>



<?= $this->renderSection('content'); ?>

<!-- loader -->
<div class="loader_bg">
    <div class="loader"><img src="images/loading.gif" alt="#" /></div>
</div>
<!-- end loader -->



<?= $this->renderSection('content'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ... kode lainnya ... -->
    <link rel="stylesheet" href="<?= base_url('public/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('public/css/style.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('public/css/responsive.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('public/css/jquery.mCustomScrollbar.min.css'); ?>">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>

<body class="main-layout">
    <?= $this->renderSection('content'); ?>

    <script src="<?= base_url('public/js/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('public/js/popper.min.js'); ?>"></script>
    <script src="<?= base_url('public/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= base_url('public/js/jquery-3.0.0.min.js'); ?>"></script>
    <script src="<?= base_url('public/js/plugin.js'); ?>"></script>
    <script src="<?= base_url('public/js/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>
    <script src="<?= base_url('public/js/custom.js'); ?>"></script>
    <script src="<?= base_url('public/js/popup.js'); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
</body>

</html>

<?= $this->renderSection('content'); ?>