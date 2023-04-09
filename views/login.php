<?php
include "layouts/meta.php";
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
    <?= isset($_SESSION['messagesBag']) ? $_SESSION['messagesBag'][0] : '' ?>
    <div class="login-box ">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h1><b>FoQus </b>Admin</h1>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form action="/admin/login" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="User Name" required="required" name="loginID">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" required="required" name="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <ul class="navbar-nav ">
                                <li class="nav-item dropdown">
                                    <a class="nav-link" data-toggle="dropdown" href="#">
                                        <!--  <i class="flag-icon flag-icon-us"></i> -->
                                        <i class="fas fa-language fa-2x"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right p-0">
                                        <?= $languagesHTML ?>

                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" name="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
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
        <div class="col-12 text-center"><a style="color:black;" href="https://quidlab.com/img/Privacy_policy.pdf" target="blank">นโยบายความเป็นส่วนตัว นโยบายการคุ้มครองข้อมูลและเงื่อนไขการใช้งานของระบบ <br>Quidlab Privacy Policy, Data Protection Policy & Terms of use </a></div>
        <div class="col-12 text-center"><a style="color:black;" href="https://quidlab.com/img/security_policy.pdf" target="blank">นโยบายความปลอดภัยของข้อมูล Quidlab <br>Quidlab Information Security Management Policy</a></div>
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

    <?php include "layouts/scripts.php"; ?>


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
</body>

</html>