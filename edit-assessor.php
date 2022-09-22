<?php include_once("inc/header.nav.php"); ?>
<?php if (!isset($_SESSION['USER_LOGIN'])) header("Location: ../"); ?>
<?php
if (!isset($_GET['u_id']) || $_GET['u_id'] == NULL ) {echo "<script>window.location = 'list-assessor'; </script>";}
else { $u_id = $_GET['u_id']; }
?>
<?php
$res = $client->get_user_by_id($u_id);
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
    ?>
        <section role="main" class="content-body">
            <header class="page-header">
                <h2>Edit Assessor</h2>
                <div class="right-wrapper text-end">
                    <ol class="breadcrumbs">
                        <li><a href="dashboard"><i class="bx bx-home-alt"></i></a></li>
                        <li><span>Edit Assessor</span></li>
                    </ol>
                    <a class="sidebar-right-toggle"></a>
                </div>
            </header>
            <div class="row">
                <div class="col-md-7 mx-auto">
                    <section class="card">
                        <header class="card-header">
                            <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                            <h2 class="card-title"><a href="list-assessor"><i class="fas fa-arrow-left"></i></a>&nbsp;&nbsp;&nbsp;Edit Assessor Profile</h2>
                        </header>
                        <form name="update_profile_by_user_id" id="update_profile_by_user_id">
                            <div class="card-body">
                                <div id="response-alert"></div>
                                <div class="form-group row pb-3">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">Assessor Full Name <span class="required">*</span></label>
                                            <input type="text" name="fullname" class="form-control" value="<?=$row['user_name'];?>" required />
                                            <input type="hidden" name="user_id" value="<?=$row['user_id'];?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row pb-3">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">Assessor Email address <span class="required">*</span></label>
                                            <input type="email" name="email" class="form-control" value="<?=$row['user_email'];?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row pb-3">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">Assessor Status <span class="required">*</span></label>
                                            <select class="form-control mb-3" name="ass_status" title="" required>
                                                <option value="yes" <?=($row['user_active']=='yes')?'selected':'';?>>Active</option>
                                                <option value="no" <?=($row['user_active']=='no')?'selected':'';?>>In-Active</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <input class="btn btn-primary px-5" type="submit" value="Update Profile" />
                                    </div>
                                </div>
                            </footer>
                        </form>
                    </section>
                    <section class="card">
                        <header class="card-header">
                            <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                            <h2 class="card-title"><a href="list-assessor"><i class="fas fa-arrow-left"></i></a>&nbsp;&nbsp;&nbsp;Password Settings</h2>
                        </header>
                        <form id="update_password_by_user_id" name="update_password_by_user_id">
                            <div class="card-body">
                                <div id="response-alert-2"></div>
                                <div class="form-group row pb-3">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">Password <span class="required">*</span></label>
                                            <input type="password" name="password" class="form-control" title="Please enter password" required />
                                            <input type="hidden" name="user_id" value="<?=$row['user_id']?>">
                                            <input type="hidden" name="user_email" value="<?=$row['user_email']?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">Confirm Password <span class="required">*</span></label>
                                            <input type="password" name="confirm_password" class="form-control" title="Please confirm new password" required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <input class="btn btn-primary px-5" type="submit" value="Update Password" />
                                    </div>
                                </div>
                            </footer>
                        </form>
                    </section>
                </div>
            </div>
        </section>
    <?php } } else { include_once("404.php"); } ?>
<?php include_once("inc/footer.nav.php"); ?>