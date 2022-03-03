<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Purple Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../assets/vendors/css/vendor.bundle.base.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.1/toastr.min.css" rel="stylesheet" media="all">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/custom/custom.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="../../assets/images/favicon.ico" />
</head>
<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
            <div class="row flex-grow">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left p-5">
                        <div class="brand-logo">
                            <h1 id="logo">ADAM</h1>
                        </div>
                        <h4>Admin Sign In</h4>
                        <form class="pt-3" method="post" id="login_form" action="{{url('/auth/login')}}">
                            <div class="form-group">
                                <input type="email" name="data[email]" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="UserEmail">
                            </div>
                            <div class="form-group">
                                <input type="password" name="data[password]" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
                            </div>

                            <div class="mt-3 text-center">
                                    <a class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" href="javascript:Login.actionLogin()">SIGN IN</a>
                            </div>
                            <div class="mt-3 text-center">
                                <a class="font-weight-medium auth-form-btn" href="javascript:Login.recoverPassword()">Recover Password</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.1/toastr.min.js"></script>
<!-- endinject -->
<!-- inject:js -->
<script src="../../assets/js/off-canvas.js"></script>
<script src="../../assets/js/hoverable-collapse.js"></script>
{{--<script src="../../assets/js/misc.js"></script>--}}
<script src="../../assets/custom/login.js"></script>

<!-- endinject -->
</body>
</html>
