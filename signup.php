<?php
ob_start(); session_start();
if (isset($_SESSION['USER_LOGIN'])) header("Location: dashboard");
?>
<!doctype html>
<html class="fixed">
<head>
    <meta charset="UTF-8">
    <meta name="keywords" content="LearNigeria Assessment Dashboard" />
    <meta name="description" content="Client Admin - LearNigeria Assessment Dashboard Template">
    <meta name="author" content="learnigeria.org">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon" />
    <link rel="apple-touch-icon" href="img/apple-touch-icon.png">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="vendor/animate/animate.compat.css">
    <link rel="stylesheet" href="vendor/font-awesome/css/all.min.css" />
    <link rel="stylesheet" href="vendor/boxicons/css/boxicons.min.css" />
    <link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.css" />
    <link rel="stylesheet" href="vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />
    <link rel="stylesheet" href="vendor/pnotify/pnotify.custom.css" />
    <link rel="stylesheet" href="vendor/jquery-confirm/jquery-confirm.min.css" />
    <link rel="stylesheet" href="css/theme.css" />
    <link rel="stylesheet" href="css/skins/default.css" />
    <link rel="stylesheet" href="css/custom.css">
    <script src="vendor/modernizr/modernizr.js"></script>
</head>
<body>
<section class="body-sign">
    <div class="center-sign">
        <a href="./" class="logo float-left"><img src="img/logo.png" height="70" alt="Porto Admin" /></a>
        <div class="panel card-sign">
            <div class="card-title-sign mt-3 text-end">
                <h2 class="title text-uppercase font-weight-bold m-0"><i class="bx bx-user-circle me-1 text-6 position-relative top-5"></i> Sign Up</h2>
            </div>
            <div class="card-body">
                <form name="create_client" id="create_client">
                    <div class="form-group mb-3">
                        <label>Client Full Name</label>
                        <input name="client_fullname" type="text" class="form-control" />
                    </div>
                    <div class="form-group mb-3">
                        <label>Organisation Name</label>
                        <input name="organisation_name" type="text" class="form-control" />
                    </div>
                    <div class="form-group mb-3">
                        <label>Client Email</label>
                        <input name="client_email" type="text" class="form-control" />
                    </div>
                    <div class="form-group mb-3">
                        <label>Client Phone No</label>
                        <input name="client_mobile" type="text" class="form-control" maxlength="11" />
                    </div>
                    <div class="form-group mb-0">
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label>Password</label>
                                <input name="client_pwd" type="password" class="form-control" />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label>Password Confirmation</label>
                                <input name="pwd_confirm" type="password" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="checkbox-custom checkbox-default">
                                <input id="AgreeTerms" name="agreeterms" type="checkbox">
                                <label for="AgreeTerms">I agree with <a href="#">terms of use</a></label>
                            </div>
                        </div>
                        <div class="col-sm-5 text-end">
                            <input type="submit" class="btn btn-primary mt-2 px-3" value="Sign Up" />
                        </div>
                    </div>
                    <span class="mt-3 mb-3 line-thru text-center text-uppercase"><span>or</span></span>
                    <p class="text-center">Already have an account? <a href="./">Sign In!</a></p>
                </form>
            </div>
        </div>
        <p class="text-center text-muted mt-3 mb-3">&copy; Copyright 2021. All Rights Reserved.</p>
    </div>
</section>
<script src="vendor/jquery/jquery.js"></script>
<script src="vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
<script src="vendor/popper/umd/popper.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="vendor/common/common.js"></script>
<script src="vendor/nanoscroller/nanoscroller.js"></script>
<script src="vendor/magnific-popup/jquery.magnific-popup.js"></script>
<script src="vendor/jquery-placeholder/jquery.placeholder.js"></script>
<script src="vendor/pnotify/pnotify.custom.js"></script>
<script src="vendor/jquery-confirm/jquery-confirm.min.js"></script>
<script src="vendor/jquery-validation/jquery.validate.js"></script>
<script src="js/theme.js"></script>
<script src="js/custom.js"></script>
<script src="js/theme.init.js"></script>
<script src="js/serialObject.js"></script>
<script src="js/views/view.assessment.js"></script>

</body>
</html>