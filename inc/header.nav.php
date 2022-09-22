<?php
ob_start();session_start();
include_once('./api/classes/Client.class.php');
?>
<!doctype html>
<html class="fixed has-top-menu">
<head>
    <meta charset="UTF-8">
    <title>LearNigeria Assessment Dashboard</title>
    <meta name="keywords" content="LearNigeria Assessment Dashboard" />
    <meta name="description" content="Client Admin - LearNigeria Assessment Dashboard Template">
    <meta name="author" content="learnigeria.org">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <base href="http://localhost/learnigeria_assessment/">
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon" />
    <link rel="apple-touch-icon" href="img/apple-touch-icon.png">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="vendor/animate/animate.compat.css">
    <link rel="stylesheet" href="vendor/font-awesome/css/all.min.css" />
    <link rel="stylesheet" href="vendor/boxicons/css/boxicons.min.css" />
    <link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.css" />
    <link rel="stylesheet" href="vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />
    <link rel="stylesheet" href="vendor/jquery-ui/jquery-ui.css" />
    <link rel="stylesheet" href="vendor/jquery-ui/jquery-ui.theme.css" />
    <link rel="stylesheet" href="vendor/pnotify/pnotify.custom.css" />
    <link rel="stylesheet" href="vendor/jquery-confirm/jquery-confirm.min.css" />
    <link rel="stylesheet" href="vendor/datatables/media/css/dataTables.bootstrap5.css" />
    <link rel="stylesheet" href="vendor/bootstrap-multiselect/css/bootstrap-multiselect.css" />
    <link rel="stylesheet" href="vendor/morris/morris.css" />
    <link rel="stylesheet" href="css/theme.css" />
    <link rel="stylesheet" href="css/skins/default.css" />
    <link rel="stylesheet" href="css/custom.css">
    <script src="vendor/modernizr/modernizr.js"></script>
</head>
<body>
<section class="body">
    <header class="header header-nav-menu header-nav-top-line">
        <div class="logo-container">
            <a href="./" class="logo"><img src="img/logo.png" width="75" height="35" alt="LearNigeria Assessment Admin" /></a>
            <button class="btn header-btn-collapse-nav d-lg-none" data-bs-toggle="collapse" data-bs-target=".header-nav">
                <i class="fas fa-bars"></i>
            </button>
            <div class="header-nav collapse">
                <div class="header-nav-main header-nav-main-effect-1 header-nav-main-sub-effect-1 header-nav-main-square">
                    <nav>
                        <ul class="nav nav-pills" id="mainNav">
                            <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'dashboard.php')  echo 'active'; ?>"><a class="nav-link" href="dashboard">Dashboard</a></li>
                            <li class="dropdown <?php if(basename($_SERVER['PHP_SELF']) == 'assessment-results.php')  echo 'active'; ?>">
                                <a class="nav-link dropdown-toggle" href="javascript:void(0)">Assessment Results</a>
                                <ul class="dropdown-menu">
                                    <li><a class="nav-link" href="assessment-results">view</a></li>
                                </ul>
                            </li>
                            <?php if ($_SESSION['USER_LOGIN']['user_type']=='client'){?>
                            <li class="dropdown" <?php if(basename($_SERVER['PHP_SELF']) == 'add-assessor.php' ||
                                basename($_SERVER['PHP_SELF']) == 'list-assessor.php')  echo 'active'; ?>>
                                <a class="nav-link dropdown-toggle" href="javascript:void(0)">Assessor</a>
                                <ul class="dropdown-menu">
                                    <li><a class="nav-link" href="add-assessor">Add</a></li>
                                    <li><a class="nav-link" href="list-assessor">List</a></li>
                                </ul>
                            </li>
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="header-right">
            <span class="separator"></span>
            <div id="userbox" class="userbox">
                <a href="#" data-bs-toggle="dropdown">
                    <figure class="profile-picture">
                        <img src="img/!logged-user.jpg" alt="Joseph Doe" class="rounded-circle" data-lock-picture="img/!logged-user.jpg" />
                    </figure>
                    <div class="profile-info" data-lock-name="<?=$_SESSION['USER_LOGIN']['user_name'];?>"
                         data-lock-email="<?=$_SESSION['USER_LOGIN']['user_email'];?>">
                        <span class="name"><?=$_SESSION['USER_LOGIN']['user_name'];?> (<?=$_SESSION['USER_LOGIN']['user_type'];?>)</span>
                        <span class="role"><?=$_SESSION['USER_LOGIN']['user_email'];?></span>
                    </div>
                    <i class="fa custom-caret"></i>
                </a>
                <div class="dropdown-menu">
                    <ul class="list-unstyled">
                        <li class="divider"></li>
                        <li><a role="menuitem" tabindex="-1" href="profile-settings"><i class="bx bx-user-circle"></i> My Profile</a></li>
                        <li><a role="menuitem" tabindex="-1" href="logout"><i class="bx bx-power-off"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <div class="inner-wrapper">
