<?php include_once("inc/header.nav.php"); if (!isset($_SESSION['USER_LOGIN'])) header("Location: ./"); ?>
<?php
$res = $client->get_user_by_id($_SESSION['USER_LOGIN']['user_id']);
if ($res->num_rows > 0) {
while ($row = $res->fetch_assoc()) {
?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Profile Settings</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="dashboard"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Settings</span></li>
            </ol>
            <span class="sidebar-right-toggle">&nbsp;</span>
        </div>
    </header>
    <div class="row">
        <div class="col-lg-4 col-xl-3 mb-4 mb-xl-0">
            <section class="card">
                <div class="card-body">
                    <div class="thumb-info mb-3">
                        <img src="img/!logged-user.jpg" class="rounded img-fluid" alt="John Doe">
                        <div class="thumb-info-title">
                            <span class="thumb-info-inner"><?=$_SESSION['USER_LOGIN']['user_name'];?></span>
                            <span class="thumb-info-type"><?=$_SESSION['USER_LOGIN']['user_type'];?></span>
                        </div>
                    </div>
                    <div class="widget-toggle-expand mb-3">
                        <div class="widget-header">
                            <h5 class="mb-2 font-weight-semibold text-dark">Profile Completion</h5>
                            <div class="widget-toggle">+</div>
                        </div>
                        <div class="widget-content-collapsed">
                            <div class="progress progress-xs light">
                                <div class="progress-bar" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100" style="width: 95%;">
                                    95%
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="dotted short">
                </div>
            </section>
        </div>
        <div class="col-lg-8 col-xl-6">
            <div class="tabs">
                <ul class="nav nav-tabs tabs-primary">
                    <li class="nav-item active">
                        <button class="nav-link" data-bs-target="#overview" data-bs-toggle="tab">General Information</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-target="#edit" data-bs-toggle="tab">Password Settings</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="overview" class="tab-pane active">
                        <form name="update_personal_info" id="update_personal_info" class="p-3">
                            <h4 class="mb-3 font-weight-semibold text-dark">Personal Settings</h4>
                            <div id="response-alert"></div>
                            <div class="row row mb-4">
                                <div class="form-group col">
                                    <label for="">Full Name</label>
                                    <input type="text" class="form-control" name="user_name" value="<?=$row['user_name'];?>">
                                </div>
                            </div>
                            <div class="row row mb-4">
                                <div class="form-group col">
                                    <label for="">User Email</label>
                                    <input type="text" class="form-control" name="user_email" value="<?=$row['user_email'];?>">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="form-group col">
                                    <label for="">Organisation Name</label>
                                    <input type="text" class="form-control" name="org_name" value="<?=$row['organisation_name'];?>" readonly>
                                    <input type="hidden" name="user_id" value="<?=$row['user_id'];?>">
                                </div>
                            </div>
                            <?php if ($row['user_type']=='client'){?>
                            <div class="row">
                                <div class="form-group col">
                                    <label for="">Phone Number</label>
                                    <input type="text" class="form-control" name="phone" value="<?=$row['client_mobile'];?>">
                                </div>
                            </div>
                            <?php } ?>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <input type="submit" class="btn btn-primary px-4" value="Save"/>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="edit" class="tab-pane">
                        <form name="update_password_info" id="update_password_info" class="p-3">
                            <h4 class="mb-3 font-weight-semibold text-dark">Change Password</h4>
                            <div id="response-alert-2"></div>
                            <div class="row">
                                <div class="form-group col-md-12 mb-3">
                                    <label for="">Current Password</label>
                                    <input type="password" class="form-control" placeholder="Current Password" name="curr_pwd">
                                    <input type="hidden" value="<?=$row['user_id'];?>" name="user_id">
                                    <input type="hidden" value="<?=$row['user_email'];?>" name="user_email">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 mb-3">
                                    <label for="">New Password</label>
                                    <input type="password" class="form-control" placeholder="New Password" name="new_pwd">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 mb-3">
                                    <label for="">Re New Password</label>
                                    <input type="password" class="form-control" placeholder="Repeat new password" name="rpt_new_pwd">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <input type="submit" class="btn btn-primary px-4" value="Save" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } } ?>
<?php include_once("inc/footer.nav.php"); ?>