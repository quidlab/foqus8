<?php
include __DIR__ . "/../layouts/meta.php";
?>

<body class=" hold-transition dark-mode login-page">
    <div>
        <!-- <nav class="main-header navbar navbar-expand navbar-dark text-center"> -->

        <!--	 </nav> -->
    </div>
    <div>
        <h3 class="text-center"><? echo $company_name[0]['Company_Name'] ?></h3>
        <h3 class="text-center"><? echo $company_name[0]['Meeting_Place'] ?><h3>
    </div>
    <div class="login-box ">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h1><b>FoQus </b>Admin</h1>
            </div>
            <div class="card-body">
                <?
                foreach (errors() as $key => $value) {
                    echo '<p style="color:red">' . $key . $value . '</p>';
                } ?>
                <form action="/auth/otp" method="post">
                    <input style="display: none;" type="text" name="verifying-email" value="<?= session('verifying-email') ?>">
                    <section>
                        <p><?= __('otp-page-text', ['ref' => session('ref')]) ?></p>
                        <label for="">OTP</label>
                        <input class="form-control" type="text" name="otp">
                    </section>

                    <button type="submit" name="submit" class="mt-4 btn btn-primary btn-block"><?= __('submit') ?></button>

                </form>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <div>
        <!--BANK-->
        <div class="col-12 text-center">
            <p>©<?php echo date('Y'); ?> <? echo getenv("REGION_NAME");  ?></p>
        </div>
        <div class="col-12 text-center">
            <a style="color:black;" href="<?= constant('MC_Privacy_Policy_URL') ?>" target="blank">
                <?= __('privacy-text')  ?>
            </a>
        </div>
        <div class="col-12 text-center">
            <a style="color:black;" href="<?= constant('MC_Security_Policy_URL') ?>" target="blank"><!-- TODo crete constants sigletone -->
                <?= __('information-text') ?>
            </a>
        </div>
    </div>
    </div>
    <!-- Main Footer -->
    <footer class="main-footer" style="margin-left:0;padding:5px;">
        Copyright &copy; <a href="https://quidlab.com">Quidlab FoQus</a>.
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.0.0
        </div>
    </footer>

    </div>

    <?php include  __DIR__ . "/../layouts/scripts.php"; ?>

    <script>
        $('#eye-slash').fadeOut(0);

        $('#eye').on('click', function() {
            $('#password').attr('type', 'text');
            $('#eye-slash').fadeIn(0);
            $('#eye').fadeOut(0);
        })
        $('#eye-slash').on('click', function() {
            $('#password').attr('type', 'password');
            $('#eye-slash').fadeOut(0);
            $('#eye').fadeIn(0);
        })
    </script>

    <script>
        function changeLanguage(lang) {
            // Replace "lang" cookie with new language
            document.cookie = "lang=" + lang;
            // Get html of current URI and replace page contents.
            $("body").load(window.location.href);
        }

        function ShowError(msg) {
            toastr.error(msg);
        }

        function ShowSuccess(msg) {
            toastr.success(msg);
        }
        // Call this to switch to German, for example

        function getCookie(lang) {
            var match = document.cookie.match(new RegExp('(^| )' + lang + '=([^;]+)'));
            if (match) return match[2];
        }
    </script>
    <?
    foreach (errors() as $error) {
        echo
        '<script>
            ShowError("' . __($error) . '");
        </script>';
    }
    ?>
</body>

</html>