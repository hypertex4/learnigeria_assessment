<?php include_once("inc/header.nav.php"); if (!isset($_SESSION['USER_LOGIN'])) header("Location: ./"); ?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Create Assessor</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="dashboard"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>Add Assessor</span></li>
                </ol>
                <span class="sidebar-right-toggle">&nbsp;</span>
            </div>
        </header>
        <div class="row">
            <div class="col-md-6 mx-auto">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">Add new assessor</h2>
                    </header>
                    <form name="create_assessor" id="create_assessor">
                        <div class="card-body">
                            <div id="response-alert"></div>
                            <div class="form-group row pb-3">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">Assessor Full Name <span class="required">*</span></label>
                                        <input type="text" name="fullname" class="form-control" title="Please enter fullname" required />
                                        <input type="hidden" name="client_id" value="<?=$_SESSION['USER_LOGIN']['client_id'];?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">Assessor Email address <span class="required">*</span></label>
                                        <input type="email" name="email" class="form-control" title="Please enter email address" required />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">Assessor Status <span class="required">*</span></label>
                                        <select class="form-control mb-3" name="ass_status" title="" required>
                                            <option value="yes">Active</option>
                                            <option value="no">In-Active</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row pb-3">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">Password <span class="required">*</span></label>
                                        <input type="password" name="password" class="form-control" title="Please enter password" required />
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
                                    <input class="btn btn-primary px-5" type="submit" value="Create Assessor" />
                                </div>
                            </div>
                        </footer>
                    </form>
                </section>
            </div>
        </div>
    </section>
<?php include_once("inc/footer.nav.php"); ?>